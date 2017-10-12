<?php

/**
 * Routes is using for urls and namespace used for give path for controller
 *
 * @name       routes.php
 * @category   Route
 * @package    Apps
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
Route::group([
    'middleware' => [
        'web',
        'auth'
    ],
    
    'namespace' => 'Modules\MyApps\Controller'
], function () {
    Route::get('myapps/list', 'MyAppsController@getMyNetwork');
    
    // Picture App routes
    Route::get('picture-app/list', 'PictureAppController@getAllPictures');
    Route::post('picture-app/uploadPicture', 'PictureAppController@uploadPicture');
    Route::post('picture-app/editPicture', 'PictureAppController@editPicture');
    Route::post('picture-app/details', 'PictureAppController@getPictureDetailsByPictureId');
    Route::post('picture-app/deletePic', 'PictureAppController@deletePic');
    Route::post('picture-app/sharePic', 'PictureAppController@sharePicture');
    
    // Video App routes
    Route::get('video-app/list', 'VideoAppController@getAllVideos');
    Route::post('video-app/uploadVideo', 'VideoAppController@uploadVideo');
    Route::post('video-app/editVideo', 'VideoAppController@editVideo');
    Route::post('video-app/details', 'VideoAppController@getVideoDetailsByVideoId');
    Route::post('video-app/deleteVideo', 'VideoAppController@deleteVideo');
    Route::post('video-app/shareVideo', 'VideoAppController@shareVideo');
    
    // route for App home page
    Route::get('myapps/apps', 'MyAppsController@getMyNetwork');
    Route::post('myapps/shareResource', 'MyAppsController@ShareResourceToUser');
    
    // routes for Journals App 
	Route::get('journal-app/list','JournalAppController@getJournalList');   // route to display journal list
	Route::post('journal-app/addJournal','JournalAppController@saveJournal');  // route to add new Journal
	Route::post('journal-app/deleteJournal','JournalAppController@deleteJournalRecord');  // route to delete existing journal 
	Route::get('journal-app/editJournal','JournalAppController@editJournal');  // route to get journal details
	Route::post('journal-app/updateJournal','JournalAppController@UpdateJournalDetails');  // route to edit existing journal
	Route::get('journal-app/getJournalOnNetwork','JournalAppController@getJournalInDetailsForNetwork');  // route to get journal details on network
	Route::post('journal-app/shareJournalOnNetwork','JournalAppController@SharedJournalOnNetwork');  // route to share Journal within network
	Route::get('journal-app/getSingleJournal','JournalAppController@getJournalInDetailsForNetwork');  // route to get Personnel Journal
	Route::post('journal-app/shareJournalsToUser','JournalAppController@ShareJournalToPerson');  // route to share Journal personnely
	Route::get('journal-app/getPrivacySettings','JournalAppController@getModulePrivacySettings');  // route to get Journal Privacy Settings
	
	// routes for Events App
	Route::get('event-app/list','EventsAppController@getEventList');   // route to display Event list
	Route::post('event-app/addEvent','EventsAppController@saveNewEventDetails');  // route to add new Event
	Route::post('event-app/deleteEvent','EventsAppController@deleteEventRecord');  // route to delete existing Event
	Route::get('event-app/editEvent','EventsAppController@editEvents');  // route to get Event details
	Route::post('event-app/updateEvent','EventsAppController@UpdateEventDetails');  // route to Update existing event
	Route::get('event-app/getEventOnNetwork','EventsAppController@getEventDetailsForNetwork');  // route to get Event details on network
	Route::post('event-app/shareEventOnNetwork','EventsAppController@ShareEventOnNetwork');  // route to share Event within network
	Route::get('event-app/getSingleEvent','EventsAppController@getEventDetailsForNetwork');  // route to get Personnel Event 
	Route::post('event-app/shareEventsPersonnely','EventsAppController@ShareEventToPerson');  // route to share Event personnely
	
	// routes for Resources App
	Route::get('resource-app/list','ResourceAppController@getResourceList');   // route to display Resource list
	Route::post('resource-app/search','ResourceAppController@searchResourceList');   // route to display Resource list
	Route::post('resource-app/addQueue','ResourceAppController@AddQueueDetails');   // route to add new Queue
	Route::post('resource-app/deleteQueue','ResourceAppController@deleteQueueRecord');   // route to add new Queue
	Route::get('resource-app/getFamily','ResourceAppController@memberDetails');   // route to get family details
	
	
	// routes for Tutorial App
	Route::get('tutorial-app/list','TutorialAppController@showTutorial');   // show tutorial page
	Route::get('tutorial-app/tutorialList','TutorialAppController@TutorialList');   // show tutorial list
	Route::post('tutorial-app/search','TutorialAppController@getSearchTutorialList');   // route to display search tutorial list
	
});
