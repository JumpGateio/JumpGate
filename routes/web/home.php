<?php

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'home'], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [
                'as'         => 'home',
                'uses'       => 'HomeController@index',
                'middleware' => 'active:home',
            ]);
        });
    });
});
