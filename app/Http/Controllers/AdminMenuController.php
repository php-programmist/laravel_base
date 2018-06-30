<?php
	
	namespace App\Http\Controllers;
	
	use App\Menu;
	use Illuminate\Http\Request;
	
	class AdminMenuController extends AdminController{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(){
			if( !\Auth::user()->canDo('VIEW_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_view') ]);
			}
			
			$menus = self::getMenusTree('<span class="menuLevel">&nbsp;&nbsp;&nbsp;<sup>|_</sup>&nbsp;</span>');
			
			$this->vars['menus'] = $menus;
			$this->title         = __('system.menus_list');
			$this->template      = 'admin.menus';
			
			return $this->renderOutput();
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create(){
			if( !\Auth::user()->canDo('ADD_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			
			$this->vars['menus']      = self::getMenusList();
			$this->vars['menu']       = new Menu();
			$this->vars['articles']   = $this->getArticlesList();
			$this->vars['categories'] = $this->getCategoriesList();
			$this->vars['elements']   = $this->getElements();
			
			$this->title    = __('system.add_menu');
			$this->template = 'admin.menu';
			
			return $this->renderOutput();
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request){
			if( !\Auth::user()->canDo('ADD_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			$request->validate([
				                   'title'    => 'required|max:255',
				                   'element'  => 'required',
				                   'article'  => 'required_if:element,article',
				                   'category' => 'required_if:element,category',
				                   'path'     => 'required_if:element,custom|max:255',
			                   ]);
			
			$data = $request->only([ 'title', 'parent_id', 'element', 'task' ]);
			
			$menu = new Menu();
			$menu->fill($data);
			
			$menu->prepare($request);
			
			$menu->save();
			
			return task_route($data['task'], 'admin.menus', __('system.menu_created'), $menu->id);
		}
	
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  \App\Menu $menu
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Menu $menu){
			if( !\Auth::user()->canDo('EDIT_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			
			$this->vars['menus']      = self::getMenusList();
			$this->vars['menu']       = $menu;
			$this->vars['articles']   = $this->getArticlesList();
			$this->vars['categories'] = $this->getCategoriesList();
			$this->vars['elements']   = $this->getElements();
			
			$this->title    = __('system.edit_menu');
			$this->template = 'admin.menu';
			
			return $this->renderOutput();
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \App\Menu                $menu
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Menu $menu){
			if( !\Auth::user()->canDo('EDIT_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			$request->validate([
				                   'title'    => 'required|max:255',
				                   'element'  => 'required',
				                   'article'  => 'required_if:element,article',
				                   'category' => 'required_if:element,category',
				                   'path'     => 'required_if:element,custom|max:255',
			                   ]);
			
			$data = $request->only([ 'title', 'parent_id', 'element', 'task' ]);
			
			$menu->fill($data);
			
			$menu->prepare($request);
			
			$menu->save();
			
			return task_route($data['task'], 'admin.menus', __('system.menu_updated'), $menu->id);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\Menu $menu
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Menu $menu){
			if( !\Auth::user()->canDo('DELETE_MENU') ){
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			try{
				if( count($menu->children) ){
					foreach( $menu->children as $child ){
						if( count($child->children) ){
							foreach( $child->children as $grand_child ){
								$grand_child->delete();
							}
						}
						$child->delete();
					}
				}
				$menu->delete();
			}
			catch( \Exception $e ){
				\Session::flash('error', $e->getMessage());
			}
			
			return redirect()->back()->with([ 'message' => __('system.menu_deleted') ]);
		}
		
		public static function getMenusList(){
			$menus_list[0] = __('system.no_parent_menu');
			
			$menus = self::getMenusTree('- ', 0, 2);
			foreach( $menus as $menu ){
				$menus_list[ $menu->id ] = $menu->level_delimiter . " " . $menu->title;
			}
			
			return $menus_list;
		}
		
		public static function getMenusTree($level_delimiter = '-', $first_parent_id = 0, $max_level = 0){
			$menus = Menu::orderBy('ordering')->get();
			$menus->map(function($menu){
				$menu->link = strstr($menu->path, 'http') ? $menu->path : url(ltrim($menu->path, '\/'));
			});
			$groupped_menus = $menus->groupBy('parent_id');
			$new_collection = collect();
			
			return self::appendChildrenRecurs($groupped_menus, $first_parent_id, $new_collection, -1, $level_delimiter, $max_level);
		}
		
		public static function appendChildrenRecurs($groupped_menus, $parent_id, $new_collection, $level, $level_delimiter = '-', $max_level){
			$level++;
			if( $max_level AND $max_level == $level ){
				return $new_collection;
			}
			if( !isset($groupped_menus[ $parent_id ]) OR !count($groupped_menus[ $parent_id ]) ){
				return $new_collection;
			}
			foreach( $groupped_menus[ $parent_id ] as $parent ){
				$parent->level_delimiter = str_repeat($level_delimiter, $level);
				if( isset($groupped_menus[ $parent->id ]) ){
					$parent->children_num = count($groupped_menus[ $parent->id ]);
				}
				else{
					$parent->children_num = 0;
				}
				
				$new_collection->push($parent);
				if( isset($groupped_menus[ $parent->id ]) ){
					$new_collection = self::appendChildrenRecurs($groupped_menus, $parent->id, $new_collection, $level, $level_delimiter, $max_level);
				}
			}
			
			return $new_collection;
		}
		
		public function getArticlesList(){
			$articles = \App\Article::all();
			
			$list = $articles->reduce(function($return, $article){
				
				$return[ route('articles', [ 'slug' => $article->id . '-' . $article->alias ], false) ] = $article->name;
				
				return $return;
				
			}, [ route('articlesAll', [], false) => __('system.articles_list') ]);
			
			return array_merge([ '' => __('system.not_chosen') ], $list);
		}
		
		public function getCategoriesList(){
			$categories_list[''] = __('system.not_chosen');
			$categories          = AdminCategoryController::getCategoriesTree();
			foreach( $categories as $category ){
				$categories_list[ route('articlesCat', [ 'slug' => $category->id . '-' . $category->alias ], false) ] = $category->level_delimiter . " " . $category->title;
			}
			
			return $categories_list;
		}
		
		public function getElements(){
			return [
				'custom'   => __('system.custom'),
				'article'  => __('system.article'),
				'category' => __('system.category'),
				'contact'  => __('system.contact'),
			];
		}
	}
