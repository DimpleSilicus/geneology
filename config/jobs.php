<?php

/**
 * Configuration file to set application meta data.
 *
 * @name        pdftemplate.php
 * @category    ToolKit
 * @package     PDFTemplate
 * @author      Vivek Kale <vivek.kale@silicus.com>
 * @license     Silicus http://www.silicus.com/
 * @version     GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link        http://wkhtmltopdf.org/usage/wkhtmltopdf.txt
 * @description You can add more parameters using above reference @link
 * @filesource
 */
return [
    'DESTINATION_PATH' => env('JOBAPPLICATION', '/var/www/html/framework/public/job_applications'), // set the destination file path to upload resume e.g (on windows 'D:\projects\demo\public\job_applications')
    'ADMIN_NAME'       => env('ADMIN_NAME', 'Admin'), // set the admin name
    'ADMIN_EMAIL'      => env('ADMIN_EMAIL', 'vivek.kale@silicus.com'), // set the admin email
];
