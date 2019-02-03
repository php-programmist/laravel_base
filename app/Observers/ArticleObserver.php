<?php

namespace App\Observers;

use App\Article;
use App\Revision;

class ArticleObserver
{
    protected $revision;
    
    public function __construct(Revision $revision)
    {
        $this->revision = $revision;
    }
    
    /**
     * Handle to the article "created" event.
     *
     * @param  \App\Article $article
     *
     * @return void
     */
    public function created(Article $article)
    {
        //
    }
    
    /**
     * Handle the article "saved" event.
     *
     * @param  \App\Article $article
     *
     * @return void
     */
    public function saved(Article $article)
    {
        $user_id = \Auth::user()->id;
        $this->revision->makeRevision($article, $user_id);
    }
    
    /**
     * Handle the article "updated" event.
     *
     * @param  \App\Article $article
     *
     * @return void
     */
    public function updated(Article $article)
    {
        $user_id = \Auth::user()->id;
        $this->revision->makeRevision($article, $user_id);
    }
    
    /**
     * Handle the article "deleted" event.
     *
     * @param  \App\Article $article
     *
     * @return void
     */
    public function deleted(Article $article)
    {
        //
    }
}
