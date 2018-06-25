<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	use Intervention\Image\Facades\Image;
	
	class Article extends Model {
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
		
		public function prepare($request) {
			if ( empty($this->alias) AND !empty($this->name) ) {
				$this->alias = Str::slug($this->name);
			}
			if ( empty($this->state) ) {
				$this->state = 0;
			}
			if ( empty($this->category_id) ) {
				$this->category_id = 1;
			}
			if ( $request->hasFile('image') ) {
				$file = $request->file('image');
				if ( strstr($file->getClientMimeType(), 'image/') ) {
					$image_name = time() . '_' . $file->getClientOriginalName();
					if ( !file_exists(public_path('images')) ) {
						mkdir(public_path('images'), 0777);
					}
					$file->move(public_path('images'), $image_name);
					$image_info       = getimagesize(public_path('images') . DIRECTORY_SEPARATOR . $image_name);
					$max_image_width  = config('settings.max_image_width', 750);
					$max_image_height = config('settings.max_image_height', 300);
					if ( $image_info[0] > $max_image_width OR $image_info[1] > $max_image_height ) {
						try {
							$image = Image::make(public_path('images') . DIRECTORY_SEPARATOR . $image_name);
							$image->fit($max_image_width, $max_image_height, function ($constraint) {
								$constraint->upsize();
							});
							$image->save(public_path('images') . DIRECTORY_SEPARATOR . $image_name);
						}
						catch (\Exception $e) {
							\Session::flash('error', __('system.image_resize_error') . "<br>" . $e->getMessage());
						}
					}
					$old_image   = $this->image;
					$this->image = $image_name;
					if ( $old_image ) {
						if ( file_exists(public_path('images') . DIRECTORY_SEPARATOR . $old_image) ) {
							unlink(public_path('images') . DIRECTORY_SEPARATOR . $old_image);
						}
					}
				}
			}
			
			return $this;
		}
	}
