<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //  create shared_resources schema
		Schema::create('shared_resources', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('resource_id');			
			$table->string('resource_type', 45);
			$table->integer('shared_by');	
			$table->integer('shared_to');		
		    $table->enum('receiver_status', [
                0,
                1  
            ])->default(0);		
		    $table->timestamp('sent_date')->useCurrent();
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
        //  drop shared_resources schema
		Schema::drop('shared_resources');
    }
}
