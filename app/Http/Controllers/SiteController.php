<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	
	class SiteController extends Controller {
		protected $template;
		protected $vars = array();
		
		public function __construct() {
		
		}
		
		
		protected function renderOutput() {
			
			$navigation = \Cache::remember('menus', config('settings.cache_menus', 0), function () {
				$menu = $this->getMenu();
				try {
					return view('site.layouts.navigation')->with([ 'menu' => $menu ])->render();
				}
				catch (\Throwable $e) {
					\Session::flash('message', $e->getMessage());
					
					return false;
				}
			});
			
			$this->vars = array_add($this->vars, 'categories', $this->getCategories());
			$this->vars = array_add($this->vars, 'navigation', $navigation);
			
			return view($this->template)->with($this->vars);
		}
		
		protected function getMenu() {
			
			$menu     = \App\Menu::where('parent_id', 0)->orderBy('ordering')->get();
			$mBuilder = \Menu::make('main_menu', function ($m) use ($menu) {
				
				foreach ($menu as $item) {
					
					$item->path = ltrim($item->path, '\/');
					
					$m->add($item->title, $item->path)->id($item->id);
					foreach ($item->children()->orderBy('ordering')->get() as $child) {
						$child->path = ltrim($child->path, '\/');
						$m->find($item->id)->add($child->title, $child->path)->id($child->id);
						
						foreach ($child->children()->orderBy('ordering')->get() as $sub_child) {
							$sub_child->path = ltrim($sub_child->path, '\/');
							$m->find($child->id)->add($sub_child->title, $sub_child->path)->id($sub_child->id);
						}
					}
					
				}
				
			});
			
			
			return $mBuilder;
		}
		
		protected function getCategories() {
			return \App\Category::where([
				[ 'id', '!=', 1 ],
				[ 'state', 1 ],
			])->orderBy('id')->get();
		}
	}
