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
        'can:dashboard'
    ]
), function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    
    Route::group(array(
        'prefix' => 'datatable'
    ), function () {
        Route::get('/{name}', 'DatatableController@search')->name('admin.datatable.search')->middleware('can:read,name');
        Route::post('/{name}', 'DatatableController@datatable')->name('admin.datatable.datatable')->middleware('can:read,name');
        Route::get('/{name}/metadata', 'DatatableController@metadata')->name('admin.datatable.metadata')->middleware('can:read,name');
    });
    
    Route::group(array(
        'prefix' => 'entities'
    ), function () {
        Route::get('/{name}', 'AdminController@search')->name('admin.entity.search')->middleware('can:read,name');
        Route::post('/{name}', 'AdminController@store')->name('admin.entity.store')->middleware('can:create,name');
        Route::get('/{name}/create', 'AdminController@create')->name('admin.entity.create')->middleware('can:create,name');
        Route::get('/{name}/edit/{id}', 'AdminController@edit')->name('admin.entity.edit')->middleware('can:update,name');
        Route::get('/{name}/details/{id}', 'AdminController@details')->name('admin.entity.details')->middleware('can:read,name');
        Route::post('/{name}/update/{id}', 'AdminController@update')->name('admin.entity.update')->middleware('can:update,name');
        Route::get('/{name}/delete/{id}', 'AdminController@delete')->name('admin.entity.delete')->middleware('can:delete,name');
        Route::post('/{name}/batch-delete', 'AdminController@batchDelete')->name('admin.entity.batchDelete')->middleware('can:delete,name');
    });
    
    Route::group(array(
        'prefix' => 'trash'
    ), function () {
        Route::get('/{name}', 'AdminController@trash')->name('admin.entity.trash')->middleware('can:restore,name');
        Route::get('/{name}/restore/{id}', 'AdminController@restore')->name('admin.entity.restore')->middleware('can:restore,name');
        Route::post('/{name}/batch-restore', 'AdminController@batchRestore')->name('admin.entity.batchRestore')->middleware('can:restore,name');
    });
    
});
