<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//  create queues schema
		Schema::create('queues', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name', 45);
			$table->integer('user_id');	
			$table->enum('status', [
                0,
                1
            ])->default(0);	
            $table->string('file', 100);					
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
        //  drop queues schema
		Schema::drop('queues');
    }
}
