<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Article;
	use Cache;
	
	class ArticleController extends Controller {
		public function index(Request $request) {
			$page = $request->has('page') ? $request->query('page') : 1;
			
			$articles = Cache::remember('articles_' . $page, 10, function () {
				$articles = Article::orderByDesc('id')->where([ 'state' => 1 ])->paginate(5);
				$articles->load('user');
				
				return $articles;
			});
			
			$title = "Статьи";
			
			return view('articles', [ 'title' => $title, 'articles' => $articles ]);
		}
		
		public function show($slug) {
			$id      = (int) explode('-', $slug)[0];
			$article = Cache::remember('article_' . $id, 10, function () use ($id) {
				return Article::where([ 'state' => '1', 'id' => $id ])->firstOrFail();
			});
			$title   = $article->name;
			
			return view('article', [ 'title' => $title, 'article' => $article ]);
		}
	}
