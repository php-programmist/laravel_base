<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	use Intervention\Image\Facades\Image;
	
	class Article extends Model {
		protected $fillable = [
			'name', 'alias', 'image', 'intro_text', 'full_text', 'state', 'user_id',
		];
		
		public function user() {
			return $this->belongsTo('App\User');
		}
		
		public function prepare($request) {
			if ( empty($this->alias) AND !empty($this->name) ) {
				$this->alias = Str::slug($this->name);
			}
			if ( empty($this->state) ) {
				$this->state = 0;
			}
			
			if ( $request->hasFile('image') ) {
				$file = $request->file('image');
				if ( strstr($file->getClientMimeType(), 'image/') ) {
					$image_name = time() . '_' . $file->getClientOriginalName();
					if ( !file_exists(public_path('images')) ) {
						mkdir(public_path('images'), 0777);
					}
					
					try {
						$file->move(public_path('images'), $image_name);
						$image = Image::make(public_path('images') . DIRECTORY_SEPARATOR . $image_name);
						$image->fit(750, 300, function ($constraint) {
							$constraint->upsize();
						});
						$image->save(public_path('images') . DIRECTORY_SEPARATOR . $image_name);
					}
					catch (\Exception $e) {
						\Session::flash('error', __('system.image_resize_error'));
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
