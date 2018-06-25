<?php
	
	namespace App\Http\Controllers;
	
	use App\Category;
	use Illuminate\Http\Request;
	
	class AdminCategoryController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index() {
			$parent_categories = Category::orderBy('id')->where('parent_id', 0)->get();
			$parent_categories->load('articles');
			$parent_categories->load('children');
			
			$title      = __('system.categories_list');
			$categories = [];
			foreach ($parent_categories as &$category) {
				$category->children_num = $category->children->count();
				$categories[]           = $category;
				if ( $category->children_num ) {
					foreach ($category->children as $child) {
						$child->children_num = 0;
						$child->title        = '|-' . $child->title;
						$categories[]        = $child;
					}
				}
			}
			
			return view('admin.categories', [
				'title'      => $title,
				'categories' => $categories,
			]);
		}
		
		/**
		 * Show the form for creating a new resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function create() {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
			}
			$category   = new Category();
			$categories = $this->getParents();
			
			return view('admin.category', [
				'title'      => __('system.create_category'),
				'category'   => $category,
				'categories' => $categories,
			]);
		}
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ]);
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
		public function edit(Category $category) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
			}
			
			$categories = $this->getParents($category->id);
			
			return view('admin.category', [
				'title'      => __('system.create_category'),
				'category'   => $category,
				'categories' => $categories,
			]);
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \App\Category            $category
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, Category $category) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_update') ]);
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
		public function destroy(Category $category) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			
			if ( $category->id == 1 ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			$children_num = 0;
			try {
				$children     = Category::where('parent_id', $category->id)->get();
				$children_num = count($children);
				if ( $children_num ) {
					foreach ($children as $child) {
						$child->delete();
					}
				}
				
				$category->delete();
			}
			catch (\Exception $e) {
				\Session::flash('error', $e->getMessage());
			}
			
			return redirect()->back()->with([ 'message' => trans_choice('system.category_deleted', $children_num + 1, [ 'num' => $children_num + 1 ]) ]);
		}
		
		private function getParents($exclude_id = 0) {
			$categories    = Category::select([ 'id', 'title' ])
				->where('parent_id', 0)
				->where('id', '!=', $exclude_id)
				->where('id', '!=', 1)
				->get()
				->pluck('title', 'id')
				->all();
			$categories[0] = __('system.no_parent');
			ksort($categories);
			
			return $categories;
		}
	}
