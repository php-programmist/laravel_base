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
			$title = "Список статей";
			
			return view('admin.articles', [ 'title' => $title, 'articles' => $articles ]);
		}
		
		public function index(Request $request, $id = 0) {
			if ( $id ) {
				$article = Article::find($id);
				$title   = 'Редактирование статьи';
			}
			else {
				$article = new Article();
				$title   = 'Добавление статьи';
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
					return redirect()->back()->with('message', 'Статья обновлена');
				}
				else {
					return redirect()->route('articles')->with([ 'message' => 'Статья обновлена' ]);
				}
			}
			
			return redirect()->back()->with([ 'message' => 'У Вас нет прав редактировать данную статью' ])->withInput();
		}
		
		public function create(Request $request) {
			$article = new Article();
			
			if ( $request->user()->cannot('add', $article) ) {
				return redirect()->back()->with([ 'message' => 'Вы не можете создавать статьи' ])->withInput();
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
				return redirect()->route('article_update', [ 'id' => $article_id ])->with([ 'message' => 'Статья добавлена. ID - ' . $article_id ]);
			}
			else {
				return redirect()->route('articles')->with([ 'message' => 'Статья добавлена.' ]);
			}
			
		}
	}
