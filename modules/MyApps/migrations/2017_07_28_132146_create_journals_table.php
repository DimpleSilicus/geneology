<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  create journals schema
		
		 Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 45);
            $table->string('description', 100);
		    $table->enum('status', [
                0,
                1,
                2
            ])->default(0);		 
			$table->integer('user_id');			
		    $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
			$table->timestamp('deleted_at')->useCurrent();
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //  drop journals schema
		Schema::drop('journals');
    }
}
