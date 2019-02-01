<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
    use Intervention\Image\Facades\Image;
    
    class Article extends Model
    {
		protected $fillable = [
			'name', 'alias', 'image', 'intro_text', 'full_text', 'state', 'user_id', 'category_id',
		];
		
		public function user() {
			return $this->belongsTo('App\User');
		}
		
		public function category() {
			return $this->belongsTo('App\Category');
		}
		
		public function comments() {
			return $this->hasMany('App\Comment');
		}
        
        public function tags()
        {
            return $this->belongsToMany('App\Tag', 'article_tag', 'article_id', 'tag_id');
        }
		
		public function prepare($request) {
			if ( empty($this->alias) AND !empty($this->name) ) {
				$this->alias = str_slug($this->name);
			}
			if ( empty($this->state) ) {
				$this->state = 0;
			}
			if ( empty($this->category_id) ) {
				$this->category_id = 1;
			}
			if ( $request->hasFile('image') ) {
				$file = $request->file('image');
				if( $file->isValid() AND strstr($file->getClientMimeType(), 'image/') ){
					$image_name = str_random(6) . '_' . $file->getClientOriginalName();
					if ( !file_exists(public_path('images')) ) {
						mkdir(public_path('images'), 0777);
					}
					if( !file_exists(public_path('images/articles')) ){
						mkdir(public_path('images/articles'), 0777);
					}
					$file->move(public_path('images/articles'), $image_name);
					$image_info       = getimagesize(public_path('images/articles/') . $image_name);
					$max_image_width  = config('settings.max_image_width', 750);
					$max_image_height = config('settings.max_image_height', 300);
					
					if ( $image_info[0] > $max_image_width OR $image_info[1] > $max_image_height ) {
						try {
							$image = Image::make(public_path('images/articles/') . $image_name);
							$image->fit($max_image_width, $max_image_height, function ($constraint) {
								$constraint->upsize();
							});
							$image->save(public_path('images/articles/') . $image_name);
						}
						catch (\Exception $e) {
							\Session::flash('error', __('system.image_resize_error') . "<br>" . $e->getMessage());
						}
					}
					$old_image   = $this->image;
					$this->image = $image_name;
					if ( $old_image ) {
						if( file_exists(public_path('images/articles/') . $old_image) ){
							unlink(public_path('images/articles/') . $old_image);
						}
					}
				}
			}
			
			return $this;
		}
	}
