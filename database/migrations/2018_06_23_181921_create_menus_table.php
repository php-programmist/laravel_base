<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;
	
	class CreateMenusTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('menus', function (Blueprint $table) {
				$table->increments('id');
				$table->string('title');
				$table->string('path');
				$table->integer('parent_id')->unsigned()->default(0);
				$table->string('element')->nullable();
				$table->integer('ordering')->default(0);
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::dropIfExists('menus');
		}
	}
