<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Anggota
    Route::post('anggota/media', 'AnggotaApiController@storeMedia')->name('anggota.storeMedia');
    Route::apiResource('anggota', 'AnggotaApiController');

    // Article
    Route::apiResource('articles', 'ArticleApiController');

    // Event
    Route::apiResource('events', 'EventApiController');

    // Event Registration
    Route::apiResource('event-registrations', 'EventRegistrationApiController');

    // Event Field
    Route::apiResource('event-fields', 'EventFieldApiController');

    // Event Field Response
    Route::apiResource('event-field-responses', 'EventFieldResponseApiController');

    // Upcoming Proker
    Route::apiResource('upcoming-prokers', 'UpcomingProkerApiController');

    // Event Field Choice
    Route::apiResource('event-field-choices', 'EventFieldChoiceApiController');
});
