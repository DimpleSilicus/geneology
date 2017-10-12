<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMemberEvents extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->integer('member_id');
            $table->timestamp('event_date');
            $table->string('place', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member_events');
    }
}
