<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @property int    id
 * @property string title
 * @package App
 */
class Tag extends Model
{
    protected $fillable = [
        'title',
    ];
    
    public function articles()
    {
        return $this->belongsToMany('App\Article', 'article_tag', 'tag_id', 'article_id');
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
