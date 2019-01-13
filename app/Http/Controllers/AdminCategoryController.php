<?php
	
	namespace App\Http\Controllers;
	
	use App\Category;
    use Illuminate\Http\Request;
    
    class AdminCategoryController extends AdminController
    {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(){
			if( !\Auth::user()->canDo('VIEW_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_view')]);
			}
			$categories = self::getCategoriesTree('<span class="categoryLevel">&nbsp;&nbsp;&nbsp;<sup>|_</sup>&nbsp;</span>');
			
			$this->vars['categories'] = $categories;
			$this->title              = __('system.categories_list');
			$this->template           = 'admin.categories';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create(){
			if( !\Auth::user()->canDo('ADD_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_create')]);
			}
			
			$this->vars['categories'] = self::getCategoriesList();;
			$this->vars['category'] = new Category();;
			$this->title    = __('system.create_category');
			$this->template = 'admin.category';
			
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
			if( !\Auth::user()->canDo('ADD_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_create')]);
			}
			$request->validate([
				                   'title' => 'required|max:255',
			                   ]);
			
			$category = new Category();
			$data     = $request->except('_token');
			
			$category->fill($data);
			$category->prepare($request);
			
			$category->save();
			
			return task_route($data['task'], 'admin.categories', __('system.category_created'), $category->id);
			
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  \App\Category $category
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function edit(Category $category){
			if( !\Auth::user()->canDo('EDIT_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')]);
			}
			
			$this->vars['categories'] = self::getCategoriesList();;
			$this->vars['category'] = $category;
			$this->title            = __('system.edit_category');
			$this->template         = 'admin.category';
			
			return $this->renderOutput();
			
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \App\Category            $category
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Category $category){
			if( !\Auth::user()->canDo('EDIT_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')]);
			}
			$request->validate([
				                   'title' => 'required|max:255',
			                   ]);
			
			$data = $request->except('_token');
			
			$category->fill($data);
			
			$category->prepare($request);
			
			$category->save();
			
			return task_route($data['task'], 'admin.categories', __('system.category_updated'), $category->id);
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\Category $category
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Category $category){
			if( !\Auth::user()->canDo('DELETE_CATEGORIES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_delete')]);
			}
			
			if( $category->id == 1 ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_delete')]);
			}
			$children_num = 0;
			try{
				$children     = Category::where('parent_id', $category->id)->get();
				$children_num = count($children);
				if( $children_num ){
					foreach( $children as $child ){
						$child->delete();
					}
				}
				
				$category->delete();
			}
			catch( \Exception $e ){
				\Session::flash('error', $e->getMessage());
			}
            
            return redirect()->back()->with([
                'success' => trans_choice('system.category_deleted', $children_num + 1, ['num' => $children_num + 1]),
            ]);
		}
		
		public static function getCategoriesList(){
			$categories_list[0] = __('system.no_parent');
			
			$categories = self::getCategoriesTree('- ');
			foreach( $categories as $category ){
				$categories_list[ $category->id ] = $category->level_delimiter . " " . $category->title;
			}
			
			return $categories_list;
		}
		
		public static function getCategoriesTree($level_delimiter = '-', $first_parent_id = 0){
			$categories = Category::where('id', '!=', 1)->get();
			$categories->load('articles');
			
			$groupped_cats = $categories->groupBy('parent_id');
			
			$new_collection = collect();
			
			return self::appendChildrenRecurs($groupped_cats, $first_parent_id, $new_collection, -1, $level_delimiter);
		}
		
		public static function appendChildrenRecurs($groupped_cats, $parent_id, $new_collection, $level, $level_delimiter = '-'){
			$level++;
			if( !isset($groupped_cats[ $parent_id ]) OR !count($groupped_cats[ $parent_id ]) ){
				return $new_collection;
			}
			foreach( $groupped_cats[ $parent_id ] as $parent ){
				$parent->level_delimiter = str_repeat($level_delimiter, $level);
				if( isset($groupped_cats[ $parent->id ]) ){
					$parent->children_num = count($groupped_cats[ $parent->id ]);
				}
				else{
					$parent->children_num = 0;
				}
				
				$new_collection->push($parent);
				if( isset($groupped_cats[ $parent->id ]) ){
					$new_collection = self::appendChildrenRecurs($groupped_cats, $parent->id, $new_collection, $level, $level_delimiter);
				}
			}
			
			return $new_collection;
		}
	}
