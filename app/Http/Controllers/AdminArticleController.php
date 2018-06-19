<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\User;
	use App\Article;
	use Auth;
	
	class AdminArticleController extends Controller {
		public function list() {
			$articles = Article::all();
			$articles->load('user');
			$title = __('article.articles_list');
			
			return view('admin.articles', [ 'title' => $title, 'articles' => $articles ]);
		}
		
		public function index(Request $request, $id = 0) {
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
		
		public function save(Request $request) {
			if ( $request->filled('id') ) {
				return $this->update($request);
			}
			else {
				return $this->create($request);
			}
		}
		
		public function update(Request $request) {
			$this->validate($request, [
				'name' => 'required',
			]);
			
			$user = Auth::user();
			
			$data = $request->except('_token');
			
			$article = Article::find($data['id']);
			
			if ( $request->user()->can('update', $article) ) {
				$article->name       = $data['name'];
				$article->alias      = $data['alias'];
				$article->image      = $data['image'];
				$article->intro_text = $data['intro_text'];
				$article->full_text  = $data['full_text'];
				$article->state      = $data['state'];
				
				$res = $user->articles()->save($article);
				if ( $data['task'] == 'apply' ) {
					return redirect()->back()->with('message', __('article.article_updated'));
				}
				else {
					return redirect()->route('admin.articles')->with([ 'message' => __('article.article_updated') ]);
				}
			}
			
			return redirect()->back()->with([ 'message' => __('article.not_allowed_update') ])->withInput();
		}
		
		public function create(Request $request) {
			$article = new Article();
			
			if ( $request->user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => __('article.not_allowed_create') ])->withInput();
			}
			
			$this->validate($request, [
				'name' => 'required',
			]);
			
			$user = Auth::user();
			$data = $request->all();
			
			$article->name       = $data['name'];
			$article->alias      = $data['alias'];
			$article->image      = $data['image'];
			$article->intro_text = $data['intro_text'];
			$article->full_text  = $data['full_text'];
			$article->state      = (int) $data['state'];
			$article->user_id    = $user->id;
			$article->save();
			$article_id = $article->id;
			
			if ( $data['task'] == 'apply' ) {
				return redirect()->route('admin.article_update', [ 'id' => $article_id ])->with([ 'message' => __('article.article_created') ]);
			}
			else {
				return redirect()->route('admin.articles')->with([ 'message' => __('article.article_created') ]);
			}
			
		}
	}
