<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPrivacyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_privacy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->enum('appear_to_world_map', [
                0,
                1,
                2
            ])->default(0);
            $table->enum('appear_to_my_network', [
                0,
                1,
                2
            ])->default(0);
            $table->string('pedigree', 100);
            $table->string('images', 100);
            $table->string('videos', 100);
            $table->string('journals', 100);
            $table->string('event', 100);
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
        Schema::drop('user_privacy');
    }
}
