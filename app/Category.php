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
				$original = $this->getOriginal()['parent_id'];
				if ( $original != $this->id ) {
					$this->parent_id = $original;
				}
				else {
					$this->parent_id = 0;
				}
			}
			elseif ( $this->id > 0 AND $this->parent_id > 0 ) {
				
				if ( !$this->checkParent($this->parent_id) ) {
					$original = $this->getOriginal()['parent_id'];
					if ( $original != $this->id AND $this->checkParent($original) ) {
						$this->parent_id = $original;
					}
					else {
						$this->parent_id = 0;
					}
				}
			}
			
			return $this;
		}
		
		private function checkParent($parent_id) {
			
			$parent_id = \DB::table('categories')
				->where('id', $parent_id)
				->value('parent_id');
			
			if ( $parent_id == 0 ) {
				return true;
			}
			elseif ( $parent_id == $this->id ) {
				
				return false;
			}
			else {
				return $this->checkParent($parent_id);
			}
		}
	}
