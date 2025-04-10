<?php
/**
 * -----------------------------------------------------------------
 * NOTE : There is two routes has a name (user & group),
 * any change in these two route's name may cause an issue
 * if not modified in all places that used in (e.g Chatify class,
 * Controllers, chatify javascript file...).
 * -----------------------------------------------------------------
 */

use Illuminate\Support\Facades\Route;

/*
* This is the main app route [Chatify Messenger]
*/
Route::get('/', 'Chatify\Http\Controllers\MessagesController@index')->name('chatify.index');

/**
 *  Fetch info for specific id [user/group]
 */
Route::post('/idInfo', 'Chatify\Http\Controllers\MessagesController@idFetchData');

/**
 * Send message route - Using our custom controller
 */
Route::post('/sendMessage', 'App\Http\Controllers\CustomChatifyController@send')->name('chatify.send.message');

/**
 * Test connection route - Custom route
 */
Route::post('/testConnection', 'App\Http\Controllers\CustomChatifyController@testConnection')->name('test.connection');

/**
 * Fetch messages
 */
Route::post('/fetchMessages', 'Chatify\Http\Controllers\MessagesController@fetch')->name('chatify.fetch.messages');

/**
 * Download attachments route to create a downloadable links
 */
Route::get('/download/{fileName}', 'Chatify\Http\Controllers\MessagesController@download')->name('chatify.download');

/**
 * Authentication for pusher private channels
 */
Route::post('/chat/auth', 'Chatify\Http\Controllers\MessagesController@pusherAuth')->name('chatify.pusher.auth');

/**
 * Make messages as seen
 */
Route::post('/makeSeen', 'Chatify\Http\Controllers\MessagesController@seen')->name('chatify.messages.seen');

/**
 * Get contacts
 */
Route::get('/getContacts', 'Chatify\Http\Controllers\MessagesController@getContacts')->name('chatify.contacts.get');

/**
 * Update contact item data
 */
Route::post('/updateContacts', 'Chatify\Http\Controllers\MessagesController@updateContactItem')->name('chatify.contacts.update');


/**
 * Star in favorite list
 */
Route::post('/star', 'Chatify\Http\Controllers\MessagesController@favorite')->name('chatify.star');

/**
 * get favorites list
 */
Route::post('/favorites', 'Chatify\Http\Controllers\MessagesController@getFavorites')->name('chatify.favorites');

/**
 * Search in messenger
 */
Route::get('/search', 'Chatify\Http\Controllers\MessagesController@search')->name('chatify.search');

/**
 * Get shared photos
 */
Route::post('/shared', 'Chatify\Http\Controllers\MessagesController@sharedPhotos')->name('chatify.shared');

/**
 * Delete Conversation
 */
Route::post('/deleteConversation', 'Chatify\Http\Controllers\MessagesController@deleteConversation')->name('chatify.conversation.delete');

/**
 * Delete Message
 */
Route::post('/deleteMessage', 'Chatify\Http\Controllers\MessagesController@deleteMessage')->name('chatify.message.delete');

/**
 * Update setting
 */
Route::post('/updateSettings', 'Chatify\Http\Controllers\MessagesController@updateSettings')->name('chatify.avatar.update');

/**
 * Set active status
 */
Route::post('/setActiveStatus', 'Chatify\Http\Controllers\MessagesController@setActiveStatus')->name('chatify.activeStatus.set');






/*
* [Group] view by id
*/
Route::get('/group/{id}', 'Chatify\Http\Controllers\MessagesController@index')->name('chatify.group');

/*
* user view by id.
* Note : If you added routes after the [User] which is the below one,
* it will considered as user id.
*
* e.g. - The commented routes below :
*/
// Route::get('/route', function(){ return 'Munaf'; }); // works as a route
Route::get('/{id}', 'Chatify\Http\Controllers\MessagesController@index')->name('chatify.user');
// Route::get('/route', function(){ return 'Munaf'; }); // works as a user id
