<?php
	
	namespace App\Http\Controllers;
	
	//use Illuminate\Http\Request;
	//use App\User;
	use App\Article;
	use Auth;
	use App\Http\Requests\AdminArticleRequest;
	
	//use Intervention\Image\Facades\Image;
	
	class AdminArticleController extends Controller {
		/**
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function index() {
			$articles = Article::orderBy('id')->paginate(config('settings.admin_pagination', 15));
			$articles->load('user');
			$articles->load('category');
			$title = __('system.articles_list');
			
			return view('admin.articles', [
				'title'    => $title,
				'articles' => $articles,
			]);
		}
		
		/**
		 * @param Article $article
		 *
		 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function edit(Article $article) {
			if ( \Auth::user()->cannot('update', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
			}
			
			$categories = AdminCategoryController::getCategoriesList();
			
			return view('admin.article', [
				'title'      => __('article.article_edit'),
				'article'    => $article,
				'categories' => $categories,
			
			]);
		}
		
		/**
		 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function create() {
			$article = new Article();
			if ( \Auth::user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ])->withInput();
			}
			
			$categories = AdminCategoryController::getCategoriesList();
			
			return view('admin.article', [
				'title'      => __('article.article_add'),
				'article'    => $article,
				'categories' => $categories,
			]);
		}
		
		/**
		 * @param AdminArticleRequest $request
		 * @param Article             $article
		 *
		 * @return $this|\Illuminate\Http\RedirectResponse
		 */
		public function update(AdminArticleRequest $request, Article $article) {
			
			$user = Auth::user();
			if ( $request->user()->cannot('update', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
			}
			
			$data = $request->except('image');
			
			$article->fill($data);
			$article->prepare($request);
			$user->articles()->save($article);
			
			return task_route($data['task'], 'admin.articles', __('article.article_updated'), $article->id);
			
		}
		
		/**
		 * @param AdminArticleRequest $request
		 *
		 * @return $this|\Illuminate\Http\RedirectResponse
		 */
		public function store(AdminArticleRequest $request) {
			$article = new Article();
			
			if ( $request->user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_create') ])->withInput();
			}
			
			$data = $request->except('image');
			
			$article->fill($data);
			$article->prepare($request);
			$user = Auth::user();
			$user->articles()->save($article);
			
			
			return task_route($data['task'], 'admin.articles', __('article.article_created'), $article->id);
			
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param Article $article
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(Article $article) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			
			//$article = Article::findOrFail($id);
			
			try {
				$article->delete();
			}
			catch (\Exception $e) {
				\Session::flash('error', $e->getMessage());
			}
			
			return redirect()->back()->with([ 'message' => __('article.article_deleted') ]);
		}
		
	}
