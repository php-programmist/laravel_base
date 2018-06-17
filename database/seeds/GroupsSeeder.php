<?php
	
	use Illuminate\Database\Seeder;
	
	class GroupsSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			$user_id = DB::table('users')->where('username', '=', 'admin')->value('id');
			if ( !$user_id ) {
				$user_id = DB::table('users')->insertGetId([
					'username'   => 'admin',
					'name'       => 'Administrator',
					'email'      => 'admin@admin.ru',
					'password'   => Hash::make('123456'),
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
				]);
			}
			
			$group_id = DB::table('groups')->where('name', '=', 'Super User')->value('id');
			if ( !$group_id ) {
				$group_id = DB::table('groups')->insertGetId([
					'name'       => 'Super User',
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
				]);
			}
			
			DB::table('groups')->insert([
				'name'       => 'Registered',
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			]);
			
			DB::table('group_user')->insert([
				'user_id'    => $user_id,
				'group_id'   => $group_id,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			]);
			
		}
	}
