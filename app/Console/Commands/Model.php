<?php

/**
 *  This will generate models files for all tables
 *
 * @name       Model.php
 * @category   Commands
 * @package    Console
 * @author     Swati Jadhav <swati.jadhav@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT:
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
class Model extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate model files for all tables';

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

        $dbName = \Config::get('database.connections.' . \Config::get('database.default') . '.database');
        if ('' == $dbName) {
            print "Please set database in configuration.";
            return;
        }
        $tableInfo        = null;
        $tables           = $this->_getAllTables($dbName);
        $source           = base_path('resources/model/');
        $destination      = storage_path('model-generator');
        $excludeTableList = ['users', 'password_resets', 'migrations'];

        if (empty($tables)) {
            print("Database empty. No table to generate model files.");
            return;
        }
        foreach ($tables as $table) {
            if (!in_array($table, $excludeTableList)) {
                $commandInput = $this->_getInputFromCommand($table);
                if (trim($commandInput) == 'yes') {
                    $tableInfo = $this->_getTableInfo($table);
                    $tableName = $table;
                    $className = $this->_getClassName($table);
                    $this->_createFile($source, $destination, $className);
                    $this->_renameFile($destination, $className);
                    $this->_setModel($destination . '/' . $className . '.php', $className, $tableName, $tableInfo);
                }
            }
        }

        print("Model files generated successfully at location {$destination}");
    }

    /**
     * Description
     *
     * @name   _getInputFromCommand
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $table table name
     *
     * @return void
     */
    private function _getInputFromCommand($table)
    {
        echo "Do you want to create model file for table {$table}?  Type 'yes' to continue: ";
        $handle       = fopen("php://stdin", "r");
        $commandInput = fgets($handle);
        fclose($handle);
        echo "\n";
        return $commandInput;
    }

    /**
     * Description
     *
     * @name   _getClassName
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $table table name
     *
     * @return void
     */
    private function _getClassName($table)
    {
        if (strstr($table, '_'))
            $classname = $this->_underscore2Camelcase($table, 'class');
        else
            $classname = ucfirst($table);

        return $classname;
    }

    /**
     * Description
     *
     * @name   _createModelFile
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $source      Source folder
     * @param string $destination Destination folder
     *
     * @return void
     */
    private function _createFile($source, $destination)
    {
        if (!is_dir($destination)) {
            print('Folder model-geneartor doesn\'t exist. Please create it');
            return false;
        } else {
            copy($source . '/sample.ph', $destination . DIRECTORY_SEPARATOR . '/sample.php');
        }

        return true;
    }

    /**
     * Description
     *
     * @name   _renameFile
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $destination Destination folder
     * @param string $table       table name
     *
     * @return void
     */
    private function _renameFile($destination, $table)
    {
        if (!file_exists($destination . DIRECTORY_SEPARATOR . '/sample.php')) {
            print('File doesn\'t exist to rename');
            return false;
        } else {
            rename($destination . DIRECTORY_SEPARATOR . '/sample.php', $destination . DIRECTORY_SEPARATOR . "/{$table}.php");
        }
        return true;
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

    /**
     * Get all table names
     *
     * @name   _getAllTables
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $dbName database name
     *
     * @return array $tables Table names list
     */
    private function _getAllTables($dbName)
    {
        $tables = [];
        $data   = \DB::select("SHOW TABLES");
        foreach ($data as $table) {
            foreach ($table as $key => $value)
                $tables[] = $value;
        }
        return $tables;
    }

    /**
     * Get table information
     *
     * @name   _getTableInfo
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
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
     * Replace dummy code from model class
     *
     * @name   _setModel
     * @access private
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $file      Model file path
     * @param string $className Class name
     * @param string $tableName Table name
     * @param array  $tableInfo Table field information
     *
     * @return void
     */
    private function _setModel($file, $className, $tableName, $tableInfo)
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

        $content         = $this->_getCreatSearchContent($tableInfo, $className);
        $memberVariables = $this->_createVariableFromField($tableInfo);
        $getters         = $this->_createGetterFromField($tableInfo, $className);
        $search          = ['@USample@', '@LSample@', '@TableName@', '@Fillable@', '@Rules@', '@SEARCH_CONTENT@', '@MEMBER_VARIABLES@', '@GETTER_FUNC@'];
        $replace         = [$className, strtolower($className), $tableName, $fillable, $rules, $content, $memberVariables, $getters];

        $this->_replaceCode($search, $replace, $file);
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
        $excludeField = ['id', 'created_at', 'updated_at'];

        $searchContent = '';
        $i             = 0;
        if (count($tableInfo)) {
            foreach ($tableInfo as $field => $value) {
                if (!in_array($field, $excludeField)) {
                    if ($i == 0) {
                        $searchContent .= '@Usample@::where("' . $field . '", "LIKE", "%$searchTerm%")';
                    } else {
                        $searchContent .= '->orWhere("' . $field . '", "LIKE", "%$searchTerm%")';
                    }
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
     * Replace dummy code with given options
     *
     * @name   _replaceCode
     * @access private
     * @author Swati Jadhav <swati.jadhav@silicus.com>
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

}

?>