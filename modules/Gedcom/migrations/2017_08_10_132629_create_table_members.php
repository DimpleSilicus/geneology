<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMembers extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('family_id')->nullable();
            $table->string('first_name', 45);
            $table->string('last_name', 45)->nullable();
            $table->integer('user_id');
            $table->string('generation', 45)->nullable();
            $table->enum('gender', [
                0,
                1
            ])->default(0);
            $table->string('avatar', 45)->nullable();
            $table->string('notes', 45)->nullable();
            $table->enum('privacy', [
                0,
                1
            ])->default(0);
            $table->enum('status', [
                0,
                1
            ])->default(0);
            $table->enum('type', [
                0,
                1
            ])->default(0);
            
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
        Schema::drop('members');
    }
}
