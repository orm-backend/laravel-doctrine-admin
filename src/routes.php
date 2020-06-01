<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/admin',
    'namespace' => '\ItAces\Admin\Controllers',
    'middleware' => [
        'web',
        'auth',
        'verified',
        'can:dashboard',
        'menu'
    ]
], function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    
    Route::group([
        'prefix' => 'datatable'
    ], function () {
        Route::get('/{model}', 'DatatableController@search')->name('admin.datatable.search')->middleware('can:read,model');
        Route::post('/{model}', 'DatatableController@datatable')->name('admin.datatable.datatable')->middleware('can:read,model');
        Route::get('/{model}/metadata', 'DatatableController@metadata')->name('admin.datatable.metadata')->middleware('can:read,model');
    });

    Route::group([
        'prefix' => '/entity/{model}'
    ], function () {
        Route::get('/', 'AdminController@search')
            ->name('admin.entity.search')
            ->defaults('group', 'entity')
            ->middleware('can:read,model');
        
        Route::post('/', 'AdminController@store')
            ->name('admin.entity.store')
            ->defaults('group', 'entity')
            ->middleware('can:create,model');
        
        Route::get('/create', 'AdminController@create')
            ->name('admin.entity.create')
            ->defaults('group', 'entity')
            ->middleware('can:create,model');
        
        Route::get('/edit/{id}', 'AdminController@edit')
            ->name('admin.entity.edit')
            ->defaults('group', 'entity')
            ->middleware('can:update,model');
        
        Route::get('/details/{id}', 'AdminController@details')
            ->name('admin.entity.details')
            ->defaults('group', 'entity')
            ->middleware('can:read,model');
        
        Route::post('/update/{id}', 'AdminController@update')
            ->name('admin.entity.update')
            ->defaults('group', 'entity')
            ->middleware('can:update,model');
        
        Route::get('/delete/{id}', 'AdminController@delete')
            ->name('admin.entity.delete')
            ->defaults('group', 'entity')
            ->middleware('can:delete,model');
        
        Route::post('/batch-delete', 'AdminController@batchDelete')
            ->name('admin.entity.batchDelete')
            ->defaults('group', 'entity')
            ->middleware('can:delete,model');
        
        Route::get('/trash', 'AdminController@trash')
            ->name('admin.entity.trash')
            ->defaults('group', 'entity')
            ->middleware('can:restore,model');
        
        Route::get('/trash/restore/{id}', 'AdminController@restore')
            ->name('admin.entity.restore')
            ->defaults('group', 'entity')
            ->middleware('can:restore,model');
        
        Route::post('/trash/batch-restore', 'AdminController@batchRestore')
            ->name('admin.entity.batchRestore')
            ->defaults('group', 'entity')
            ->middleware('can:restore,model');
        
        Route::get('/settings', 'SettingsController@settings')
            ->name('admin.entity.settings')
            ->defaults('group', 'entity')
            ->middleware('can:settings');
        
        Route::post('/settings/permissions', 'SettingsController@updatePermissions')
            ->name('admin.entity.settings.permissions.update')
            ->defaults('group', 'entity')
            ->middleware('can:settings');
    });
});
