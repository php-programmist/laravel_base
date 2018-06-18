<?php
	
	namespace App\Policies;
	
	use App\User;
	use App\Article;
	use Illuminate\Auth\Access\HandlesAuthorization;
	
	/**
	 * Class ArticlePolicy
	 * @package App\Policies
	 */
	class ArticlePolicy {
		use HandlesAuthorization;
		
		/**
		 * Create a new policy instance.
		 *
		 * @return void
		 */
		public function __construct() {
			//
		}
		
		public function add(User $user) {
			foreach ($user->groups as $group) {
				if ( $group->name == 'Super User' ) {
					return true;
				}
			}
			
			return false;
		}
		
		public function update(User $user, Article $article) {
			foreach ($user->groups as $group) {
				if ( $group->name == 'Super User' ) {
					if ( $user->id == $article->user_id ) {
						return true;
					}
				}
			}
			
			return false;
		}
	}
