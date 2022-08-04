<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return 'admin';
// });

// Add new routes for admin login, forgot and reset password
Route::get('/','Adminauth\LoginController@showLoginForm');
Route::get('/login','Adminauth\LoginController@showLoginForm')->name('admin.login');
Route::post('/login','Adminauth\LoginController@adminLogin')->name('admin.login');
Route::get('/forgotpassword','Adminauth\ForgotPasswordController@showForgotPasswordForm')->name('admin.forgotpassword');
Route::post('/password/email','Adminauth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.eamil');
Route::get('/password/reset/{token}/{email}', 'Adminauth\ResetPasswordController@showResetPasswordForm')->name('admin.password.token');
Route::post('/password/reset', 'Adminauth\ResetPasswordController@reset')->name('admin.password.reset');

// Add new route for 'admin' middleware
Route::group(['middleware' => ['admin']],function(){

	// Logout routes
	//Route::get('/','admin\AdminController@index');
    Route::post('/logout','Adminauth\LoginController@logout');
	Route::get('/logout','Adminauth\LoginController@logout')->name('admin.logout');

	// Change password routes
	//Route::get('/changepass','admin\AdminController@getChangePass')->name('admin.changepass');
	Route::post('/changepass','admin\AdminController@changePass')->name('admin.updatechangepass');

	// Change Profile routes
	Route::get('/editprofile','admin\AdminController@profile')->name('admin.editprofile');
	Route::post('/updateprofile','admin\AdminController@postprofile')->name('admin.updateprofile');

	// Super Admin Module Routes
	Route::get('/dashboard','admin\AdminController@index')->name('admin.dashboard');

	// Category Module Routes
	Route::post('/category/list/data','admin\CategoryController@listdata')->name('admin.category.listdata');
	Route::resource('/category', 'admin\CategoryController', [
	    'names' => [
	        'index' => 'admin.category.list',
	        'edit' => 'admin.category.edit',
	        'create' => 'admin.category.create',
	        'store' => 'admin.category.store',
	        'update' => 'admin.category.update',
	        'destroy' => 'admin.category.destroy',
	    ]
	]);

	// Enquiry Module Routes
	Route::post('/enquiry/list/data','admin\EnquiryController@listdata')->name('admin.enquiry.listdata');
	Route::resource('/enquiry', 'admin\EnquiryController', [
	    'names' => [
	        'index' => 'admin.enquiry.list',
	        'edit' => 'admin.enquiry.edit',
	        'create' => 'admin.enquiry.create',
	        'store' => 'admin.enquiry.store',
	        'update' => 'admin.enquiry.update',
	        'destroy' => 'admin.enquiry.destroy',
	    ]
	]);

	// User Module Routes
	Route::get('/user/restore/{id?}','admin\UserController@userRestore')->name('admin.user.restore');
	Route::get('/user/get-account/{id}','admin\UserController@getAccountsByUserId')->name('admin.user.get-account');
	Route::post('/user/list/data/{status?}','admin\UserController@listdata')->name('admin.user.listdata');
	Route::resource('/user', 'admin\UserController', [
	    'names' => [
	        'index' => 'admin.user.list',
	        'create' => 'admin.user.create',
	        'store' => 'admin.user.store',
	        'edit' => 'admin.user.edit',
	        'update' => 'admin.user.update',
	        'destroy' => 'admin.user.destroy',
	        'show' => 'admin.user.show'
	    ]
	]);

	// Creator Module Routes
	Route::get('/creator/restore/{id?}','admin\CreatorController@creatorRestore')->name('admin.creator.restore');
	Route::post('/creator/list/data/{status?}','admin\CreatorController@listdata')->name('admin.creator.listdata');
	Route::resource('/creator', 'admin\CreatorController', [
	    'names' => [
	        'index' => 'admin.creator.list',
	        'create' => 'admin.creator.create',
	        'store' => 'admin.creator.store',
	        'edit' => 'admin.creator.edit',
	        'update' => 'admin.creator.update',
	        'destroy' => 'admin.creator.destroy',
	        'show' => 'admin.creator.show'
	    ]
	]);

	// Content Module Routes
	Route::get('/content/search','admin\ContentController@search')->name('admin.content.search');
	Route::resource('/content', 'admin\ContentController', [
	    'names' => [
	        'index' => 'admin.content.list',
	        'create' => 'admin.content.create',
	        'store' => 'admin.content.store',
	        'edit' => 'admin.content.edit',
	        'update' => 'admin.content.update',
	        'destroy' => 'admin.content.destroy',
	        'show' => 'admin.content.show'
	    ]
	]);
	Route::post('/content/img-upload','admin\ContentController@img_upload')->name('admin.content.upload');
	Route::post('/content/main-img-upload/{id}','admin\ContentController@mainImgUpload')->name('admin.content.mainupload');
	Route::post('/content/remove/img-upload','admin\ContentController@removeImage')->name('admin.content.remove.image');
	Route::post('/content/remove/step','admin\ContentController@removeStep')->name('admin.content.remove.step');
	Route::get('/content/pdf/{id}','ContentController@createPDF')->name('content.pdf.export');


	//Maintenance Module Routes
	Route::get('/maintenance/search','admin\MaintenanceController@search')->name('admin.maintenance.search');
	Route::resource('/maintenance/content', 'admin\MaintenanceController', [
	    'names' => [
	        'index' => 'admin.maintenance.list',
	        'create' => 'admin.maintenance.create',
	        'store' => 'admin.maintenance.store',
	        'edit' => 'admin.maintenance.edit',
	        'update' => 'admin.maintenance.update',
	        'destroy' => 'admin.maintenance.destroy',
	        'show' => 'admin.maintenance.show'
	    ]
	]);
	Route::post('/maintenance/img-upload','admin\MaintenanceController@img_upload')->name('admin.maintenance.upload');
	Route::post('/maintenance/main-img-upload/{id}','admin\MaintenanceController@mainImgUpload')->name('admin.maintenance.mainupload');
	Route::post('/maintenance/remove/img-upload','admin\MaintenanceController@removeImage')->name('admin.maintenance.remove.image');
	Route::post('/maintenance/remove/step','admin\MaintenanceController@removeStep')->name('admin.maintenance.remove.step');


	//Warranty Extension
	Route::post('/warranty-extension/list/data','admin\WarrantyExtensionController@listdata')->name('admin.warrantyextension.listdata');
	Route::post('/warranty-extension/img-upload/{id}','admin\WarrantyExtensionController@machineImgUpload')->name('admin.warrantyextension.imgupload');
	Route::get('/warranty-extension/history/{unique_key}','admin\WarrantyExtensionController@warrantyExtensionHistory')->name('admin.warrantyextension.history');
	Route::get('/warranty-extension/list/request','admin\WarrantyExtensionController@requestListData')->name('admin.warrantyextension.listreqest');
	Route::post('/warranty-extension/list/request-data','admin\WarrantyExtensionController@requestListData')->name('admin.warrantyextension.listreqest.data');
	Route::resource('/warranty-extension', 'admin\WarrantyExtensionController', [
	    'names' => [
	        'index' => 'admin.warrantyextension.list',
	        'edit' => 'admin.warrantyextension.edit',
	        'update' => 'admin.warrantyextension.update',
	        'show' => 'admin.warrantyextension.show'
	    ]
	]);


	// CMS Page Module Routes
	Route::post('/cms-page/list/data','admin\CmsPageController@listdata')->name('admin.cms.page.listdata');
	Route::resource('/cms-page', 'admin\CmsPageController', [
	    'names' => [
	        'index' => 'admin.cms.page.list',
	        'create'=>'admin.cms.page.create',
	        'store'=>'admin.cms.page.store',
	        'edit' => 'admin.cms.page.edit',
	        'update' => 'admin.cms.page.update',
	        'destroy' => 'admin.cms.page.destroy',
	        'show' => 'admin.cms.page.show'
	    ]
	]);
});

//ckeditor file upload
Route::post('ckeditor/upload', 'CkeditorController@upload')->name('ckeditor.upload');

//Clear Cache facade value:
Route::get('/reset-app', function() {
	Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return '<h1>Suucess</h1>';
});

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
