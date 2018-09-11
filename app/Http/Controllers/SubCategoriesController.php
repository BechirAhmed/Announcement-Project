<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class SubCategoriesController extends Controller
{

    protected $categoryModel;

    public function __construct(Category $categoryModel)
    {

        $this->categoryModel = $categoryModel;
    }

    /**
     * Display a listing of the sub categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $subCategories = subCategory::with('category')->paginate(10);

        return view('sub_categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new sub category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
//        $categories = Category::pluck('name','id')->all();
        $categories = $this->categoryModel->getCategories();

        return view('sub_categories.create', compact('categories'));
    }

    /**
     * Store a new sub category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $subCategory = subCategory::create($data);
            $subCategory->categories()->attach($request->category_id);

            return redirect()->route('sub_categories.sub_category.index')
                             ->with('success_message', 'Sub Category was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified sub category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $subCategory = subCategory::with('category')->findOrFail($id);

        return view('sub_categories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified sub category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $subCategory = subCategory::findOrFail($id);
//        $categories = Category::pluck('name','id')->all();
        $categories = $this->categoryModel->getCategories();

        return view('sub_categories.edit', compact('subCategory','categories'));
    }

    /**
     * Update the specified sub category in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            $subCategory = subCategory::findOrFail($id);
            $subCategory->update($data);

            return redirect()->route('sub_categories.sub_category.index')
                             ->with('success_message', 'Sub Category was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified sub category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $subCategory = subCategory::findOrFail($id);
            $subCategory->delete();

            return redirect()->route('sub_categories.sub_category.index')
                             ->with('success_message', 'Sub Category was successfully deleted!');

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
            'name' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'image' => ['file','nullable'],
            'is_active' => 'boolean|nullable',
     
        ];

        
        $data = $request->validate($rules);

        if ($request->has('custom_delete_image')) {
            $data['image'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $this->moveFile($request->file('image'));
        }

        $data['is_active'] = $request->has('is_active');


        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }
        
        return $file->store(config('codegenerator_custom.files_upload_path'), config('filesystems.default'));
    }
}
