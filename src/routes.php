<?php
use Illuminate\Support\Facades\Route;

Route::group(array(
    'prefix' => 'admin',
    'namespace' => '\ItAces\Admin\Controllers',
    'middleware' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'auth',
        'verified',
        'can:dashboard-access'
    ]
), function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    
    Route::group(array(
        'prefix' => 'datatable'
    ), function () {
        Route::get('/{name}', 'DatatableController@search')->name('admin.datatable.search');
        Route::post('/{name}', 'DatatableController@datatable')->name('admin.datatable.datatable');
        Route::get('/{name}/metadata', 'DatatableController@metadata')->name('admin.datatable.metadata');
    });
    
    Route::group(array(
        'prefix' => 'entities'
    ), function () {
        Route::get('/{name}', 'AdminController@search')->name('admin.entity.search');
        Route::post('/{name}', 'AdminController@store')->name('admin.entity.store');
        Route::get('/{name}/create', 'AdminController@create')->name('admin.entity.create');
        Route::get('/{name}/edit/{id}', 'AdminController@edit')->name('admin.entity.edit');
        Route::get('/{name}/details/{id}', 'AdminController@details')->name('admin.entity.details');
        Route::post('/{name}/update/{id}', 'AdminController@update')->name('admin.entity.update');
        Route::get('/{name}/delete/{id}', 'AdminController@delete')->name('admin.entity.delete');
        Route::post('/{name}/batch-delete', 'AdminController@batchDelete')->name('admin.entity.batchDelete');
    });
    
    Route::group(array(
        'prefix' => 'trash'
    ), function () {
        Route::get('/{name}', 'AdminController@trash')->name('admin.entity.trash');
        Route::get('/{name}/restore/{id}', 'AdminController@restore')->name('admin.entity.restore');
        Route::post('/{name}/batch-restore', 'AdminController@batchRestore')->name('admin.entity.batchRestore');
    });
    
});
