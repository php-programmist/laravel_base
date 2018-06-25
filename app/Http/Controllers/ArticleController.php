<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use App\Article;
	
	
	class ArticleController extends SiteController {
		
		
		public function index(Request $request, $cat_slug = false) {
			$this->template      = 'site.articles';
			$this->vars['title'] = "Статьи";
			$page                = $request->has('page') ? $request->query('page') : 1;
			
			$where['state'] = 1;
			$cat_id         = $cat_slug ? (int) explode('-', $cat_slug)[0] : 0;
			
			if ( $cat_id ) {
				$category = \App\Category::find($cat_id);
				$children = $category->children;
				if ( count($children) ) {
					$ids   = $children->pluck('id')->all();
					$ids[] = $cat_id;
				}
				else {
					$ids[] = $cat_id;
				}
				
				$this->vars['title'] = $category->title;
			}
			
			$this->vars['articles'] = \Cache::remember('articles_page_' . $page . '_cat_' . $cat_id, config('settings.cache_articles', 0), function () use ($ids, $where) {
				$query = Article::orderByDesc('id')->where($where);
				if ( $ids ) {
					$query->whereIn('category_id', $ids);
				}
				
				$articles = $query->paginate(config('settings.site_pagination', 5));
				
				$articles->load('user');
				$articles->load('category');
				
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
