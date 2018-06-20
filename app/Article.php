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
		
		public function prepare() {
			if ( empty($this->alias) AND !empty($this->name) ) {
				$this->alias = Str::slug($this->name);
			}
			if ( empty($this->state) ) {
				$this->state = 0;
			}
			
			return $this;
		}
	}
