<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateArticlesTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('articles', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name', 256);
				$table->string('alias', 256)->nullable();
				$table->string('image', 256)->nullable();
				$table->text('intro_text')->nullable();
				$table->text('full_text')->nullable();
				$table->integer('state')->default(0);
				$table->integer('user_id')->unsigned()->default(0);
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
				$table->timestamps();
			});
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::dropIfExists('articles');
		}
	}
