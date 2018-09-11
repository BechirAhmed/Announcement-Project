<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use App\Models\User;
use App\Models\Product;
use App\Models\ImageUpload;
use App\Models\SubCategory;
use App\Models\UnitRelated;
use App\Notifications\UserFollowed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Image;
use Input;

class WelcomeController extends Controller
{
    use Notifiable;

    protected $categoryModel;
    protected $subCategoryModel;
    protected $regionModel;
    protected $productModel;
    protected $userModel;

    public function __construct(Product $productModel ,subCategory $subCategoryModel, Category $categoryModel, Region $regionModel, User $userModel)
    {
        $this->regionModel = $regionModel;
        $this->categoryModel = $categoryModel;
        $this->subCategoryModel = $subCategoryModel;
        $this->productModel = $productModel;
        $this->userModel = $userModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome(Request $request)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $regions = Region::pluck('name','id')->all();
        $region_id = $request->region_id;
        $photos = ImageUpload::all();
        $products = Product::where('is_active', true)->where('sold', false)->orderBy('created_at', 'desc')->paginate(10);
        $preferrefProducts = Product::where('is_active', true)->where('sold', false)->where('preferred', true)->orderBy('created_at', 'desc')->paginate(10);

        return view('welcome', compact('products','preferrefProducts', 'photos', 'region_id', 'categories', 'subCategories', 'regions'));
    }

    public function product($catSlug, $subCatSlug, $slug, $id){

        $product = $this->productModel->getProductBySlug($slug);
        $user = $product->user;
        $regions = Region::pluck('name', 'id')->all();
        $categories = Category::all();
        $photos = ImageUpload::all();

        $relatedSubCategories = $product->subCategories->modelkeys();
        $relatedProducts = Product::whereHas('subcategories', function ($q) use ($relatedSubCategories) {
            $q->whereIn('sub_categories.id', $relatedSubCategories);
        })->where('id', '<>', $product->id)->where('is_active', true)->get();
        $currentUserProducts = Product::where('user_id', $user->id)->where('is_active', true)->paginate(10);
        return view('product', compact('product', 'regions', 'categories', 'photos', 'relatedProducts', 'relatedSubCategories', 'currentUserProducts', 'user'));
    }

    public function showCategory($catSlug)
    {
        $categories = Category::all();
        $category = $this->categoryModel->getCategoryBySlug($catSlug);

        $regions = Region::pluck('name','id')->all();

        return view('category', compact('category','products','photos', 'categories', 'regions'));
    }

    public function showSubCategory($catSlug, $slug)
    {
        $categories = Category::all();
        $subCategory = $this->subCategoryModel->getSubCategoryBySlug($slug);
        $products = $this->subCategoryModel->getProductsList($subCategory);
        $category = $this->categoryModel->getCategoryBySlug($catSlug);
        $regions = Region::pluck('name','id')->all();
        return view('sub_category', compact( 'products', 'photos', 'category', 'categories', 'regions', 'subCategory'));
    }

    public function showStores()
    {
        if (\Auth::user()){
            $users = User::where('id', '!=', auth()->user()->id)->get();
        }else{
            $users = User::all();
        }
        $products = Product::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $regions = Region::pluck('name','id')->all();

        return view('stores.index', compact('users', 'products', 'regions', 'categories', 'subCategories'));
    }

    public function showStorePage($userName)
    {
        $user = $this->userModel->getUserByName($userName);
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $regions = Region::pluck('name','id')->all();
        $photos = ImageUpload::all();

        return view('stores.store', compact('user',  'regions', 'categories', 'subCategories', 'photos'));
    }

    public function Search(Request $request)
    {
        if($request->has('s')){
//            $products = Product::search($request->get('s'))->get();
            $products = Product::search($request->get('s'))
                                    ->with('subCategory')
//                                    ->where('name', $request->get('s'))
                                    ->where('is_active', true)
                                    ->get();
        }else{
            $products = Product::get();
        }
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $regions = Region::pluck('name','id')->all();
        $photos = ImageUpload::all();

        return view('search', compact('products', 'categories', 'subCategories', 'regions', 'photos'));
    }

    public function follow(User $user)
    {
        $follower = auth()->user();
        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }
        if(!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification
            $user->notify(new UserFollowed($follower));

            return back()->withSuccess("You are now friends with {$user->name}");
        }
        return back()->withError("You are already following {$user->name}");
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if($follower->isFollowing($user->id)) {
            $follower->unfollow($user->id);
            return back()->withSuccess("You are no longer friends with {$user->name}");
        }
        return back()->withError("You are not following {$user->name}");
    }


    /**
     * Show user avatar.
     *
     * @param $id
     * @param $image
     *
     * @return string
     */
    public function userProfileAvatar($id, $image)
    {
        return Image::make(storage_path().'/users/id/'.$id.'/uploads/images/avatar/'.$image)->response();
    }
    /**
     * Show user cover.
     *
     * @param $id
     * @param $image
     *
     * @return string
     */
    public function userProfileCover($id, $image)
    {
        return Image::make(storage_path().'/users/id/'.$id.'/uploads/images/cover/'.$image)->response();
    }
}
