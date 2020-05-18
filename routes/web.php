<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/searchinput','HomeController@searchInput');

Route::post('/searchinput','HomeController@searchInput')->name('ajax');

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

//route voor te zoeken op categorie linkse list
Route::get('/cat/{catId}','HomeController@searchCat');

//route voor alle zoekertjes te laten zien van de eigenaar van het zoekertje waar op geklikt werd 
Route::get('/currentUser/guest/myAdver/guest/{userId}', 'HomeController@showAdverGuest')->middleware('verified');

//route voor de advertentie te laten zien waar op geklikt word
Route::get('/showAdverUser/{adverId}', 'HomeController@showAdverUser')->name('showAdverUser');

//view openen email versturen
Route::get('/sendmail/{adverId}', 'HomeController@showSendMail')->middleware('verified');

// email sturen
Route::post('/sendmail/{adverId}', 'HomeController@sendMailToAdverUser')->middleware('verified');

//route voor het profiel te laten zien van de huidige geklikte zoekertje
Route::get('/currentUser/guest/{user_id}', 'HomeController@showUserAdver')->middleware('verified');

// beoordeling
Route::post('/currentUser/guest/{user_id}/{guest_id}', 'HomeController@review')->middleware('verified');

Route::delete('/currentUser/guest/{review_id}', 'HomeController@reviewDestroy')->middleware('verified');

Route::get('/resetpassword', 'currentUserController@showFormReset')->middleware('verified');

Route::post('/resetpassword','currentUserController@changePassword')->middleware('verified')->name('resetpassword');

Route::resource('adver', 'AdverController')->middleware('verified');

Route::resource('currentUser', 'currentUserController')->middleware('verified');

Route::resource('editUser', 'editUserController')->middleware('verified');
