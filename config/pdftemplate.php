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

    'BINARY_PATH'   => env('WKHTMLTOPDF', '/var/www/html/framework/storage/wkhtmltopdf/wkhtmltox/bin/wkhtmltopdf'), // set the binary file path of wkhtmltopdf e.g (on windows 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe')
    'PDF_TEMPLATES' => [
        'ORIENTATION' => 'landscape', //page view landscape or portrait
        'PAGE_SIZE'   => 'A1', // A2, A3, A4
    ],
    'OTHER'         => [
        'orientation' => '',
        'page-size'   => '',
    ]
];
