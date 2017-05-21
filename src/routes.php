<?php

Route::group(array('prefix' => 'panel', 'middleware' => ['web', 'can:access_panel']), function () {
    // main page for the admin section (app/views/admin/dashboard.blade.php)

    Route::get('/', function () {
        return View::make('panelViews::dashboard')->with('version', 'custom');
    });

/**
 * Check Permission only on Model Controllers
 */
    Route::group(array('middleware' => ['panel-permissions']), function () {
        Route::any('/{entity}/{methods}', array('uses' => 'Serverfireteam\Panel\MainController@entityUrl'));
        Route::post('/edit', array('uses' => 'Serverfireteam\Panel\ProfileController@postEdit'));
        Route::get('/edit', array('uses' => 'Serverfireteam\Panel\ProfileController@getEdit'));
    });


/**
 * Admin userPassword change
 */
    Route::get('/changePassword', array('uses' => 'Serverfireteam\Panel\RemindersController@getChangePassword'));

    Route::post('/changePassword', array('uses' => 'Serverfireteam\Panel\RemindersController@postChangePassword'));
});
