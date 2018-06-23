<?php
	
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;
	
	class CreateCommentsTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('comments', function (Blueprint $table) {
				$table->increments('id');
				
				$table->text('text');
				$table->string('name');
				$table->string('email');
				$table->integer('state')->default('0');
				$table->integer('parent_id')->default('0');
				$table->integer('user_id')->unsigned()->nullable();
				$table->integer('article_id')->unsigned();
				$table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade')->onUpdate('cascade');
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
			Schema::dropIfExists('comments');
		}
	}
