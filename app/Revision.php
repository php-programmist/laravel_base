<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $article;
    
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
            if ($id = $this->checkRevision()) {
                return $id;
            } else {
                $this->save();
                
                return $this->id;
            }
        } else {
            return 0;
        }
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
    
    protected function checkRevision()
    {
        return self::query()
                   ->where('sha1_hash', $this->sha1_hash)
                   ->where('article_id', $this->article->id)
                   ->value('id');
    }
}
