<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //  create tutorials schema
		Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');	
			$table->string('question', 45);
			$table->string('answer',45);
		    $table->enum('status', [
                0,
                1  
            ])->default(0);		
			$table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
			//  drop tutorials schema
		    Schema::drop('tutorials');
    }
}
