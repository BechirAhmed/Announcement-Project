<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\ImageUpload;
use App\Models\SubCategory;
use App\Models\UnitRelated;
use App\Models\Region;
use Carbon\Carbon;
use function foo\func;
use Image;
use File;
use Illuminate\Http\Request;
use Redirect;
use Storage;
use DB;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use Cviebrock\EloquentSluggable\Sluggable;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    private $photos_path;
    private $productModel;
    private $imageModel;

    public function __construct(Product $productModel, ImageUpload $imageModel)
    {
        $this->photos_path = public_path('/images');
//        $this->middleware('auth');

        $this->productModel = $productModel;
        $this->imageModel   = $imageModel;
    }

    /**
     * Display a listing of the products.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

//        $userProducts = $user->products();
        $userProducts   = Product::where('user_id', Auth::user()->id)
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(10);

        $allProducts    = Product::all();
        $activeProducts = Product::where('is_active', true)->orderBy('created_at', 'desc')->paginate(10);
        $notActProducts = Product::where('is_active', false)->orderBy('created_at', 'desc')->paginate(10);
        $preferredProducts = Product::where('is_active', true)->where('preferred', true)->orderBy('created_at', 'desc')->paginate(10);
        $photos         = ImageUpload::all();
        $categories     = Category::all();
        $subCategories  = subCategory::all();
        $unitRelateds    = $this->productModel->unitRelateds();
        $users          = User::all();

        return view('products.index', compact('users', 'allProducts', 'userProducts', 'activeProducts', 'notActProducts', 'preferredProducts', 'photos', 'categories', 'subCategories', 'subCategory', 'unitRelateds'));

    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()){
            $products = DB::table('products')
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select(['products.id AS product_id', 'products.name AS product_name', 'products.price AS p_price', 'products.created_at AS p_created', 'products.preferred', 'products.sku', 'products.slug', 'products.description', 'products.is_active', 'products.sold', 'users.name', 'users.id AS user_id']);
            return DataTables::of($products)
                ->addColumn('product_name', function ($products){
                    return '<a href="'.route('products.product.show', $products->product_id).'" target="_blanc">'.$products->product_name.'</a>';
                })->editColumn('p_created', function ($products){
                    Carbon::setLocale("fr");
                    $now = Carbon::now();
                    $created_at = Carbon::parse($products->p_created);
                    $created = $created_at->diffForHumans($now);
                    return "$created";
                })->editColumn('edit', function ($products){
                    return "<a href='".route('products.product.edit', $products->product_id)."' class='button is-warning is-small' target=\"_blanc\">Edit</a>";
                })->rawColumns([
                    'product_name',
                    'edit'
                ])->make(true);
        }

    }

    /**
     * Show the form for creating a new product.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $subCategories = SubCategory::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        $unitRelateds = UnitRelated::pluck('name','id')->all();
        $regions = Region::pluck('name','id')->all();
        $photos = ImageUpload::all();

        $categories = Category::all();
        $checkedSubCategories = [];
        $checkedUnits = [];
        $checkedRegions = [];

        return view('products.create', compact('photos','subCategories','users','unitRelateds', 'categories', 'regions', 'checkedSubCategories', 'checkedUnits', 'checkedRegions'));
    }

    /**
     * Store a new product in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            $product = new Product();
//            $product->slug = $request->slug;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->count = $request->count;
            $product->color = $request->color;

            $product->user_id = $request->user()->id;

            // Generate sku for each product
            $length = 6;
            $keyspace = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
            $str = '';
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i=0; $i < $length; ++$i) {
                $str .= $keyspace[random_int(0, $max)];
            }

            $product->sku = $str;

            $product->save();
            $product->subCategories()->attach($request->sub_category_id);
            $product->regions()->attach($request->region_id);
            $product->unitRelateds()->attach($request->unit_related_id);
            $product->slug;

            $newProduct = $product->replicate();

            if ($newProduct){
                return response()->json([
                    'success' => 'Product was successfully added!',
                    'product_id' => $product->id
                ]);
            } else{
                return response()->json(['error' => 'Product failed to added!']);
            }
//        return redirect()->route('public.home', compact('userProducts'));


//            return redirect()->route('products.product.index')
//                ->with('success_message', 'Product was successfully added!');

//        } catch (Exception $exception) {


//            return back()->withInput()
//                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
//        }
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $photos = ImageUpload::findOrFail($id);

        return view('products.show', compact('product', 'photos','subCategories','users','unitRelateds', 'categories', 'regions'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $subCategories = SubCategory::pluck('name','id')->all();
        $users = User::pluck('name','id')->all();
        $unitRelateds = UnitRelated::pluck('name','id')->all();
        $regions = Region::pluck('name','id')->all();
        $photos = ImageUpload::find($id);
        $categories = Category::all();
        $checkedSubCategories = $product->subCategories->pluck('id')->toArray();
        $checkedUnits = $product->unitRelateds->pluck('id')->toArray();
        $checkedRegions = $product->regions->pluck('id')->toArray();

        return view('products.edit', compact('photos','product','subCategories','users','unitRelateds', 'categories', 'regions', 'checkedSubCategories', 'checkedUnits', 'checkedRegions'));
    }

    /**
     * Update the specified product in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $product = $this->productModel->findOrFail($id);
//            $product->slug = $request->slug;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->count = $request->count;
        $product->color = $request->color;

        $product->is_active = $request->is_active;
        $product->preferred = $request->preferred;

        $product->touch();
        $product->save();
        $product->subCategories()->sync($request->sub_category_id);
        $product->regions()->sync($request->region_id);
        $product->unitRelateds()->sync($request->unit_related_id);
        $product->slug;

        return redirect()->route('products.product.index')
                             ->with('success_message', 'Product was successfully updated!');

//        try {
//
//            $data = $this->getData($request);
//
//            $product = Product::findOrFail($id);
//            $product->update($data);
//            $product->subCategories()->sync($request->sub_category_id);
//            $product->regions()->sync($request->region_id);
//            $product->unitRelateds()->sync($request->unit_related_id);
//
//
//            return redirect()->route('products.product.index')
//                             ->with('success_message', 'Product was successfully updated!');
//
//        } catch (Exception $exception) {
//
//            return back()->withInput()
//                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
//        }
    }

    /**
     * Remove the specified product from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.product.index')
                             ->with('success_message', 'Product was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
    * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'slug' => 'string|min:1|nullable',
            'user_id' => 'nullable',
            'name' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'price' => 'string|min:1|nullable',
            'discount' => 'string|min:1|nullable',
            'count' => 'numeric|nullable',
            'color' => 'string|min:1|nullable',
            'preferred' => 'boolean|nullable',
            'sku' => 'string|min:6|nullable',
            'is_active' => 'boolean|nullable',

        ];


        $data = $request->validate($rules);


        $data['is_active'] = $request->has('is_active');
        $data['user_id'] = $request->user()->id;

        // Generate sku for each product
        $length = 6;
        $keyspace = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i=0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $data['sku'] = $str;


        return $data;
    }

    public function changeStatus()
    {
        $id = \Input::get('id');

        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return \response()->json($product);
    }

    public function soldStatus()
    {
        $id = \Input::get('id');

        $product = Product::findOrFail($id);
        $product->sold = !$product->sold;
        $product->save();

        return \response()->json($product);
    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImages(Request $request, $id)
    {
        $photos = $request->file('file');
        $product = Product::findOrFail($id);

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

            Image::make($photo)->resize(250, 200, function ($constraints) {
                $constraints->aspectRatio();
            })
                ->save($this->photos_path . '/' . $resize_name);

            $photo->move($this->photos_path, $save_name);

            $upload = new ImageUpload();
            $upload->product_id = $product->id;
            $upload->image_name = $save_name;
            $upload->resized_name = $resize_name;
            $upload->original_name = basename($photo->getClientOriginalName());
            $upload->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function destroyImages(Request $request)
    {
        $filename = $request->id;
        $uploaded_image = ImageUpload::where('original_name', basename($filename))->first();

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;

//        if (file_exists($file_path)) {
//            unlink($file_path);
//        }
//
//        if (file_exists($resized_file)) {
//            unlink($resized_file);
//        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }
}
