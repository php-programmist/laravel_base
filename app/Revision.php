<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $article;
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', 1);
        });
    }
    
    protected function setRevisionData()
    {
        $revision_data = [];
        foreach ($this->article->versioned as $field) {
            if (isset($this->article->$field)) {
                $revision_data[$field] = $this->article->$field;
            }
        }
        $this->revision_data = json_encode($revision_data);
    }
    
    protected function setHash()
    {
        $this->sha1_hash = sha1($this->revision_data);
    }
    
    protected function setUserId($userId)
    {
        $this->user_id = $userId;
    }
    
    protected function setArticleId()
    {
        $this->article_id = $this->article->id;
    }
    
    protected function setActive()
    {
        $this->is_active = 1;
        $this->inactivateOld();
    }
    
    protected function inactivateOld()
    {
        self::query()
            ->ArticleId($this->article->id)
            ->update(['is_active' => 0]);
    }
    
    protected function checkRevision()
    {
        return self::withoutGlobalScope('active')
                   ->where('sha1_hash', $this->sha1_hash)
                   ->ArticleId($this->article->id)
                   ->value('id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
    
    public function makeRevision(Article $article, $user_id)
    {
        $this->article = $article;
        if ( ! empty($article->versioned) AND is_array($article->versioned)) {
            $this->setRevisionData();
            $this->setHash();
            $this->setUserId($user_id);
            $this->setArticleId();
            $this->setActive();
            if ($id = $this->checkRevision()) {
                $this->id     = $id;
                $this->exists = true;
            }
            $this->save();
        }
    }
    
    public function scopeArticleId($query, $article_id)
    {
        return $query->where('article_id', $article_id);
    }
    
    public static function getRevisionsOfArticle($article_id)
    {
        return self::withoutGlobalScope('active')
                   ->ArticleId($article_id)
                   ->with('user')
                   ->latest()
                   ->get();
    }
    
    public function restore()
    {
        $revision_data = (array)json_decode($this->revision_data);
        $article       = $this->article()->first();
        $article->fill($revision_data);
        
        return $article->save();
    }
}
