<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	
	class Category extends Model {
		protected $fillable = [
			'title', 'alias', 'parent_id', 'state',
		];
		
		public function articles() {
			return $this->hasMany('App\Article');
		}
		
		public function children() {
			return $this->hasMany('App\Category', 'parent_id');
		}
		
		public function prepare($request) {
			if ( empty($this->alias) AND !empty($this->title) ) {
				$this->alias = str_slug($this->title);
			}
			if ( empty($this->state) ) {
				$this->state = 0;
			}
			if ( !$request->has('parent_id') AND empty($this->parent_id) ) {
				$this->parent_id = 0;
			}
			if ( $this->id > 0 AND $this->parent_id == $this->id ) {
				$this->parent_id = 0;
			}
			
			return $this;
		}
	}
