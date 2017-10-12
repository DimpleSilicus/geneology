<?php

/**
 * CreatePagesTable class to add / edit / delete pages
 *
 * @name       CreatePagesTable.php
 * @category   Pages
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 6d7af36ed3b70d75a7c3d8ede377eada2412b776 $
 * @link       None
 * @filesource
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreatePagesTable class to add / edit / delete pages
 *
 * @name       CreatePagesTable.php
 * @category   Pages
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 6d7af36ed3b70d75a7c3d8ede377eada2412b776 $
 * @link       None
 * @filesource
 */
class CreatePagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('content');
            $table->string('slug')->unique();
            $table->string('meta_title', 500);
            $table->string('meta_keyword', 1000);
            $table->string('meta_description', 3000);
            $table->integer('page_category_id')->nullable();
            $table->enum('publish', [0, 1, 2])->default(0)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }

}
