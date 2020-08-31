<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => '/admin',
    'namespace' => '\OrmBackend\Admin\Controllers',
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
    
    Route::group([
        'prefix' => '/user/{model}'
    ], function () {
        Route::get('/', 'AdminController@search')
            ->name('admin.user.search')
            ->defaults('group', 'user')
            ->middleware('can:read,model');
        
        Route::post('/', 'AdminController@store')
            ->name('admin.user.store')
            ->defaults('group', 'user')
            ->middleware('can:create,model');
        
        Route::get('/create', 'AdminController@create')
            ->name('admin.user.create')
            ->defaults('group', 'user')
            ->middleware('can:create,model');
        
        Route::get('/edit/{id}', 'AdminController@edit')
            ->name('admin.user.edit')
            ->defaults('group', 'user')
            ->middleware('can:update,model');
        
        Route::get('/details/{id}', 'AdminController@details')
            ->name('admin.user.details')
            ->defaults('group', 'user')
            ->middleware('can:read,model');
        
        Route::post('/update/{id}', 'AdminController@update')
            ->name('admin.user.update')
            ->defaults('group', 'user')
            ->middleware('can:update,model');
        
        Route::get('/delete/{id}', 'AdminController@delete')
            ->name('admin.user.delete')
            ->defaults('group', 'user')
            ->middleware('can:delete,model');
        
        Route::post('/batch-delete', 'AdminController@batchDelete')
            ->name('admin.user.batchDelete')
            ->defaults('group', 'user')
            ->middleware('can:delete,model');
        
        Route::get('/trash', 'AdminController@trash')
            ->name('admin.user.trash')
            ->defaults('group', 'user')
            ->middleware('can:restore,model');
        
        Route::get('/trash/restore/{id}', 'AdminController@restore')
            ->name('admin.user.restore')
            ->defaults('group', 'user')
            ->middleware('can:restore,model');
        
        Route::post('/trash/batch-restore', 'AdminController@batchRestore')
            ->name('admin.user.batchRestore')
            ->defaults('group', 'user')
            ->middleware('can:restore,model');
        
        Route::get('/settings', 'SettingsController@settings')
            ->name('admin.user.settings')
            ->defaults('group', 'user')
            ->middleware('can:settings');
        
        Route::post('/settings/permissions', 'SettingsController@updatePermissions')
            ->name('admin.user.settings.permissions.update')
            ->defaults('group', 'user')
            ->middleware('can:settings');
    });
    
    Route::group([
        'prefix' => '/file/{model}'
    ], function () {
        Route::get('/', 'AdminController@search')
            ->name('admin.file.search')
            ->defaults('group', 'file')
            ->middleware('can:read,model');
        
        Route::post('/', 'AdminController@store')
            ->name('admin.file.store')
            ->defaults('group', 'file')
            ->middleware('can:create,model');
        
        Route::get('/create', 'AdminController@create')
            ->name('admin.file.create')
            ->defaults('group', 'file')
            ->middleware('can:create,model');
        
        Route::get('/edit/{id}', 'AdminController@edit')
            ->name('admin.file.edit')
            ->defaults('group', 'file')
            ->middleware('can:update,model');
        
        Route::get('/details/{id}', 'AdminController@details')
            ->name('admin.file.details')
            ->defaults('group', 'file')
            ->middleware('can:read,model');
        
        Route::post('/update/{id}', 'AdminController@update')
            ->name('admin.file.update')
            ->defaults('group', 'file')
            ->middleware('can:update,model');
        
        Route::get('/delete/{id}', 'AdminController@delete')
            ->name('admin.file.delete')
            ->defaults('group', 'file')
            ->middleware('can:delete,model');
        
        Route::post('/batch-delete', 'AdminController@batchDelete')
            ->name('admin.file.batchDelete')
            ->defaults('group', 'file')
            ->middleware('can:delete,model');
        
        Route::get('/trash', 'AdminController@trash')
            ->name('admin.file.trash')
            ->defaults('group', 'file')
            ->middleware('can:restore,model');
        
        Route::get('/trash/restore/{id}', 'AdminController@restore')
            ->name('admin.file.restore')
            ->defaults('group', 'file')
            ->middleware('can:restore,model');
        
        Route::post('/trash/batch-restore', 'AdminController@batchRestore')
            ->name('admin.file.batchRestore')
            ->defaults('group', 'file')
            ->middleware('can:restore,model');
        
        Route::get('/settings', 'SettingsController@settings')
            ->name('admin.file.settings')
            ->defaults('group', 'file')
            ->middleware('can:settings');
        
        Route::post('/settings/permissions', 'SettingsController@updatePermissions')
            ->name('admin.file.settings.permissions.update')
            ->defaults('group', 'file')
            ->middleware('can:settings');
    });
});
