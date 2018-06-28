<?php
	
	use Illuminate\Database\Seeder;
	
	class PermissionsSeeder extends Seeder{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run(){
			DB::table('permissions')
			  ->insert([
				           [
					           'name'       => 'VIEW_ADMIN',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_ARTICLES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'ADD_ARTICLES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_ARTICLES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_ARTICLES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_USERS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'ADD_USERS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_USERS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_USERS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_MENU',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'ADD_MENU',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_MENU',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_MENU',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_GROUPS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'ADD_GROUPS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_GROUPS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_GROUPS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_CATEGORIES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'ADD_CATEGORIES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_CATEGORIES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_CATEGORIES',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'VIEW_COMMENTS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'MODERATE_COMMENTS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'EDIT_COMMENTS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
				           [
					           'name'       => 'DELETE_COMMENTS',
					           'created_at' => date("Y-m-d H:i:s"),
					           'updated_at' => date("Y-m-d H:i:s"),
				           ],
			           ]);
			for( $i = 1 ; $i < 26 ; $i++ ){
				DB::table('permission_group')
				  ->insert([
					           'permission_id' => $i,
					           'group_id'      => 1,
					           'created_at'    => date("Y-m-d H:i:s"),
					           'updated_at'    => date("Y-m-d H:i:s"),
				           ]);
			}
			
		}
	}
