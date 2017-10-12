<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		    Schema::create('packages', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name',45);
				$table->string('description',45);
				$table->enum('status', [
					0,
					1
				])->default(1);
				 $table->tinyInteger('amount');
				 $table->tinyInteger('gedcom');
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
          Schema::drop('packages');
    }
}
