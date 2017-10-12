<?php

/**
 *  Description
 *
 * @name       AdminController
 * @category   Controller
 * @package    Package
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 5883b2e0fd6c7f6be2d390d4375ce8582c260cdb $
 * @link       None
 * @filesource
 */

namespace Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Controllers\AdminBaseController;
use Modules\MyApps\Model\Tutorial;
use Modules\User\Model\UserPackage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use App\User;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_HeaderFooterDrawing;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Worksheet_HeaderFooter;
use PHPExcel_Worksheet_MemoryDrawing;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Fill;
use PHPExcel_Style_Border;
use PHPExcel_Chart_DataSeriesValues;
use PHPExcel_Chart_DataSeries;
use PHPExcel_Chart_Layout;
use PHPExcel_Chart_PlotArea;
use PHPExcel_Chart_Legend;
use PHPExcel_Chart_Title;
use PHPExcel_Chart;

/**
 * Class description
 *
 * @name     ClassName
 * @category Test
 * @package  Test
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class AdminController extends AdminBaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $jsFiles[] = $this->url . '/theme/' . Config::get('app.theme') . '/assets/admin/js/admin.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        $metadata = ['title' => 'Forgot Password', 'description' => 'Forgot Password', 'keywords' => 'Forgot Password'];
        $this->addMetadata($metadata);

        return view('Admin::auth.passwords.email');
    }
    
    
    /**
     * Show the Forgot password.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminShowLogin()
    {
        $metadata = ['title' => 'Login', 'description' => 'Login', 'keywords' => 'Login'];
        $this->addMetadata($metadata);
        
        return view('Admin::auth.login');
    }

    /**
     * Admin dahboard page
     *
     * @name   dashboard
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function dashboard()
    {
        $metadata = ['title' => 'Dashboard', 'description' => 'Dashboard', 'keywords' => 'Dashboard'];
        $this->addMetadata($metadata);
        return view('Admin::dashboard');
    }

    
    /**
     * Admin manage-tutorial page
     *
     * @name   showTutorialList
     * @access public
     * @author swapnil patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function showTutorialList()
    {
        $metadata = ['title' => 'Tutorial', 'description' => 'Manage Tutorial', 'keywords' => 'Tutorial'];
        $this->addMetadata($metadata);
        return view('Admin::manage-tutorial');
    }
    
    
    /**
     * This will show tutorial list data
     *
     * @name   getTutorialsList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getTutorialsList()
    {
        $arrTutorials = array();
        $arrTutorials = Tutorial::getTutorialList();
        return response()->json($arrTutorials);
        return view('Admin::manage-tutorial');
    }
    
    /**
     * This will show Search TutorialList
     *
     * @name   getSearchTutorialList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getSearchTutorialList(Request $request)
    {
        
        // validate inputs
        $messages = [
            'search.required' => 'Search is required.'
        ];
        
        $this->validate($request, [
            'search' => 'required' 
        ], $messages);
        
        
        $search = $request->search;
        $arrTutorial = array();
        
        if(isset($search) && !empty($search))
        {
            $arrTutorial = Tutorial::SearchTutorialList($search);
        }
               
        if(count($arrTutorial)=='0')
        {
            $arrTutorial = false;
        }
        
        return response()->json($arrTutorial);
        return view('Admin::manage-tutorial'); 
    }
    
    /**
     * This will save new Tutorial
     *
     * @name   saveTutorialDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    
    public function saveTutorialDetails(Request $request)
    {
        
        // validate inputs
        $messages = [
            'question.required' => 'Question is required.',
            'answer.required' => 'Answer is required.'
        ];
        
        $this->validate($request, [
            'question' => 'required',
            'answer'   => 'required'
        ], $messages);
        
        $question  = $request->question;
        $answer    = $request->answer;
        $status    = '0';
        $addTutorial  = Tutorial::saveNewTutorialDetails($question,$answer,$status);
        if($addTutorial)
        {
            \Session::flash('success','Tutorial added successfully .');
        }
    }
    
    
    /**
     * This will display Tutorial details into edit form
     *
     * @name   editTutorial
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    
    public function editTutorial(Request $request)
    {
        $id         = $request->id;
        $arrTutorial  = array();
        $arrTutorial = Tutorial::getTutorialDetails($id);
        return response()->json($arrTutorial);
        return view('Admin::manage-tutorial')->with('tutorialDetails', $arrTutorial);
    }
    
    
    /**
     * This will update existing Tutorial details.
     *
     * @name   UpdateTutorialDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function UpdateTutorialDetails(Request $request)
    {
        // validate inputs
        $messages = [
            'question.required' => 'Question is required.',
            'answer.required' => 'Answer is required.'
        ];
        
        $this->validate($request, [
            'question' => 'required',
            'answer'   => 'required'
        ], $messages);
        
        $question  = $request->question;
        $answer    = $request->answer;
        $status    = '0';
        $id        =  $request->id;
        
        if(!empty($id))
        {
            $updateTutorial = Tutorial::UpdateTutorial($id,$question,$answer,$status);
            if ($updateTutorial)
            {
                \Session::flash('success','Tutorial update successfully .');
            }
        }
    }
    
    
    /**
     * Admin manage-user page
     *
     * @name   showUsers
     * @access public
     * @author swapnil patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function showUsers()
    {
        $metadata = ['title' => 'Users', 'description' => 'Manage Users', 'keywords' => 'Users'];
        $this->addMetadata($metadata);
        return view('Admin::manage-user');
    }
    
    /**
     * This will show user list data
     *
     * @name   getUserList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getUserList()
    {
        $arrUsers = array();
        $arrUsers = User::getUserLists();
        return response()->json($arrUsers);
        return view('Admin::manage-user');
    }
    
    
    /**
     * This will show Search User List 
     *
     * @name   getSearchUserList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getSearchUserList(Request $request)
    {
        
        // validate inputs
        $messages = [
            'search.required' => 'Search is required.'
        ];
        
        $this->validate($request, [
            'search' => 'required'
        ], $messages);
        
        
        $search = $request->search;
        $arrUsers = array();
        
        if(isset($search) && !empty($search))
        {
            $arrUsers = User::SearchUserList($search);
        }
        
        if(count($arrUsers)=='0')
        {
            $arrUsers = false;
        }
        
        return response()->json($arrUsers);
        return view('Admin::manage-user');
    }
    
    
    /**
     * This will update user status (Active/Deactive).
     *
     * @name   UpdateUserStatus
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function UpdateUserStatus(Request $request)
    {  
        $id            = $request->id;
        $currentStatus = $request->status;
        $statusMSG = '';
        
        if($currentStatus=='0')     // if user current status is 0 then Activate this user 
        {
            $status        = '1';
            $statusMSG     = 'User reactivate successfully .';
        }
        else                        // if user current status is 1 then Deactivate this user 
        {
            $status        = '0';
            $statusMSG     = 'User deactivate successfully .';
        }
        
        if(!empty($id))
        {
            $updateTutorial = User::UpdateStatus($id,$status);
            if ($updateTutorial)
            {
                \Session::flash('success',$statusMSG);
            }
        }
    }
    
    /**
     * Admin logout page
     *
     * @name   adminLogout
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function adminLogout()
    {
        \Auth::logout();
        return \Redirect::to('admin/login');
    }

    /**
     * Admin can view and change his/her password details
     *
     * @name   changePasswordForm
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function changePasswordForm()
    {
        return view('Admin::change-password');
    }
    
    /**
     * User can chnage his/her password
     *
     * @name   changeAdminPassword
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @param Request $request Request details
     *
     * @return void
     */
    public function changeAdminPassword(Request $request)
    {
        $isValidated = $this->_changePasswordValidation($request);
        
        if (!$isValidated) {
            $message = 'The specified password does not match the database password';
            return view('Admin::change-password', compact('message'));
        }
        
        $response = User::savePassword($request);
        $message  = $response ? 'Your password has been reset successfully!' : 'Seems there is a technical issue please try after some time';
        
        return view('Admin::change-password', compact('message'));
    }
    
    /**
     * Validation rules for change password
     *
     * @name   _changePasswordValidation
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param Request $request Request details
     *
     * @return void
     */
    private function _changePasswordValidation(Request $request)
    {
        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ]);
        
        $data = $request->all();
        $user = User::find(auth()->user()->id);
        if (\Hash::check($data['old_password'], $user->password)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * Description Function to show reports page
     *
     * @name   reportExcel
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function reportExcel()
    {
        $data = $this->addJsCss();
        $this->loadJsCSS($data['jsFiles'], $data['cssFiles']);
        return view('Admin::report');
    }

    /**
     * Description Function to download sample excel report
     *
     * @name   reportExcelSample
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function reportExcelSample(Request $request)
    {
        $strTempDate      = $request->date;
        $strDate          = explode(' - ', $strTempDate);
        $strFromDate      = date('Y-m-d', strtotime($strDate[0]));
        $strToDate        = date('Y-m-d', strtotime($strDate[1]));
        $boolShowLogo     = (isset($request->logo)) ? 1 : 0;
        $boolShowTotal    = (isset($request->total)) ? 1 : 0;
        $boolShowPieChart = (isset($request->pie)) ? 1 : 0;


        $arrRandomData = $this->generateRandomData($strFromDate, $strToDate);

        $arrRandomData = array_reverse(array_sort($arrRandomData, 'date'));

        $objPHPExcel = new PHPExcel();
        // Set document properties

        $objPHPExcel->getProperties()->setCreator("Admin")
                ->setLastModifiedBy("Admin")
                ->setTitle("Sample Report")
                ->setSubject("Sample Report")
                ->setDescription("Sample Report")
                ->setKeywords("Sample Report")
                ->setCategory("Sample Report");
        // Create a first sheet


        $objPHPExcel->setActiveSheetIndex(0);

        if ($boolShowLogo) {
            $gdImage    = imagecreatefromjpeg($this->url . 'theme/' . $this->adminTheme . '/images/silicus.jpg');
            // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
            $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
            $objDrawing->setName('Silicus');
            $objDrawing->setDescription('Silicus');
            $objDrawing->setImageResource($gdImage);
            $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
            $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
            $objDrawing->setHeight(150);
            $objDrawing->setWidth(180);
            $objDrawing->setCoordinates('B1');
            $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        }

        $styleArray = array (
            'font' => array (
                'bold'  => true,
                'color' => array ('rgb' => '000000'),
                'size'  => 16,
                'name'  => 'Serif'
        ));

        $objPHPExcel->getActiveSheet(0)->setCellValue('A4', 'Silicus Technologies Pvt. Ltd.');
        $objPHPExcel->getActiveSheet(0)->getStyle('A4')->applyFromArray($styleArray);

        $startDateYear = date('Y', strtotime($strFromDate));
        $endDateYear   = date('Y', strtotime($strToDate));
        $startDate     = date('F d', strtotime($strFromDate));
        $endDate       = date('F d', strtotime($strToDate));

        if ($startDateYear == $endDateYear) {
            $reportDate = $startDate . " - " . $endDate . ", " . $startDateYear;
        } else {
            $reportDate = $startDate . ", " . $startDateYear . " - " . $endDate . ", " . $endDateYear;
        }

        $styleArray = array (
            'font' => array (
                'italic' => true,
                'color'  => array ('rgb' => '686868'),
                'size'   => 14,
                'name'   => 'Serif'
        ));

        $objPHPExcel->getActiveSheet(0)->setCellValue('A7', $reportDate);
        $objPHPExcel->getActiveSheet(0)->getStyle('A7')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet(0)->setTitle('Summary');

        $styleArray = array (
            'font'    => array (
                'name'  => 'Serif',
                'color' => array ('rgb' => 'FFFFFF'),
                'bold'  => true,
                'size'  => 12,
            ), 'borders' => array (
                'outline' => array (
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array ('argb' => '000000'),
                )
        ));

        $objPHPExcel->getActiveSheet()->setCellValue('A10', "Date");
        $objPHPExcel->getActiveSheet()->setCellValue('B10', "Categories");
        $objPHPExcel->getActiveSheet()->setCellValue('C10', "Amount Spent");
        $objPHPExcel->getActiveSheet(0)->getStyle('A10:C10')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet(0)->getStyle('A10:C10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
        $objPHPExcel->getActiveSheet(0)->getStyle('A10:C10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
        $objPHPExcel->getActiveSheet(0)->getRowDimension(10)->setRowHeight(22);
        $objPHPExcel->getActiveSheet(0)->getStyle('A10:C10')->getFill()->applyFromArray(array (
            'type'       => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array (
                'rgb' => 'F38B00'
            )
        ));

        $styleArray = array (
            'borders' => array (
                'outline' => array (
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array ('argb' => '000000'),
                )
        ));

        $intStartRow = 11;
        $intRow      = 11;

        foreach ($arrRandomData as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $intRow, date("d M' y", strtotime($value['date'])))
                    ->setCellValue('B' . $intRow, $value['category'])
                    ->setCellValue('C' . $intRow, $value['amount']);

            ++$intRow;
        }

        $intEndRow = $intRow - 1;
        $objPHPExcel->getActiveSheet(0)->getStyle('A' . $intStartRow . ':C' . $intEndRow)->applyFromArray($styleArray);

        if ($boolShowTotal) {
            $styleArray = array (
                'font'    => array (
                    'name'  => 'Serif',
                    'color' => array ('rgb' => '000000'),
                    'bold'  => true,
                    'size'  => 12,
                ), 'borders' => array (
                    'outline' => array (
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array ('argb' => '000000'),
                    )
            ));

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $intRow, "Total");
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $intRow, "=SUM(C" . $intStartRow . ":C" . $intEndRow . ")");
            $objPHPExcel->getActiveSheet(0)->getStyle('A' . $intRow . ':C' . $intRow)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet(0)->getStyle('A' . $intRow . ':C' . $intRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet(0)->getStyle('A' . $intRow . ':C' . $intRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet(0)->getRowDimension(10)->setRowHeight(22);
            $objPHPExcel->getActiveSheet(0)->getStyle('A' . $intRow . ':C' . $intRow)->getFill()->applyFromArray(array (
                'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array (
                    'rgb' => 'EEECE1'
                )
            ));
        }

        $currencyFormat = html_entity_decode("₹ 0,0.00", ENT_QUOTES, 'UTF-8');
        $objPHPExcel->getActiveSheet()->getStyle("C" . $intStartRow . ":C" . $intRow)->getNumberFormat()->setFormatCode($currencyFormat);

        foreach (range('A', 'C') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }

        if ($boolShowPieChart) {

            $objWorksheet = $objPHPExcel->getActiveSheet(0);

            $arrPieChartData = [];

            foreach ($arrRandomData as $arrData) {
                $arrPieChartData[$arrData['category']][] = $arrData['amount'];
            }

            $styleArray = array (
                'font'    => array (
                    'name'  => 'Serif',
                    'color' => array ('rgb' => 'FFFFFF'),
                    'bold'  => true,
                    'size'  => 12,
                ), 'borders' => array (
                    'outline' => array (
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array ('argb' => '000000'),
                    )
            ));

            $objPHPExcel->getActiveSheet()->setCellValue('F1', "Categories");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "Amount Spent");
            $objPHPExcel->getActiveSheet(0)->getStyle('F1:G1')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet(0)->getStyle('F1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
            $objPHPExcel->getActiveSheet(0)->getStyle('F1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
            $objPHPExcel->getActiveSheet(0)->getRowDimension(1)->setRowHeight(22);
            $objPHPExcel->getActiveSheet(0)->getStyle('F1:G1')->getFill()->applyFromArray(array (
                'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array (
                    'rgb' => 'F38B00'
                )
            ));

            $intRow = 2;

            foreach ($arrPieChartData as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $intRow, $key)
                        ->setCellValue('G' . $intRow, array_sum($value));

                $objPHPExcel->getActiveSheet()->getStyle("G" . $intRow . ":G" . $intRow)->getNumberFormat()->setFormatCode($currencyFormat);
                ++$intRow;
            }

            $intRow           = $intRow - 1;
            $rowIdsDataTitles = '$F$2:$F$' . $intRow;
            $rowIdsDataValues = '$G$2:$G$' . $intRow;

//            echo 'String', "'" . $objWorksheet->getTitle() . "'" . '!$F$' . 1;
//            exit;
            $dataseriesLabels1 = array (new \PHPExcel_Chart_DataSeriesValues('String', "'" . $objWorksheet->getTitle() . "'" . '!$G$' . 1, NULL, 1),);
            $xAxisTickValues1  = array (new \PHPExcel_Chart_DataSeriesValues('String', "'" . $objWorksheet->getTitle() . "'" . '!' . $rowIdsDataTitles, NULL, 4),);
            $dataSeriesValues1 = array (new \PHPExcel_Chart_DataSeriesValues('Number', "'" . $objWorksheet->getTitle() . "'" . '!' . $rowIdsDataValues, NULL, 4),);

            $series1 = new \PHPExcel_Chart_DataSeries(
                    PHPExcel_Chart_DataSeries::TYPE_PIECHART, // plotType
                    null, // plotGrouping
                    range(0, count($dataSeriesValues1) - 1), // plotOrder
                    $dataseriesLabels1, // plotLabel
                    $xAxisTickValues1, // plotCategory
                    $dataSeriesValues1 // plotValues
            );


            //Set up a layout object for the Pie chart
            $layout1 = new \PHPExcel_Chart_Layout();
            $layout1->setShowVal(TRUE);
            $layout1->setShowPercent(TRUE);

            //Set the series in the plot area
            $plotarea1 = new \PHPExcel_Chart_PlotArea($layout1, array ($series1));

            //Set the chart legend
            $legend1 = new \PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_LEFT, NULL, false);

            $title1 = new \PHPExcel_Chart_Title('Pie Chart Category Wise');

            //Create the chart
            $chart1 = new \PHPExcel_Chart(
                    'chart1', // name
                    $title1, // title
                    $legend1, // legend
                    $plotarea1, // plotArea
                    true, // plotVisibleOnly
                    0, // displayBlanksAs
                    NULL, // xAxisLabel
                    NULL   // yAxisLabel		- Pie charts don't have a Y-Axis
            );

            //Set the position where the chart should appear in the worksheet
            $chart1->setTopLeftPosition('F12');
            $chart1->setBottomRightPosition('L31');

            //Add the chart to the worksheet
            $objWorksheet->addChart($chart1);

            foreach (range('G', 'F') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
        }
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Silicus_Demo_Sample_Report.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit;
        return view('Admin::reports');
    }

    /**
     * GenerateRandomData
     *
     * @name   generateRandomData
     * @access public
     * @author Saurabh Kolhatkar <saurabh.kolhatkar@silicus.com>
     *
     * @param string $strFromDate from date
     * @param string $strToDate to date
     *
     * @return void
     */
    public function generateRandomData($strFromDate, $strToDate)
    {
        $arrRandom   = [];
        $arrCategory = ['Car', 'Entertainment', 'Food', 'Home', 'Medical', 'Personal Items', 'Travel', 'Utilities', 'Other'];


        for ($intCount = 0; $intCount < 50; $intCount++) {
            $arrRandom[$intCount]['category'] = $arrCategory[array_rand($arrCategory, 1)];
            $arrRandom[$intCount]['date']     = date('Y-m-d', rand(strtotime($strFromDate), strtotime($strToDate)));
            $arrRandom[$intCount]['amount']   = rand(500, 5000);
        }

        return $arrRandom;
    }

    /**
     *  Display Google Adwords Ads data Pie Chart in the excel report
     *
     * @name    displayPieChart
     * @access	public
     * @param   int $lastRowId excel row id
     * @param   array $arrData data array to plot on pie chart
     * @param   String $strTitle Pie chart title
     * @return	void
     */
    public function displayPieChart($lastRowId, $arrData, $title)
    {
        // make color changes as per company type in pie chart data series

        if (0 < count($arrData)) {
            $arrColumns  = $arrData;
            $formatRowId = $lastRowId;

            $styleArray = array (
                'font'    => array (
                    'name'  => 'Serif',
                    'color' => array ('rgb' => 'FFFFFF'),
                    'bold'  => true,
                    'size'  => 12,
                ), 'borders' => array (
                    'outline' => array (
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array ('argb' => '000000'),
                    )
            ));

            $objPHPExcel->getActiveSheet()->setCellValue('F4', "Categories");
            $objPHPExcel->getActiveSheet()->setCellValue('G4', "Amount Spent");
            $objPHPExcel->getActiveSheet(0)->getStyle('F4:G4')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet(0)->getStyle('F4:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
            $objPHPExcel->getActiveSheet(0)->getStyle('F4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
            $objPHPExcel->getActiveSheet(0)->getRowDimension(10)->setRowHeight(22);
            $objPHPExcel->getActiveSheet(0)->getStyle('F4:G4')->getFill()->applyFromArray(array (
                'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array (
                    'rgb' => 'F38B00'
                )
            ));

            ++$formatRowId;

            foreach ($arrColumns as $key => $value) {
                $this->setReportDataColoumnData($objPHPExcel, $arrColumn, $formatRowId, $this->strCompanyType, false, false);
                $objPHPExcel->getActiveSheet(0)->getStyle('G' . $formatRowId)->getNumberFormat()->setFormatCode('#,##0');

                ++$formatRowId;
            }

            $this->setCellBorderStyle($this->objPHPExcel, 'A' . $lastRowId . ':' . 'B' . --$formatRowId);
        }


        $objWorksheet = $this->objPHPExcel->getActiveSheet(0);
        $objWorksheet->fromArray(
                $arrData, NULL, 'A' . $lastRowId
        );

        $totRecords = count($arrData);
        $startRowId = $lastRowId + 1;
        $endRowId   = $lastRowId + $totRecords - 1;

        $rowIdsDataTitles = '$A$' . $startRowId . ':$A$' . $endRowId;
        $rowIdsDataValues = '$B$' . $startRowId . ':$B$' . $endRowId;

        //echo $objWorksheet->getTitle() . '!$B$' . $lastRowId;
        //exit;
        $dataseriesLabels1 = array (new \PHPExcel_Chart_DataSeriesValues('String', "'" . $objWorksheet->getTitle() . "'" . '!$B$' . $lastRowId, NULL, 1),);
        $xAxisTickValues1  = array (new \PHPExcel_Chart_DataSeriesValues('String', "'" . $objWorksheet->getTitle() . "'" . '!' . $rowIdsDataTitles, NULL, 4),);
        $dataSeriesValues1 = array (new \PHPExcel_Chart_DataSeriesValues('Number', "'" . $objWorksheet->getTitle() . "'" . '!' . $rowIdsDataValues, NULL, 4),);

        $series1 = new \PHPExcel_Chart_DataSeries(
                PHPExcel_Chart_DataSeries::TYPE_PIECHART, // plotType
                NULL, // plotGrouping
                range(0, count($dataSeriesValues1) - 1), // plotOrder
                $dataseriesLabels1, // plotLabel
                $xAxisTickValues1, // plotCategory
                $dataSeriesValues1          // plotValues
        );

        //Set up a layout object for the Pie chart
        $layout1 = new \PHPExcel_Chart_Layout();
        $layout1->setShowVal(TRUE);
        $layout1->setShowPercent(TRUE);

        //Set the series in the plot area
        $plotarea1 = new \PHPExcel_Chart_PlotArea($layout1, array ($series1));

        //Set the chart legend
        $legend1 = new \PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_LEFT, NULL, false);

        $title1 = new \PHPExcel_Chart_Title($title);

        //Create the chart
        $chart1 = new \PHPExcel_Chart(
                'chart1', // name
                $title1, // title
                $legend1, // legend
                $plotarea1, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                NULL, // xAxisLabel
                NULL   // yAxisLabel		- Pie charts don't have a Y-Axis
        );

        //Set the position where the chart should appear in the worksheet
        $endRowId = $endRowId + 2;
        $chart1->setTopLeftPosition('A' . $endRowId);
        $endRowId = $endRowId + 25;
        $chart1->setBottomRightPosition('G' . $endRowId);

        //Add the chart to the worksheet
        $objWorksheet->addChart($chart1);

        return $lastRowId = $endRowId;
    }

    /**
     * To add js and css files required
     *
     * @name   addJsCss
     * @access public
     * @return void
     */
    public function addJsCss()
    {
        $jsFiles = [
            $this->url . 'theme/' . $this->adminTheme . '/js/moment.min.js',
            $this->url . 'theme/' . $this->adminTheme . '/js/daterangepicker.js',
            $this->url . 'theme/' . $this->adminTheme . '/js/reports.js'
        ];




        $cssFiles = [
            $this->url . 'theme/' . $this->adminTheme . '/css/daterangepicker.css'
        ];

        return [
            'jsFiles'  => $jsFiles,
            'cssFiles' => $cssFiles,
        ];
    }
    
    /**
     * This will display Subscription details of User to Admin
     *
     * @name   GetSubscription
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     * @return array
     */
    
    public function GetSubscription(Request $request)
    {
        $id         = $request->id;
        $arrUserPackages = UserPackage::getAllPackagesByUser($id);
        return response()->json($arrUserPackages);
        return view('Admin::manage-user')->with('SubscriptionDetails', $arrUserPackages);
    }
}
