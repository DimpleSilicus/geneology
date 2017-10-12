<?php

/**
 * Page class to add / edit / delete Tutorial
 *
 * @name       Tutorial.php
 * @category   Model
 * @package    Tutorial
 * @author     Swapnil Patil <SwapnilJ.Patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */

namespace Modules\MyApps\Model;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;


class Tutorial extends BaseModel
{

    protected $primaryKey = 'id';
    protected $table = 'tutorials';
    protected $guarded = ['created_at','updated_at'];

    
    /**
     * This will lists all the Tutorial data
     *
     * @name   getTutorialList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function getTutorialList()
    {
        $result = array();
        $query = self::select('id','question','answer','status');
        $result = $query->get();
        return $result;
    }
    
    /**
     * This will lists all the Tutorial Search data 
     *
     * @name   SearchTutorialList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * 
     * @return void
     */
    
    public static function SearchTutorialList($search)
    {          
        $result = array();
        $query = self::where('question','like','%'.$search.'%')->orWhere('answer','like','%'.$search.'%'); 
        $result = $query->get();
        return $result;
    } 
        
    /**
     * This will saves Tutorial details to the database.
     *
     * @name   saveTutorialDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     *
     * @return void
     */
    
    public static function saveNewTutorialDetails($question,$answer,$status)
    {
        $tutorial            = new self();
        $tutorial->question  = $question;
        $tutorial->answer    = $answer;
        $tutorial->status    = $status;
        $tutorial->save();
        return back();
    }
    
    
    /**
     * This will get the Tutorial details in edit form
     *
     * @name   getTutorialDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param array : $id - of event id which you want to edit
     *
     * @return void
     */
    
    public static function getTutorialDetails($id)
    {
        if('' != $id)
        {
            $result = array();
            $result  = Tutorial::find($id);
            return $result ;
        }
        
    } 
    
    /**
     * This will update Tutorial details to the database.
     *
     * @name   UpdateTutorial
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param array : $id - of Tutorial which you want to update
     *
     * @return void
     */
    
    public static function UpdateTutorial($id,$question,$answer,$status)
    {
        if (isset($id) && $id != '')
        {
            $tutorial            = self::find($id);
            $tutorial->question  = $question;
            $tutorial->answer    = $answer;
            $tutorial->status    = $status;
            $tutorial->save();
            return back();
        }
    } 

}
