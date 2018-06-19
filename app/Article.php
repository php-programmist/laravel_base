<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Str;
	class Article extends Model {
		protected $fillable = [
			'name', 'alias', 'image', 'intro_text', 'full_text', 'state', 'user_id',
		];
		
		public function user() {
			return $this->belongsTo('App\User');
		}
		
		public function fill(array $attributes) {
			$model = parent::fill($attributes);
			if ( empty($model->alias) ) {
				$model->alias = Str::slug($model->name);
			}
			if ( empty($model->state) ) {
				$model->state = 0;
			}
			
			return $model;
		}
	}
