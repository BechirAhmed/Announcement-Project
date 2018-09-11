<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class RegionsController extends Controller
{

    /**
     * Display a listing of the regions.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $regions = Region::paginate(25);

        return view('regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new region.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('regions.create');
    }

    /**
     * Store a new region in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            Region::create($data);

            return redirect()->route('regions.region.index')
                             ->with('success_message', 'Region was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified region.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $region = Region::findOrFail($id);

        return view('regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified region.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $region = Region::findOrFail($id);
        

        return view('regions.edit', compact('region'));
    }

    /**
     * Update the specified region in the storage.
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
            
            $region = Region::findOrFail($id);
            $region->update($data);

            return redirect()->route('regions.region.index')
                             ->with('success_message', 'Region was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified region from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $region = Region::findOrFail($id);
            $region->delete();

            return redirect()->route('regions.region.index')
                             ->with('success_message', 'Region was successfully deleted!');

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
            'image' => ['file','nullable'],
            'slug' => 'string|min:1|nullable',
            'name' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable',
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
