<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Revision;

class RevisionController extends AdminController
{
    public function index($article_id)
    {
        $article = Article::find($article_id);
        $article->load('revisions')->with('user');
        $this->vars['article'] = $article;
        $this->title           = $article->name . ". " . __('system.revisions');
        $this->template        = 'admin.revisions';
        
        return $this->renderOutput();
    }
    
    public function restore($revision_id)
    {
        $revision      = Revision::find($revision_id);
        $article       = $revision->article;
        $revision_data = (array)json_decode($revision->revision_data);
        $article->fill($revision_data);
        try{
            $article->save();
        } catch (\Exception $e){
            session()->flash('error', trans('system.errors_occurred'));
        }
        
        return redirect()->back()->with(['success' => __('system.restore_success')]);
    }
    
    public function destroy($revision_id)
    {
        $revision = Revision::findOrFail($revision_id);
        
        try{
            $revision->delete();
        } catch (\Exception $e){
            \Session::flash('error', $e->getMessage());
        }
        
        return redirect()->back()->with(['success' => __('system.revision_deleted')]);
    }
}
