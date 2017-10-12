<?php

/**
 * FileUploader class to set application meta data.
 *
 * @name       FileUploader.php
 * @category   Uploader
 * @package    Uploader
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: c4755e1be0447eb1558ee325aceb00816a13c727 $
 * @link       None
 * @filesource
 */
return [

    'DEFAULT'           => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/myfiles/' : $_SERVER['DOCUMENT_ROOT'] . '/myfiles/', // destination folder name to store e.g public/myfiles
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|zip|bmp|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'BANNERS'           => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/banners/' : $_SERVER['DOCUMENT_ROOT'] . '/banners/', // destination folder name to store e.g public/banners
        'FOLDER_NAME'           => 'banners',
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'DOCUMENTS'         => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/documents/' : $_SERVER['DOCUMENT_ROOT'] . '/documents/', // destination folder name to store e.g public/documents
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'pdf|doc|docx|ppt|pptx|xls|xlsx', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'IMAGES'            => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/myimages/' : $_SERVER['DOCUMENT_ROOT'] . '/myimages/', // destination folder name to store e.g public/myimages
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|zip|bmp|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'ADDIMAGESGALLERY'  => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/imagegallery/' : $_SERVER['DOCUMENT_ROOT'] . '/imagegallery/', // destination folder name to store e.g public/myimages
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'EDITIMAGESGALLERY' => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/imagegallery/' : $_SERVER['DOCUMENT_ROOT'] . '/imagegallery/', // destination folder name to store e.g public/myimages
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'ADDIMAGESSLIDER'   => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/slider/' : $_SERVER['DOCUMENT_ROOT'] . '/slider/', // destination folder name to store e.g public/slider
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/slider/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'EDITIMAGESSLIDER'  => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/slider/' : $_SERVER['DOCUMENT_ROOT'] . '/slider/', // destination folder name to store e.g public/slider
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/slider/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'REMINDER'          => [
        'DESTINATION'           => '',
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'CONTACTS'          => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/contacts/' : $_SERVER['DOCUMENT_ROOT'] . '/contacts/', // destination folder name to store e.g public/myfiles
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|zip|bmp|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'VIDEOGALLERY'      => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/videogallery/' : $_SERVER['DOCUMENT_ROOT'] . '/videogallery/', // destination folder name to store e.g public/myimages
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/myuploads/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'mp4|flv|mp3', // set allowed extensions
        'MAX_FILES_UPLOAD'      => 5, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'TESTIMONIALS'      => [
        'DESTINATION'           => '/testimonials-images/',
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/testimonials-images-watermark/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', //width X height (remove if you dont want to create medium image)
    ],
    'JOBS'              => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/job_applications/' : $_SERVER['DOCUMENT_ROOT'] . '/job_applications/', // destination folder name to store e.g public/job_applications
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/job_applications/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|zip|bmp|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'JOBS_LOGO'         => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/job_logo/' : $_SERVER['DOCUMENT_ROOT'] . '/job_logo/', // destination folder name to store e.g public/job_applications
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/job_applications/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif|pdf|doc|docx|ppt|pptx|xls|xlsx|zip|bmp|mp4', // set allowed extensions
        'MAX_FILES_UPLOAD'      => null, // set number of files to upload
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => false, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '80X80', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '50X50', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '120X120', //width X height (remove if you dont want to create medium image)
    ],
    'EVENTIMAGES'       => [
        'DESTINATION'           => function_exists('public_path') ? public_path() . '/eventgallery/' : $_SERVER['DOCUMENT_ROOT'] . '/eventgallery/', // destination folder name to store e.g public/myimages
        'DESTINATION_FOLDER'    => '/eventgallery/',
        'IS_USER_SPECIFIC'      => false, // set true to upload file to user specific folder
        'WATERMARK_IMAGE_PATH'  => 'public/eventgallery/', // set watermark image path
        'ALLOWED_EXTENSIONS'    => 'jpg|jpeg|png|gif', // set allowed extensions
        'MAX_FILES_SIZE'        => 100, // set max file size in MB
        'MULTIPLE_FILES_UPLOAD' => true, // set true to upload multiple files, false to upload single file
        'MAX_IMAGE_HEIGHT'      => null, // set max image height
        'MAX_IMAGE_WIDTH'       => null, // set max image widht
        'THUMBNAIL'             => '120X120', //width X height (remove if you dont want to create thumbnail image)
        'SMALL'                 => '80X80', //width X height (remove if you dont want to create small image)
        'MEDIUM'                => '290X240', /* width X height (remove if you dont want to create medium image) */
    ]
];
