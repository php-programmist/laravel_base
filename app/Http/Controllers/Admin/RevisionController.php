<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Revision;

class RevisionController extends AdminController
{
    public function index($article_id)
    {
        $article   = Article::find($article_id);
        $revisions = Revision::getRevisionsOfArticle($article_id);
    
        $this->vars     = compact('article', 'revisions');
        $this->title    = $article->name . ". " . __('system.revisions');
        $this->template = 'admin.revisions';
        
        return $this->renderOutput();
    }
    
    public function restore($revision_id)
    {
        $revision = Revision::withoutGlobalScope('active')->whereId($revision_id)->first();
        try{
            $revision->restore();
        } catch (\Exception $e){
            return redirect()->back()->with(['error' => __('system.errors_occurred') . ": " . $e->getMessage()]);
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
