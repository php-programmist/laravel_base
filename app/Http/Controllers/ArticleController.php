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
			$ids            = [];
			if ( $cat_id ) {
				$this->vars['title'] = \App\Category::find($cat_id)->title;
				$categories          = AdminCategoryController::getCategoriesTree('', $cat_id);
				
				$ids   = $categories->pluck('id')->all();
				$ids[] = $cat_id;
			}
			
			$this->vars['articles'] = \Cache::remember('articles_page_' . $page . '_cat_' . $cat_id, config('settings.cache_articles', 0), function () use ($ids, $where) {
				$query = Article::orderByDesc('id')->where($where);
				if ( $ids ) {
					$query->whereIn('category_id', $ids);
				}
				
				$articles = $query->paginate(config('settings.site_pagination', 5));
				
				$articles->load('user');
				$articles->load('category');
				$articles->load('comments');
				
				return $articles;
			});
			
			
			return $this->renderOutput();
		}
		
		public function show($slug) {
			$id = (int) explode('-', $slug)[0];
			
			$article = \Cache::remember('article_' . $id, config('settings.cache_articles', 0), function () use ($id) {
				return Article::where([ 'state' => '1', 'id' => $id ])->firstOrFail();
			});
			$article->load('comments');
			
			$article->comments = $article->comments->reject(function ($comment) {
				return $comment->state == 0;
			});
			
			$this->vars['comments_groups'] = $article->comments->groupBy('parent_id');
			$this->vars['article']         = $article;
			$this->template                = 'site.article';
			
			$this->vars['title'] = $this->vars['article']->name;
			
			return $this->renderOutput();
		}
	}
