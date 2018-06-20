<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Article;
	
	class ArticleController extends Controller {
		public function index() {
			$articles = Article::orderByDesc('id')->where([ 'state' => 1 ])->paginate(5);
			$articles->load('user');
			$title = "Статьи";
			
			return view('articles', [ 'title' => $title, 'articles' => $articles ]);
		}
		
		public function show($slug) {
			$id      = (int) explode('-', $slug)[0];
			$article = Article::where([ 'state' => '1', 'id' => $id ])->firstOrFail();
			$title   = $article->name;
			
			return view('article', [ 'title' => $title, 'article' => $article ]);
		}
	}
