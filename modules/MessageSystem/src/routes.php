<?php

/**
 *  Routes page
 *
 * @name       routes.php
 * @category   Routes
 * @package    MessageSystem
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'Modules\MessageSystem\Controller'], function () {
    Route::get('messages/create', 'MessageAdminController@createMessage');
    Route::post('messages/create', 'MessageAdminController@createMessage');
    Route::get('messages/drafts', 'MessageAdminController@draftMessage');
    Route::post('messages/drafts', 'MessageAdminController@draftMessage');
    Route::get('messages/sent', 'MessageAdminController@sentMessage');
    Route::post('messages/sent', 'MessageAdminController@sentMessage');
    Route::get('messages/trash', 'MessageAdminController@trashMessage');
    Route::post('messages/trash', 'MessageAdminController@trashMessage');
    Route::get('messages/inbox', 'MessageAdminController@inboxMessage');
    Route::post('messages/inbox', 'MessageAdminController@inboxMessage');
    Route::get('messages/delete/{arrayIds}', 'MessageAdminController@deleteMessage');
    Route::get('messages/deleteDraft/{arrayIds}', 'MessageAdminController@deleteDraftMessage');
    Route::get('messages/sentDraftMessage/{messageId}', 'MessageAdminController@sentDraftMessage');
    Route::get('messages/moveToTrashMessageFromInbox/{arrayIds}', 'MessageAdminController@moveToTrashMessageFromInbox');
    Route::get('messages/moveToTrashMessageFromSent/{arrayIds}', 'MessageAdminController@moveToTrashMessageFromSent');
    Route::get('messages/showMessage/{messageId}/{folderName}', 'MessageAdminController@showMessage');
    Route::get('messages/restoreMessage/{messageId}', 'MessageAdminController@restoreMessage');
    Route::get('messages/showTrashMessage/{messageId}/{folderName}', 'MessageAdminController@showTrashMessage');
    Route::get('messages/showDraftMessage/{messageId}/{folderName}', 'MessageAdminController@showDraftMessage');
    Route::get('messages/reply/{messageId}/{folderName}', 'MessageAdminController@replyMessage');
    Route::get('messages/forward/{messageId}/{folderName}', 'MessageAdminController@forwardMessage');
});

Route::group(['middleware' => ['web', 'auth', 'acl'], 'namespace' => 'Modules\MessageSystem\Controller'], function () {
    Route::get('messages/create', [
        'uses'       => 'MessageController@createMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::post('messages/create', [
        'uses'       => 'MessageController@createMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::get('messages/drafts', [
        'uses'       => 'MessageController@draftMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::post('messages/drafts', [
        'uses'       => 'MessageController@draftMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::get('messages/sent', [
        'uses'       => 'MessageController@sentMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::post('messages/sent', [
        'uses'       => 'MessageController@sentMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::get('messages/trash', [
        'uses'       => 'MessageController@trashMessage',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::post('messages/trash', [
        'uses'       => 'MessageController@trashMessage',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::get('messages/inbox', [
        'uses'       => 'MessageController@inboxMessage',
        'permission' => ['module' => 'message', 'action' => 'view'],
    ]);

    Route::post('messages/inbox', [
        'uses'       => 'MessageController@inboxMessage',
        'permission' => ['module' => 'message', 'action' => 'view'],
    ]);

    Route::get('messages/delete/{arrayIds}', [
        'uses'       => 'MessageController@deleteMessage',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::get('messages/deleteDraft/{arrayIds}', [
        'uses'       => 'MessageController@deleteDraftMessage',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::get('messages/restoreMessage/{messageId}', [
        'uses'       => 'MessageController@restoreMessage',
        'permission' => ['module' => 'message', 'action' => 'edit'],
    ]);

    Route::get('messages/sentDraftMessage/{messageId}', [
        'uses'       => 'MessageController@sentDraftMessage',
        'permission' => ['module' => 'message', 'action' => 'edit'],
    ]);

    Route::get('messages/moveToTrashMessageFromInbox/{arrayIds}', [
        'uses'       => 'MessageController@moveToTrashMessageFromInbox',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::get('messages/moveToTrashMessageFromSent/{arrayIds}', [
        'uses'       => 'MessageController@moveToTrashMessageFromSent',
        'permission' => ['module' => 'message', 'action' => 'delete'],
    ]);

    Route::get('messages/showMessage/{messageId}/{folderName}', [
        'uses'       => 'MessageController@showMessage',
        'permission' => ['module' => 'message', 'action' => 'view'],
    ]);

    Route::get('messages/showTrashMessage/{messageId}/{folderName}', [
        'uses'       => 'MessageController@showTrashMessage',
        'permission' => ['module' => 'message', 'action' => 'view'],
    ]);

    Route::get('messages/showDraftMessage/{messageId}/{folderName}', [
        'uses'       => 'MessageController@showDraftMessage',
        'permission' => ['module' => 'message', 'action' => 'view'],
    ]);

    Route::get('messages/reply/{messageId}/{folderName}', [
        'uses'       => 'MessageController@replyMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);

    Route::get('messages/forward/{messageId}/{folderName}', [
        'uses'       => 'MessageController@forwardMessage',
        'permission' => ['module' => 'message', 'action' => 'add'],
    ]);
});
