<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Article extends Model {
		protected $fillable = [
			'name', 'alias', 'image', 'intro_text', 'full_text', 'state', 'user_id',
		];
		
		public function user() {
			return $this->belongsTo('App\User');
		}
	}
