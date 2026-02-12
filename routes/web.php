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
Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/dashboard', function () {
        return view('layouts.layout');
    });

//tools registration supervisor
Route::get('/tools-registration', 'ToolsRegistrationController@index')->name('tools-registration.index');

//document Registration
Route::get('/document-registration', 'DocumentController@index')->name('document-registration.index');
Route::post('/document-registration/store', 'DocumentController@store')->name('document.registration.store');
Route::get('/api/documents/submenus', 'DocumentController@getSubMenus')->name('documents.submenus');
Route::get('/api/documents/tools/{subMenu}',  'DocumentController@getToolsBySubMenu')->name('documents.tools');
Route::post('/documents/store', 'DocumentController@store')->name('documents.store');
    Route::get('/api/documents/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::delete('/documents/{id}', 'DocumentController@destroy')->name('documents.destroy');

    //update document edit
Route::post('/document/update','DocumentController@update')->name('document.update');    

//get data type document sub menu
Route::get('/get-document-types/{subMenu}','DocumentController@getDocumentTypes')->name('get-document-types');    

//get data room
Route::get('/get-rooms', 'ToolsRegistrationController@getRooms')->name('get-room');
//get data document tools untuk list document pada modal
Route::get('/document-tools/{id}/{subMenu}', 'DocumentController@getDocumentTools')->name('document-tools.tools');

//masterlist document
Route::get('/masterlist-documents', 'DocumentController@MasterlistDocuments')->name('masterlist-documents.index');
//detail documenttools
Route::get('masterlist-documents/detail-document/{id}', 'DocumentController@DetailDocument')->name('detail-document.detail');

//report by tools
Route::get('/report-by-tools', 'DocumentController@reportBytools')->name('report-by-tools.tools');
//report by Document
Route::get('/report-by-document', 'DocumentController@reportBydoc')->name('report-by-tools.doc');

//report equipment document 
Route::get('/documents/report/equipment/', 'DocumentController@reportDocument')->name('documents.report');
Route::get('/documents/export/excel', 'DocumentController@exportExcel')->name('documents.exportExcel');

// view document
Route::get('/documents/view/{id}','DocumentController@viewDocument')->name('documents.view');
Route::get('/documents/download/{id}', 'DocumentController@downloadDocument')->name('documents.download');

//view document history
Route::get('/documents/history/{id}', 'HistoryController@show')->name('documents.history');



Route::get('/home', 'HomeController@index')->name('home');
// Show halaman per sub-menu
    Route::get('/tools-registration/{subMenu}', 'ToolsRegistrationController@show')->name('tools.show');
// chect tools from calibration tools
Route::get('/api/equipment/check-id', 'ToolsRegistrationController@checkEquipmentId')->name('check.equipment.id');
// get products by active substance
Route::get('/api/products-by-active-substance', 'ToolsRegistrationController@getProductsByActiveSubstance')->name('products.by.active.substance');

    // Store - Equipment
    Route::post('/tools-registration/equipment/store', 'ToolsRegistrationController@storeEquipment')->name('tools.store.equipment');
    Route::put('/tools-registration/equipment/{id}', 'ToolsRegistrationController@updateEquipment')->name('tools.update.equipment');
    // Store - Mediafill
    Route::post('/tools-registration/mediafill/store', 'ToolsRegistrationController@storeMediafill')->name('tools.store.mediafill');
    // Delete
    Route::delete('/tools-registration/delete/{id}', 'ToolsRegistrationController@destroy')->name('tools.destroy');

    //utility masterlist
    Route::get('/utility-masterlist', 'UtilityMasterlistController@index')->name('utility.masterlist.index');
    Route::post('/utility-masterlist/store', 'UtilityMasterlistController@store')->name('utility.masterlist.store');
    Route::put('/utility-masterlist/{id}', 'UtilityMasterlistController@update')->name('utility.masterlist.update');
    Route::delete('/utility-masterlist/{id}', 'UtilityMasterlistController@destroy')->name('utility.masterlist.destroy');

    Route::get('/utility/document/{id}', 'UtilityMasterlistController@showDocument')->name('utility.document');
});


Auth::routes();

Route::get('/', function () {
    return view('Auth.login');
});


Route::get('/qa-qualification/create', 'QualificationController@create')->name('kelola-alat');
Route::post('/qa-qualification/store', 'QualificationController@store')->name('store-qualification');
Route::get('/qa-qualification/show', function () {
    return view('masterdata.show');
});

//scedule due Dates
Route::get('/documents/scedule','DocumentController@schedule')->name('documents.schedule');
//report due date schedule
Route::get('/documents/duedate-report','DocumentController@duedateReport')->name('documents.duedate-report');

//user management
Route::get('/user-management', 'UserManagementController@index')->name('user-management.index');
//setting profile
Route::get('/profile', 'UserController@editProfile')->name('profile.edit');
Route::post('/profile/updatepassword', 'UserController@updatePassword')->name('profile.updatepassword');
Route::post('/profile/updatephoto', 'UserController@updatePhoto')->name('profile.updatephoto');

// admin managemant user
        Route::get('/usersmanagement', 'UserController@index')->name('users.index');
        Route::post('/users', 'UserController@store')->name('users.store');
        Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');
        //delete data all   
        Route::get('/data-all/delete', 'CalibrationParameterController@getdeletedata')->name('calibration.deleteAll');
        // Route for the equipment deleted permanently
        Route::delete('/QA/CalibrasiEquipment/forcedestroyequipment/{id}', 'CalibrationParameterController@forcedestroyequipment')->name('forcedestroy.equipment');
        //route restore deleted data equipment
        Route::post('/QA/CalibrasiEquipment/restoreDeletedEquipment/{id}', 'CalibrationParameterController@restoreDeletedEquipment')->name('restore.deleted.equipment');
        // Route for restore the deleted data
        Route::post('/QA/CalibrasiParameter/restoreDeletedCalibration/{id}', 'CalibrationParameterController@restoreDeletedCalibration')->name('restore.deleted.calibration');
        // Route for permanently delete the data
        Route::delete('/QA/CalibrasiParameter/forcedestroycalibration/{id}', 'CalibrationParameterController@forcedestroycalibration')->name('forcedestroy.calibration');
        //restore deleted history calibration
        Route::post('/QA/HistoryCalibration/restoreDeletedHistory/{id}', 'CalibrationParameterController@restoreDeletedHistory')->name('restore.deleted.history');
        // Route for permanently delete the history calibration
        Route::delete('/QA/HistoryCalibration/forcedestroyhistory/{id}', 'CalibrationParameterController@forcedestroyhistory')->name('forcedestroy.history');

// Audit Trail
Route::get('/audit-trail', 'AuditTrailsController@index')->name('audit-trail.index');
Route::get('/api/audit-trail/data', 'AuditTrailsController@getData')->name('audit-trail.data');

// admin page
//add PIC
Route::get('/admin/list-pic', 'AdminController@listPIC')->name('admin.list-pic');
Route::get('/admin/add-pic', 'AdminController@addPIC')->name('admin.add-pic');
Route::post('/admin/store-pic', 'AdminController@storePIC')->name('pic.store');

//delete PIC
Route::delete('/admin/delete-pic/{id}', 'AdminController@deletePIC')->name('pic.delete');


