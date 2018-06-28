<?php
	
	namespace App;
	
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	
	class User extends Authenticatable{
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
		
		public function articles(){
			return $this->hasMany('App\Article');
		}
		
		public function comments(){
			return $this->hasMany('App\Comments');
		}
		
		public function groups(){
			return $this->belongsToMany('App\Group');
		}
		
		/**
		 * Check if User has some group
		 *
		 * @param $group   - name of group or array of group names. Field groups.name
		 * @param $require - does user have all groups
		 *
		 * @return bool
		 */
		public function hasRole($name, $require = false){
			if( is_array($name) ){
				foreach( $name as $groupName ){
					$hasRole = $this->hasRole($groupName);
					
					if( $hasRole && !$require ){
						return true;
					}
					elseif( !$hasRole && $require ){
						return false;
					}
				}
				
				return $require;
			}
			else{
				foreach( $this->groups as $group ){
					if( $group->name == $name ){
						return true;
					}
				}
			}
			
			return false;
		}
		
		public function canDo($permission, $require = false){
			if( is_array($permission) ){
				foreach( $permission as $permName ){
					
					$permName = $this->canDo($permName);
					if( $permName && !$require ){
						return true;
					}
					else if( !$permName && $require ){
						return false;
					}
				}
				
				return $require;
			}
			else{
				foreach( $this->groups as $group ){
					foreach( $group->permissions as $perm ){
						
						if( str_is($permission, $perm->name) ){
							return true;
						}
					}
				}
			}
			
			return false;
		}
	}
