<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Article;
	
	
	class ArticleController extends SiteController {
		
		
		public function index(Request $request) {
			$this->template      = 'site.articles';
			$this->vars['title'] = "Статьи";
			$page                = $request->has('page') ? $request->query('page') : 1;
			
			
			$this->vars['articles'] = \Cache::remember('articles_' . $page, config('settings.cache_articles', 0), function () {
				$articles = Article::orderByDesc('id')->where([ 'state' => 1 ])->paginate(config('settings.site_pagination', 5));
				$articles->load('user');
				
				return $articles;
			});
			
			
			return $this->renderOutput();
		}
		
		public function show($slug) {
			$id = (int) explode('-', $slug)[0];
			
			$this->vars['article'] = \Cache::remember('article_' . $id, config('settings.cache_articles', 0), function () use ($id) {
				return Article::where([ 'state' => '1', 'id' => $id ])->firstOrFail();
			});
			
			$this->template = 'site.article';
			
			$this->vars['title'] = $this->vars['article']->name;
			
			return $this->renderOutput();
		}
	}
