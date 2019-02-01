<?php

namespace App\Http\Controllers\Admin;
	
	//use Illuminate\Http\Request;
	//use App\User;
	use App\Article;
    use App\Http\Requests\AdminArticleRequest;
    use Auth;
    
    //use Intervention\Image\Facades\Image;
    
    class ArticleController extends AdminController
    {
		
		/**
		 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function index() {
			if( !\Auth::user()->canDo('VIEW_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_view')])->withInput();
			}
			$articles = Article::orderBy('id')->paginate(config('settings.admin_pagination', 15));
			$articles->load('user');
			$articles->load('category');
			$this->vars['articles'] = $articles;
			$this->title            = __('system.articles_list');
			$this->template         = 'admin.articles';
			
			return $this->renderOutput();
		}
		
		/**
		 * @param Article $article
		 *
		 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function edit(Article $article) {
			if( !\Auth::user()->canDo('EDIT_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_update')])->withInput();
			}
            
            $categories = CategoryController::getCategoriesList();
			
			$this->vars['article']    = $article;
			$this->vars['categories'] = $categories;
			$this->title              = __('system.article_edit');
			$this->template           = 'admin.article';
			
			return $this->renderOutput();
		}
		
		/**
		 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
		 */
		public function create() {
			$article = new Article();
			if( !\Auth::user()->canDo('ADD_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_create')])->withInput();
			}
            
            $categories = CategoryController::getCategoriesList();
			
			$this->vars['article']    = $article;
			$this->vars['categories'] = $categories;
			$this->title              = __('system.article_add');
			$this->template           = 'admin.article';
			
			return $this->renderOutput();
			
			
		}
		
		/**
		 * @param AdminArticleRequest $request
		 * @param Article             $article
		 *
		 * @return $this|\Illuminate\Http\RedirectResponse
		 */
		public function update(AdminArticleRequest $request, Article $article) {
			
			$user = Auth::user();
			if( !\Auth::user()->canDo('EDIT_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('article.not_allowed_update')])->withInput();
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
			
			if( !\Auth::user()->canDo('ADD_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('article.not_allowed_create')])->withInput();
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
			if( !\Auth::user()->canDo('DELETE_ARTICLES') ){
                return redirect()->back()->with(['warning' => __('system.not_allowed_delete')]);
			}
			
			//$article = Article::findOrFail($id);
			
			try {
				$article->delete();
			}
			catch (\Exception $e) {
				\Session::flash('error', $e->getMessage());
			}
            
            return redirect()->back()->with(['success' => __('article.article_deleted')]);
		}
		
	}
