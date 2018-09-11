<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class CategoriesController extends Controller
{


    protected $subCategoryModel;
    protected $categoryModel;

    public function __construct(subCategory $subCategoryModel, Category $categoryModel)
    {

        $this->subCategoryModel = $subCategoryModel;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Display a listing of the categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('categories.create');
    }

    /**
     * Store a new category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Category::create($data);

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
//        $category = $this->categoryModel->getCategoryById($id);
//        $subCategories = $this->categoryModel->getSubCategories($category);
        $category = Category::findOrFail($id);
        $subCategories = $this->subCategoryModel->getSubCategoriesByCat($id);

        return view('categories.show', compact('category', 'subCategories'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the storage.
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
            
            $category = Category::findOrFail($id);
            $category->update($data);

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('categories.category.index')
                             ->with('success_message', 'Category was successfully deleted!');

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
            'slug' => '',
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
