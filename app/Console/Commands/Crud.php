<?php

/**
 *  This will generate CRUD operation
 *
 * @name       Crud.php
 * @category   Commands
 * @package    Console
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: a7e93dfa4426a727c36f1cbeb79491fd9323240d $
 * @link       None
 * @filesource
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * This will generate CRUD operation
 *
 * @name     Curd
 * @category Commands
 * @package  Console
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Crud extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate {className} {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate CRUD operation for given table name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @name   handle
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function handle()
    {
        $tableInfo   = null;
        $className   = ucfirst(strtolower($this->argument('className')));
        $tableName   = $this->argument('tableName');
        $tableExists = $this->_checkTableExists($tableName);


        if ($tableExists != true) {
            print("Table {$tableName} does not exists");
            return;
        }

        $tableInfo = $this->_getTableInfo($tableName);

        $source         = base_path('resources/crud/Sample');
        $destination    = storage_path('crud-generator/' . $className);
        $cloneDone      = $this->_createClone($source, $destination);
        $moduleGenerate = false;
        $theme          = \Config::get('app.theme');
        if ($cloneDone) {

            $this->_setFileName($destination, $className);
            $this->_setController($destination . '/src/Controllers/' . $className . 'Controller.php', $className, $tableInfo);
            $this->_setModel($destination . '/src/Models/' . $className . '.php', $className, $tableName, $tableInfo);
            $this->_setViews($destination . '/src/Views/' . $theme . '/', $className, $tableInfo);
            $this->_setJs($destination . '/src/js/', $className, $tableInfo);
            $this->_setRoutes($destination . '/src/routes.php', $className);
            $this->_setServiceProvider($destination . "/src/{$className}ServiceProvider.php", $className);
            $this->_setComposer($destination . '/composer.json', $className);

            $moduleGenerate = true;
        }

        if ($moduleGenerate) {
            print("Module '{$className}' generated successfully at location {$destination}");
        }
    }

    /**
     * Description
     *
     * @name   _createClone
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $source      Source folder
     * @param string $destination Destination folder
     *
     * @return void
     */
    private function _createClone($source, $destination)
    {
        if (file_exists($destination)) {
            print('Folder already exists in directory ' . $destination . ' please delete it first.');
            return false;
        } else {
            mkdir($destination, 0755);
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator as $item) {
                if ($item->isDir()) {
                    mkdir($destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                } else {
                    copy($item, $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                }
            }
        }

        return true;
    }

    /**
     * Rename file with given class name
     *
     * @name   _setFileName
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $source Source file path/name
     * @param string $name   New file name
     *
     * @return void
     */
    private function _setFileName($source, $name)
    {
        $theme = \Config::get('app.theme');
        // Rename ServiceProvider
        rename($source . '/src/SampleServiceProvider.ph', $source . '/src/' . $name . 'ServiceProvider.php');

        // Rename Model
        rename($source . '/src/Models/Sample.ph', $source . '/src/Models/' . $name . '.php');

        // Rename Routes
        rename($source . '/src/routes.ph', $source . '/src/routes.php');

        // Rename Controllers
        rename($source . '/src/Controllers/SampleController.ph', $source . '/src/Controllers/' . $name . 'Controller.php');

        //Rename views directory name
        rename($source . '/src/Views/default', $source . '/src/Views/' . $theme);

        // Rename Views
        rename($source . '/src/Views/' . $theme . '/index.blade.ph', $source . '/src/Views/' . $theme . '/index.blade.php');
        //  rename($source . '/src/Views/' . $theme . '/create.blade.ph', $source . '/src/Views/' . $theme . '/create.blade.php');
        //  rename($source . '/src/Views/' . $theme . '/edit.blade.ph', $source . '/src/Views/' . $theme . '/edit.blade.php');
        // rename($source . '/src/Views/' . $theme . '/detail.blade.ph', $source . '/src/Views/' . $theme . '/detail.blade.php');
        //rename js
        rename($source . '/src/js/sample.js', $source . '/src/js/' . strtolower($name) . '.js');
    }

    /**
     * Replace dummy code from controller class
     *
     * @name   _setController
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file      Controller file path
     * @param string $name      Class name
     * @param string $tableInfo table name
     *
     * @return void
     */
    private function _setController($file, $name, $tableInfo)
    {
        $columns = $this->_getColumns($tableInfo, $name);
        $search  = ['@USample@', '@LSample@', '@COLUMNS@'];
        $replace = [ucfirst($name), strtolower($name), $columns];

        $this->_replaceCode($search, $replace, $file);
    }

    /**
     * Get column names of table
     *
     * @name   _getColumns
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array   $tableInfo Table information
     * @param varchar $name      name of module
     *
     * @return array
     */
    private function _getColumns($tableInfo, $name)
    {
        $excludeField  = ['id', 'created_at', 'updated_at'];
        $recordsColumn = '[';
        $i             = 0;
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {
                    if ($i > 0)
                        $recordsColumn .= ",'$field'";
                    else
                        $recordsColumn .= "'$field'";
                    $i++;
                }
            }
        }
        $recordsColumn .= ']';
        return $recordsColumn;
    }

    /**
     * Replace dummy code from model class
     *
     * @name   _setModel
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file      Model file path
     * @param string $name      Class name
     * @param string $tableName Table name
     * @param array  $tableInfo Table field information
     *
     * @return void
     */
    private function _setModel($file, $name, $tableName, $tableInfo)
    {
        $excludeField = ['id', 'created_at', 'updated_at'];
        $fillable     = '';
        $rules        = '';

        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $type) {

                if (!in_array($field, $excludeField)) {
                    $fillable .= "'{$field}',";
                    $rules .= "'{$field}' => 'required',";
                }
            }
        }

        $fillable = trim($fillable, ',');
        $rules    = trim($rules, ',');

        $content         = $this->_getCreatSearchContent($tableInfo, $name);
        $memberVariables = $this->_createVariableFromField($tableInfo);
        $getters         = $this->_createGetterFromField($tableInfo, $name);
        $listContent     = $this->_getCreatListContent($tableInfo, $name);
        $search          = ['@USample@', '@LSample@', '@TableName@', '@Fillable@', '@Rules@', '@SEARCH_CONTENT@', '@MEMBER_VARIABLES@', '@GETTER_FUNC@', '@LIST_CONTENT@'];
        $replace         = [ucfirst($name), strtolower($name), $tableName, $fillable, $rules, $content, $memberVariables, $getters, $listContent];

        $this->_replaceCode($search, $replace, $file);
    }

    /**
     * Replace dummy code from view template
     *
     * @name   _setViews
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $viewDir   View directory path
     * @param string $name      Class name
     * @param array  $tableInfo Table information
     *
     * @return void
     */
    private function _setViews($viewDir, $name, $tableInfo)
    {
        $content                  = $this->_getCreatFormContent($tableInfo);
        $content['detailContent'] = str_replace('@Lsample@', strtolower($name), $content['detailContent']);

        $search  = ['@USample@', '@LSample@', '@CREAT_FORM_CONTENT@', '@CREAT_HEAD_CONTENT@', '@CREAT_LIST_CONTENT@', '@CREAT_VIEW_CONTENT@'];
        $replace = [ucfirst($name), strtolower($name), $content['formContent'], $content['headContent'], $content['listContent'], $content['detailContent']];

        $this->_replaceCode($search, $replace, $viewDir . 'index.blade.php');
        // $this->_replaceCode($search, $replace, $viewDir . 'create.blade.php');
        // $this->_replaceCode($search, $replace, $viewDir . 'edit.blade.php');
        //$this->_replaceCode($search, $replace, $viewDir . 'detail.blade.php');
    }

    /**
     * Replace dummy code from view template
     *
     * @name   _setJs
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $jsDir     JS directory path
     * @param string $name      Class name
     * @param array  $tableInfo Table information
     *
     * @return void
     */
    private function _setJs($jsDir, $name, $tableInfo)
    {
        list($formData, $valuedata, $trData, $viewData, $counter, $recordsColumn) = $this->_getJsContent($tableInfo, $name);
        $search  = ['@USample@', '@LSample@', '@FORM_DATA@', '@VALUE_DATA@', '@COUNTER@', '@TR_DATA@', '@VIEW_DATA@', '@RECORDS_COLUMN@', '@COLUMN_VIEW@', '@COLUMN_EDIT@', '@COLUMN_DELETE@'];
        $replace = [ucfirst($name), strtolower($name), $formData, $valuedata, $counter, $trData, $viewData, $recordsColumn, $counter + 1, $counter + 2, $counter + 3];

        $this->_replaceCode($search, $replace, $jsDir . $name . '.js');
    }

    /**
     * Replace dummy code from ServiceProvider file
     *
     * @name   _setServiceProvider
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file File path
     * @param string $name Class name
     *
     * @return void
     */
    private function _setServiceProvider($file, $name)
    {
        $search  = ['@USample@', '@LSample@'];
        $replace = [ucfirst($name), strtolower($name)];

        $this->_replaceCode($search, $replace, $file);
    }

    /**
     * Replace dummy code from composer.json file
     *
     * @name   _setRoutes
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file File path
     * @param string $name Class name
     *
     * @return void
     */
    private function _setRoutes($file, $name)
    {
        $search  = ['@USample@', '@LSample@'];
        $replace = [ucfirst($name), strtolower($name)];

        $this->_replaceCode($search, $replace, $file);
    }

    /**
     * Replace dummy code from composer.json file
     *
     * @name   _setComposer
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file File path
     * @param string $name Class name
     *
     * @return void
     */
    private function _setComposer($file, $name)
    {
        $search  = ['@USample@', '@LSample@'];
        $replace = [ucfirst($name), strtolower($name)];

        $this->_replaceCode($search, $replace, $file);
    }

    /**
     * Replace dummy code with given options
     *
     * @name   _replaceCode
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param array  $search  Search options
     * @param array  $replace Replace options
     * @param string $file    File name
     *
     * @return void
     */
    private function _replaceCode($search, $replace, $file)
    {
        $contents = '';
        $contents = file_get_contents($file);
        $contents = str_replace($search, $replace, $contents);
        file_put_contents($file, $contents);
    }

    /**
     * Check table exist or not
     *
     * @name   _checkTable
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $tableName Table name
     *
     * @return void
     */
    private function _checkTableExists($tableName)
    {
        $hasTable = \DB::select("SHOW TABLES LIKE '{$tableName}'");

        return count($hasTable) ? true : false;
    }

    /**
     * Get table information
     *
     * @name   _getTableInfo
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $tableName Table name
     *
     * @return array $tableInfo Table field list
     */
    private function _getTableInfo($tableName)
    {
        $tableInfo = [];
        $search    = ['(', ')'];
        $replace   = ['-', ''];
        $field     = 'Field';
        $type      = 'Type';
        $columns   = \DB::select("SHOW COLUMNS FROM {$tableName}");

        foreach ($columns as $column) {
            $tableInfo[$column->$field] = str_replace($search, $replace, $column->$type);
        }

        return $tableInfo;
    }

    /**
     * Get generate form contant
     *
     * @name   _getCreatFormContent
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array $tableInfo Table information
     *
     * @return string $formContent Form content
     */
    private function _getCreatFormContent($tableInfo)
    {
        $excludeField = ['id', 'created_at', 'updated_at'];

        $formContent   = '';
        $headContent   = '';
        $listContent   = '';
        $detailContent = '';

        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {

                    $formContent .= '<div class = "form-group col-md-4 row">
                    {{ Form::label("' . $field . '", "' . ucfirst($field) . ':") }}
                    {{ Form::text("' . $field . '", null, array("class" => "form-control required"))}}
                    ' . PHP_EOL . '
                    @if ($errors->has("' . $field . '"))
                                <span class="help-block">
                                    <strong>{{ $errors->first("' . $field . '") }}</strong>
                                </span>
                                @endif' . PHP_EOL . '</div><div class = "clearfix"></div>' . PHP_EOL . '
                    ' . PHP_EOL;

                    $headContent .= '<th>' . ucfirst($field) . '</th>' . PHP_EOL;

                    $listContent .= '<td>{{ $item->' . $field . '}}</td>' . PHP_EOL;

                    $detailContent .= '<div class="form-group col-lg-12 row">
                                        <div class="col-sm-3">
                                            <label for="' . strtolower($field) . '">' . ucfirst($field) . ':</label>
                                        </div> ' . PHP_EOL . '<div class="col-sm-5" id="' . strtolower($field) . '">
                                        </div></div><div class = "clearfix"></div>';
                }
            }
        }

        return ['formContent' => $formContent, 'headContent' => $headContent, 'listContent' => $listContent, 'detailContent' => $detailContent];
    }

    /**
     * Get generate search contant
     *
     * @name   _getCreatSearchContent
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array   $tableInfo Table information
     * @param varchar $name      name of module
     *
     * @return string $searchContent
     */
    private function _getCreatSearchContent($tableInfo, $name)
    {
        $excludeField = [ 'id', 'created_at', 'updated_at'];

        $searchContent = '';
        $i             = 0;
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {
                    if ($i == 0)
                        $searchContent .= '@Usample@::where("' . $field . '", "LIKE", "%$searchTerm%")';
                    else
                        $searchContent .= '->orWhere("' . $field . '", "LIKE", "%$searchTerm%")';
                    $i++;
                }
            }
            if ($i == 0)
                $searchContent = '@Usample@::all()';
            else
                $searchContent .= '->get()';
            $searchContent = str_replace('@Usample@', ucfirst($name), $searchContent);
        }
        return $searchContent;
    }

    /**
     * Get list contant
     *
     * @name   _getCreatListContent
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array   $tableInfo Table information
     * @param varchar $name      name of module
     *
     * @return string $searchContent
     */
    private function _getCreatListContent($tableInfo, $name)
    {
        $excludeField = [ 'id', 'created_at', 'updated_at'];

        $searchContent = '';
        $i             = 0;
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {
                    if ($i == 0)
                        $searchContent .= 'where("' . $field . '", "LIKE", "%". $filter["search"] ."%")';
                    else
                        $searchContent .= '->orWhere("' . $field . '", "LIKE", "%".$filter["search"]."%")';
                    $i++;
                }
            }
        }
        return $searchContent;
    }

    /**
     * Get generate search contant
     *
     * @name   _getJsContent
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array   $tableInfo Table information
     * @param varchar $name      name of module
     *
     * @return array
     */
    private function _getJsContent($tableInfo, $name)
    {
        $excludeField = ['id', 'created_at', 'updated_at'];

        $formData      = '';
        $valueData     = '';
        $trData        = "'";
        $viewData      = '';
        $recordsColumn = '';
        $i             = 0;
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {
                    $formData .= "$field: $('#$field').val()," . PHP_EOL;
                    $recordsColumn .= "{'data':'$field'}," . PHP_EOL;
                    $valueData .= "$('#$field').val(data.$field);" . PHP_EOL;
                    if ('id' != $field) {
                        $trData .= "<td>' + data.$field + '</td>";
                        $viewData .= "$('div#modalDetail').find('#$field').html(data.$field);" . PHP_EOL;
                    }
                    $i++;
                }
            }
        }
        $trData .= "'";
        return [$formData, $valueData, $trData, $viewData, $i - 1, $recordsColumn];
    }

    /**
     * Create variable from table fields
     *
     * @name   _createVariableFromField
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array $tableInfo Table info
     *
     * @return void
     */
    private function _createVariableFromField($tableInfo)
    {
        $varStr = '';

        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                $length = '';
                if (strstr($value, '-')) {
                    list($type, $length) = explode('-', $value);
                } else {
                    $type = $value;
                }

                if (strstr($field, '_')) {
                    $field = $this->_underscore2Camelcase($field);
                }

                $varStr .= '/**' . PHP_EOL
                        . '     * Member variable "' . $field . '"' . PHP_EOL
                        . '     *' . PHP_EOL
                        . '     * @var string "' . $field . '"' . PHP_EOL
                        . '     *' . PHP_EOL
                        . '     * Column(name="' . $field . '", type="' . $type . '")' . PHP_EOL
                        . '     */' . PHP_EOL
                        . '    protected $' . $field . ';' . PHP_EOL . PHP_EOL . '    ';
            }
        }
        return $varStr;
    }

    /**
     * Create getters from table fields
     *
     * @name   _createGetterFromField
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array  $tableInfo Table info
     * @param string $classname classname
     *
     * @return void
     */
    private function _createGetterFromField($tableInfo, $classname)
    {
        $varStr   = '';
        $operator = '';
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {

                $functionName = $this->_getNameByType($field, 'function');
                $memberName   = $this->_getNameByType($field, 'member');
                $type         = $this->_getFieldType($value);

                if ('int' == $type) {
                    $operator = '"="';
                } else {
                    $operator = '"LIKE"';
                }

                $varStr .= '/**' . PHP_EOL
                        . '     * Get "' . $field . '"' . PHP_EOL
                        . '     *' . PHP_EOL
                        . '     * @param string $searchTerm input string' . PHP_EOL
                        . '     *' . PHP_EOL
                        . '     * @return string "' . $field . '"' . PHP_EOL
                        . '     */' . PHP_EOL
                        . '    public static function getBy' . $functionName . '($searchTerm)' . PHP_EOL
                        . '    {' . PHP_EOL
                        . '         $' . strtolower($functionName) . 's = ' . $classname . '::where("' . $field . '", ' . $operator . ', "%$searchTerm%");' . PHP_EOL
                        . '         return $' . strtolower($functionName) . 's;' . PHP_EOL
                        . '    }' . PHP_EOL . PHP_EOL . '    ';
            }
        }
        return $varStr;
    }

    /**
     * Convert field type into function name or member variable
     *
     * @name   _getNameByType
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $field field name
     * @param string $type  type name
     *
     * @return $name
     */
    private function _getNameByType($field, $type)
    {
        if ('function' == $type) {
            if (strstr($field, '_')) {
                $name = $this->_underscore2Camelcase($field, 'class');
            } else {
                $name = ucfirst($field);
            }
        }
        if ('member' == $type) {
            if (strstr($field, '_')) {
                $name = $this->_underscore2Camelcase($field);
            } else {
                $name = ($field);
            }
        }

        return $name;
    }

    /**
     * Get table field type
     *
     * @name   _getFieldType
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $fieldValue field
     *
     * @return $type
     */
    private function _getFieldType($fieldValue)
    {
        $type = '';
        if (strstr($fieldValue, '-')) {
            list($type) = explode('-', $fieldValue);
        } else {
            $type = $fieldValue;
        }

        return $type;
    }

    /**
     * Convert underscore seperated string into camelcase
     *
     * @name   _underscore2Camelcase
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $str  Input string
     * @param string $type type of string to convert into
     *
     * @return string
     */
    private function _underscore2Camelcase($str, $type = '')
    {
        // Split string in words.
        $words = explode('_', strtolower($str));

        $return = '';
        $i      = 0;
        foreach ($words as $word) {
            if ($i == 0) {
                if ('class' == $type) {
                    $return .= ucfirst(trim($word));
                } else {
                    $return .= trim($word);
                }
            } else {
                $return .= ucfirst(trim($word));
            }

            $i++;
        }

        return $return;
    }

}
