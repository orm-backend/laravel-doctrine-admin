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
        Route::get('/{model}', 'DatatableController@search')->name('admin.datatable.search')->middleware('can:read,model');
        Route::post('/{model}', 'DatatableController@datatable')->name('admin.datatable.datatable')->middleware('can:read,model');
        Route::get('/{model}/metadata', 'DatatableController@metadata')->name('admin.datatable.metadata')->middleware('can:read,model');
    });
    
    Route::group(array(
        'prefix' => 'entities'
    ), function () {
        Route::get('/{model}', 'AdminController@search')->name('admin.entity.search')->middleware('can:read,model');
        Route::post('/{model}', 'AdminController@store')->name('admin.entity.store')->middleware('can:create,model');
        Route::get('/{model}/create', 'AdminController@create')->name('admin.entity.create')->middleware('can:create,model');
        Route::get('/{model}/edit/{id}', 'AdminController@edit')->name('admin.entity.edit')->middleware('can:update,model');
        Route::get('/{model}/details/{id}', 'AdminController@details')->name('admin.entity.details')->middleware('can:read,model');
        Route::post('/{model}/update/{id}', 'AdminController@update')->name('admin.entity.update')->middleware('can:update,model');
        Route::get('/{model}/delete/{id}', 'AdminController@delete')->name('admin.entity.delete')->middleware('can:delete,model');
        Route::post('/{model}/batch-delete', 'AdminController@batchDelete')->name('admin.entity.batchDelete')->middleware('can:delete,model');
        Route::get('/{model}/trash', 'AdminController@trash')->name('admin.entity.trash')->middleware('can:restore,model');
    });
    
    Route::group(array(
        'prefix' => 'trash'
    ), function () {
        //Route::get('/{model}', 'AdminController@trash')->name('admin.entity.trash')->middleware('can:restore,model');
        Route::get('/{model}/restore/{id}', 'AdminController@restore')->name('admin.entity.restore')->middleware('can:restore,model');
        Route::post('/{model}/batch-restore', 'AdminController@batchRestore')->name('admin.entity.batchRestore')->middleware('can:restore,model');
    });
    
});
