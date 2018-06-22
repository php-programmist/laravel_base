<?php
	
	namespace App\Http\Controllers;
	
	//use Illuminate\Http\Request;
	//use App\User;
	use App\Article;
	use Auth;
	use App\Http\Requests\AdminArticleRequest;
	
	class AdminArticleController extends Controller {
		public function index() {
			$articles = Article::orderBy('id')->paginate(10);
			$articles->load('user');
			$title = __('article.articles_list');
			
			return view('admin.articles', [
				'title'    => $title,
				'articles' => $articles,
			]);
		}
		
		public function edit($id) {
			$article = Article::find($id);
			if ( \Auth::user()->cannot('update', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
			}
			
			
			return view('admin.article', [
				'title'   => __('article.article_edit'),
				'article' => $article,
			
			]);
		}
		
		public function create() {
			$article = new Article();
			if ( \Auth::user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_create') ])->withInput();
			}
			
			
			return view('admin.article', [
				'title'   => __('article.article_add'),
				'article' => $article,
			]);
		}
		
		public function update(AdminArticleRequest $request, $id) {
			
			$user = Auth::user();
			
			$data = $request->all();
			
			$article = Article::find($id);
			if ( $request->user()->cannot('update', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
			}
			$article->fill($data);
			$article->prepare();
			$user->articles()->save($article);
			if ( $data['task'] == 'apply' ) {
				return redirect()->back()->with('message', __('article.article_updated'));
			}
			else {
				return redirect()->route('admin.articles.index')->with([ 'message' => __('article.article_updated') ]);
			}
			
			
		}
		
		public function store(AdminArticleRequest $request) {
			$article = new Article();
			
			if ( $request->user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_create') ])->withInput();
			}
			
			$data = $request->all();
			$article->fill($data);
			$article->prepare();//TODO добавить загрузку изображений
			$user = Auth::user();
			$user->articles()->save($article);
			
			$article_id = $article->id;
			
			if ( $data['task'] == 'apply' ) {
				return redirect()->route('admin.articles.edit', [ 'id' => $article_id ])->with([ 'message' => __('article.article_created') ]);
			}
			else {
				return redirect()->route('admin.articles.index')->with([ 'message' => __('article.article_created') ]);
			}
			
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id) {
			if ( !\Auth::user()->hasRole('Super User') ) {
				return redirect()->back()->with([ 'message' => __('system.not_allowed_delete') ]);
			}
			
			$article = Article::findOrFail($id);
			
			
			$article->destroy($id);
			
			return redirect()->back()->with([ 'message' => __('article.article_deleted') ]);
		}
	}
