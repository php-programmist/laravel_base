<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Menu extends Model {
		protected $fillable = [
			'title', 'parent_id', 'element',
		];
		public function children() {
			return $this->hasMany('App\Menu', 'parent_id');
		}
		
		public function prepare($request){
			switch( $this->element ){
				case 'article':
					$this->path = $request->article;
					break;
				case 'category':
					$this->path = $request->category;
					break;
				case 'custom':
					$this->path = $request->path;
					break;
				case 'contact':
					$this->path = route('contacts', [], false);
					break;
				default:
					$this->path = '/';
			}
			
			if( !$request->has('parent_id') AND empty($this->parent_id) ){
				$this->parent_id = 0;
			}
			if( $this->id > 0 AND $this->parent_id == $this->id ){
				$original = $this->getOriginal()['parent_id'];
				if( $original != $this->id ){
					$this->parent_id = $original;
				}
				else{
					$this->parent_id = 0;
				}
			}
			elseif( $this->id > 0 AND $this->parent_id > 0 ){
				
				if( !$this->checkParent($this->parent_id) ){
					$original = $this->getOriginal()['parent_id'];
					if( $original != $this->id AND $this->checkParent($original) ){
						$this->parent_id = $original;
					}
					else{
						$this->parent_id = 0;
					}
				}
			}
			if( $this->id == 0 OR $this->getOriginal()['parent_id'] != $this->parent_id ){
				$this->ordering = $this->getNewOrdering($this->parent_id);
			}
			
			return $this;
		}
		
		private function checkParent($parent_id){
			
			$parent_id = \DB::table('menus')
			                ->where('id', $parent_id)
			                ->value('parent_id');
			
			if( $parent_id == 0 ){
				return true;
			}
			elseif( $parent_id == $this->id ){
				
				return false;
			}
			else{
				return $this->checkParent($parent_id);
			}
		}
		
		private function getNewOrdering($parent_id){
			
			$ordering = \DB::table('menus')
			               ->where('parent_id', $parent_id)
			               ->max('ordering');
			$ordering++;
			
			return $ordering;
		}
	}
