<?php

namespace App\Http\Controllers;

use App\Models\UnitRelated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class UnitRelatedsController extends Controller
{

    /**
     * Display a listing of the unit relateds.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $unitRelateds = UnitRelated::paginate(25);

        return view('unit_relateds.index', compact('unitRelateds'));
    }

    /**
     * Show the form for creating a new unit related.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('unit_relateds.create');
    }

    /**
     * Store a new unit related in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            UnitRelated::create($data);

            return redirect()->route('unit_relateds.unit_related.index')
                             ->with('success_message', trans('unit_relateds.model_was_added'));

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => trans('unit_relateds.unexpected_error')]);
        }
    }

    /**
     * Display the specified unit related.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $unitRelated = UnitRelated::findOrFail($id);

        return view('unit_relateds.show', compact('unitRelated'));
    }

    /**
     * Show the form for editing the specified unit related.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $unitRelated = UnitRelated::findOrFail($id);
        

        return view('unit_relateds.edit', compact('unitRelated'));
    }

    /**
     * Update the specified unit related in the storage.
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
            
            $unitRelated = UnitRelated::findOrFail($id);
            $unitRelated->update($data);

            return redirect()->route('unit_relateds.unit_related.index')
                             ->with('success_message', trans('unit_relateds.model_was_updated'));

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => trans('unit_relateds.unexpected_error')]);
        }        
    }

    /**
     * Remove the specified unit related from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $unitRelated = UnitRelated::findOrFail($id);
            $unitRelated->delete();

            return redirect()->route('unit_relateds.unit_related.index')
                             ->with('success_message', trans('unit_relateds.model_was_deleted'));

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => trans('unit_relateds.unexpected_error')]);
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
            'name' => 'string|min:1|max:255|nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'is_active' => 'boolean|nullable',
     
        ];

        
        $data = $request->validate($rules);


        $data['is_active'] = $request->has('is_active');


        return $data;
    }

}
