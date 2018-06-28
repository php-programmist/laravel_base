<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	class CreatePermissionRoleTable extends Migration{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up(){
			Schema::create('permission_group', function(Blueprint $table){
				$table->increments('id');
				$table->integer('group_id')->unsigned()->default(0);
				$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
				
				$table->integer('permission_id')->unsigned()->default(0);
				$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down(){
			Schema::dropIfExists('permission_role');
		}
	}
