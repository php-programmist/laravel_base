<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class AdminTagController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags               = Tag::orderBy('id')->paginate(config('settings.admin_pagination', 15));
        $this->vars['tags'] = $tags;
        $this->title        = __('system.tags_list');
        $this->template     = 'admin.tags';
        
        return $this->renderOutput();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag               = new Tag();
        $this->vars['tag'] = $tag;
        $this->title       = __('system.tag_add');
        $this->template    = 'admin.tag';
        
        return $this->renderOutput();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag();
        $tag->setTitle($request->get('title'));
        try{
            $tag->save();
        } catch (\Exception $e){
            session()->flash('error', __('system.errors_occurred'));
        }
        
        $task = $request->get('task');
        
        return task_route($task, 'admin.tags', __('system.tag_created'), $tag->id);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $this->vars['tag'] = $tag;
        $this->title       = __('system.tag_edit');
        $this->template    = 'admin.tag';
        
        return $this->renderOutput();
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $tag->setTitle($request->get('title'));
        try{
            $tag->save();
        } catch (\Exception $e){
            session()->flash('error', __('system.errors_occurred'));
        }
        
        $task = $request->get('task');
        
        return task_route($task, 'admin.tags', __('system.tag_updated'), $tag->id);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //$tag = Tag::findOrFail($id);
        
        try{
            $tag->delete();
        } catch (\Exception $e){
            \Session::flash('error', $e->getMessage());
        }
        
        return redirect()->back()->with(['success' => __('system.tag_deleted')]);
    }
}
