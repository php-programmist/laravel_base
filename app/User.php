<?php
	
	namespace App;
	
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	
	class User extends Authenticatable {
		use Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'name', 'email', 'password', 'username',
		];
		
		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = [
			'password', 'remember_token',
		];
		
		public function articles() {
			return $this->hasMany('App\Article');
		}
		
		/**
		 * Check if User has some role
		 *
		 * @param $role - name of group. Field groups.name
		 *
		 * @return bool
		 */
		public function hasRole($role) {
			$groups = $this->groups();
			foreach ($groups as $group) {
				if ( $group->name == $role ) {
					return true;
				}
			}
			
			return false;
		}
		
		public function groups() {
			return $this->belongsToMany('App\Group');
		}
	}
