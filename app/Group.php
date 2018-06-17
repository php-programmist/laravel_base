<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Group extends Model {
		protected $fillable = [
			'name',
		];
		
		public function users() {
			return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');
		}
	}
