<?php

/**
 * CreatePageCategoryTable class to add / edit / delete page categories
 *
 * @name       CreatePageCategoryTable.php
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
 * CreatePageCategoryTable class to add / edit / delete page categories
 *
 * @name       CreatePageCategoryTable.php
 * @category   Pages
 * @package    Pages
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 6d7af36ed3b70d75a7c3d8ede377eada2412b776 $
 * @link       None
 * @filesource
 */
class CreatePageCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('status', [0, 1, 2])->default(1)->nullable();
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
        Schema::drop('page_categories');
    }

}
