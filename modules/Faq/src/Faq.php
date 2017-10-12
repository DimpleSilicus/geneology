<?php

/**
 *  Model file for faq
 *
 * @name       Faq.php
 * @category   Model
 * @package    Faq
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\Faq;

use App\BaseModel;

/**
 * Faq Model file
 *
 * @name     Faq
 * @category Model
 * @package  Faq
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Faq extends BaseModel
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'faq';

    /**
     * Set fillable fields
     *
     * @var array
     */
    protected $fillable = ['question', 'answer', 'status'];

    /**
     * Set validation rules
     *
     * @var array
     */
    public static $rules = ['question' => 'required', 'answer' => 'required'];

    /**
     * M /ember variable "id"
     *
     * @var string "id"
     *
     * Column(name="id", type="int")
     */
    protected $id;

    /**
     * Member variable "question"
     *
     * @var string "question"
     *
     * Column(name="question", type="varchar")
     */
    protected $question;

    /**
     * Member variable "answer"
     *
     * @var string "answer"
     *
     * Column(name="answer", type="varchar")
     */
    protected $answer;

    /**
     * Member variable "status"
     *
     * @var string "status"
     *
     * Column(name="status", type="int")
     */
    protected $status;

    /**
     * Member variable "createdAt"
     *
     * @var string "createdAt"
     *
     * Column(name="createdAt", type="timestamp")
     */
    protected $createdAt;

    /**
     * Member variable "updatedAt"
     *
     * @var string "updatedAt"
     *
     * Column(name="updatedAt", type="timestamp")
     */
    protected $updatedAt;

    /**
     * Get "id"
     *
     * @param string $searchTerm input string
     *
     * @return string "id"
     */
    public function getId($searchTerm)
    {
        $ids = Faq::where("id", "=", "%$searchTerm%");
        return $ids;
    }

    /**
     * Get "question"
     *
     * @param string $searchTerm input string
     *
     * @return string "question"
     */
    public function getQuestion($searchTerm)
    {
        $questions = Faq::where("question", "LIKE", "%$searchTerm%");
        return $questions;
    }

    /**
     * Get "answer"
     *
     * @param string $searchTerm input string
     *
     * @return string "answer"
     */
    public function getAnswer($searchTerm)
    {
        $answers = Faq::where("answer", "LIKE", "%$searchTerm%");
        return $answers;
    }

    /**
     * Get "status"
     *
     * @param string $searchTerm input string
     *
     * @return string "status"
     */
    public function getStatus($searchTerm)
    {
        $statuss = Faq::where("status", "=", "%$searchTerm%");
        return $statuss;
    }

    /**
     * Get "created_at"
     *
     * @param string $searchTerm input string
     *
     * @return string "created_at"
     */
    public function getCreatedAt($searchTerm)
    {
        $createdats = Faq::where("created_at", "LIKE", "%$searchTerm%");
        return $createdats;
    }

    /**
     * Get "updated_at"
     *
     * @param string $searchTerm input string
     *
     * @return string "updated_at"
     */
    public function getUpdatedAt($searchTerm)
    {
        $updatedats = Faq::where("updated_at", "LIKE", "%$searchTerm%");
        return $updatedats;
    }

    /**
     * This will create new entery into Faq
     *
     * @name   MethodName
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param array $request input array
     *
     * @return void
     */
    public static function store($request)
    {
        Faq::create($request);
    }

    /**
     * Search in module
     *
     * @name   searchByAll
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param string $searchTerm input string
     *
     * @return void
     */
    public static function searchByAll($searchTerm)
    {
        $faq = Faq::where("question", "LIKE", "%$searchTerm%")->orWhere("answer", "LIKE", "%$searchTerm%")->orWhere("status", "LIKE", "%$searchTerm%")->paginate(5);

        return $faq;
    }

    /**
     * Create record
     *
     * @name   createRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param array $input input array
     *
     * @return void
     */
    public static function createRecord($input)
    {
        Faq::create($input);
    }

    /**
     * Update record
     *
     * @name   updateRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int   $id    record id
     * @param array $input input array
     *
     * @return void
     */
    public static function updateRecord($id, $input)
    {
        $faq = Faq::find($id);
        $faq->update($input);
    }

    /**
     * Delete record
     *
     * @name   deleteRecord
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int $id record id
     *
     * @return void
     */
    public static function deleteRecord($id)
    {
        Faq::find($id)->delete();
    }

    /**
     * Paginate record
     *
     * @name   paginateRecords
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @return $contact record set
     */
    public static function paginateRecords()
    {
        $faq = Faq::where('status', 1)->paginate(20);
        return $faq;
    }

    /**
     * This will lists all the faq created by the user.
     *
     * @name   getAllFaq
     * @access public static
     * @author Prasad Nanaware <prasad.nanaware@silicus.com>
     *
     * @param array $filter values for filter records
     *
     * @return void
     */
    static function getAllFaq($filter)
    {
        $query = self::select('question', 'answer', 'status', 'id as edit', 'id as delete');

        if ($filter['search']) {
            $query->where('question', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('answer', 'like', '%' . $filter['search'] . '%');
        }

        $query->offset($filter['start']);
        $query->limit($filter['length']);
        $query->orderBy($filter['sortBy'], $filter['sortOrder']);

        $result = $query->get();

        return $result;
    }

    /**
     * This will return notification count.
     *
     * @name   getFaqCount
     * @access public static
     * @author Prasad Nanaware <prasad.nanaware@silicus.com>
     *
     * @param array $filter values for filter records
     *
     * @return void
     */
    static function getFaqCount($filter)
    {
        if ($filter['search']) {
            $query  = self::where('question', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('answer', 'like', '%' . $filter['search'] . '%');
            $result = $query->count();
        } else {
            $result = self::count();
        }
        return $result;
    }

}
