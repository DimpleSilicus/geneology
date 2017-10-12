<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  create app_events schema
		Schema::create('app_events', function (Blueprint $table) {
            $table->increments('id');	
			$table->string('name', 45);
			$table->string('description',45);
			$table->string('place', 45);
		    $table->enum('status', [
                0,
                1  
            ])->default(0);		
			$table->date('event_date');
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
        //  drop app_events schema
		Schema::drop('app_events');
    }
}
