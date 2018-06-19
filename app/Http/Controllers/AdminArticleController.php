<?php
	
	namespace App\Http\Controllers;
	
	//use Illuminate\Http\Request;
	//use App\User;
	use App\Article;
	use Auth;
	use App\Http\Requests\AdminArticleRequest;
	
	class AdminArticleController extends Controller {
		public function list() {
			$articles = Article::orderBy('id')->paginate(10);
			$articles->load('user');
			$title = __('article.articles_list');
			
			return view('admin.articles', [ 'title' => $title, 'articles' => $articles ]);
		}
		
		public function index($id = 0) {
			if ( $id ) {
				$article = Article::find($id);
				$title   = __('article.article_edit');
			}
			else {
				$article = new Article();
				$title   = __('article.article_add');
			}
			
			return view('admin.article', [ 'title' => $title, 'article' => $article ]);
		}
		
		public function save(AdminArticleRequest $request) {
			if ( $request->filled('id') ) {
				return $this->update($request);
			}
			else {
				return $this->create($request);
			}
		}
		
		public function update(AdminArticleRequest $request) {
			
			$user = Auth::user();
			
			$data = $request->all();
			
			$article = Article::find($data['id']);
			
			if ( $request->user()->can('update', $article) ) {
				$article->fill($data);
				$user->articles()->save($article);
				if ( $data['task'] == 'apply' ) {
					return redirect()->back()->with('message', __('article.article_updated'));
				}
				else {
					return redirect()->route('admin.articles')->with([ 'message' => __('article.article_updated') ]);
				}
			}
			
			return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
		}
		
		public function create(AdminArticleRequest $request) {
			$article = new Article();
			
			if ( $request->user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_create') ])->withInput();
			}
			
			$data = $request->all();
			$article->fill($data);
			$user = Auth::user();
			$user->articles()->save($article);
			
			$article_id = $article->id;
			
			if ( $data['task'] == 'apply' ) {
				return redirect()->route('admin.article_update', [ 'id' => $article_id ])->with([ 'message' => __('article.article_created') ]);
			}
			else {
				return redirect()->route('admin.articles')->with([ 'message' => __('article.article_created') ]);
			}
			
		}
	}
