<?php
	
	namespace App;
    
    use App\Helpers\ImageHelper;
    use Illuminate\Database\Eloquent\Model;

    class Article extends Model
    {
        protected $fillable = [
            'name',
            'alias',
            'image',
            'intro_text',
            'full_text',
            'state',
            'user_id',
            'category_id',
        ];
    
        public $versioned = ['name', 'alias', 'intro_text', 'full_text', 'user_id', 'category_id'];
    
        public function user()
        {
            return $this->belongsTo('App\User');
        }
    
        public function category()
        {
            return $this->belongsTo('App\Category');
        }
    
        public function comments()
        {
            return $this->hasMany('App\Comment');
        }
    
        public function revisions()
        {
            return $this->hasMany('App\Revision')->orderBy('id', 'desc');
        }
    
        /*public function revision()
        {
            return $this->belongsTo('App\Revision');
        }*/
    
        public function tags()
        {
            return $this->belongsToMany('App\Tag', 'article_tag', 'article_id', 'tag_id');
        }
    
        public function prepare($request)
        {
            if (empty($this->alias) AND ! empty($this->name)) {
                $this->alias = str_slug($this->name);
            }
            if (empty($this->state)) {
                $this->state = 0;
            }
            if (empty($this->category_id)) {
                $this->category_id = 1;
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file->isValid() AND strstr($file->getClientMimeType(), 'image/')) {
                    $old_image   = $this->image;
                    $path        = 'images/articles';
                    $this->image = ImageHelper::uploadImage($file, $path);
                    if ($old_image) {
                        if (file_exists(public_path($path) . '/' . $old_image)) {
                            unlink(public_path($path) . '/' . $old_image);
                        }
                    }
                }
            }
        
            return $this;
        }
    
    }
