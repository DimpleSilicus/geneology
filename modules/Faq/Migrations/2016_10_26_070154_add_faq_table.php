<?php

/**
 * Faq Migrations file
 *
 * @category   Migrations
 * @package    FAQ
 * @author     Prasad Nanaware <prasad.nanaware@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @name       CreateTestimonials
 * @version    GIT: <git_id>
 * @link       http://www.silicus.com/
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * AddFaqTable class
 *
 * @category Migrations
 * @package FAQ
 * @author Prasad Nanaware <prasad.nanaware@silicus.com>
 * @license Silicus http://www.silicus.com/
 * @name AddFaqTable
 * @version Release:<v.1>
 * @link http://www.silicus.com/
 */
class AddFaqTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question');
            $table->string('answer');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faq');
    }
}
