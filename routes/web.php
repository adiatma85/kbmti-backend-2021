<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Anggota
    Route::delete('anggota/destroy', 'AnggotaController@massDestroy')->name('anggota.massDestroy');
    Route::post('anggota/media', 'AnggotaController@storeMedia')->name('anggota.storeMedia');
    Route::post('anggota/ckmedia', 'AnggotaController@storeCKEditorImages')->name('anggota.storeCKEditorImages');
    Route::resource('anggota', 'AnggotaController');

    // Article
    Route::delete('articles/destroy', 'ArticleController@massDestroy')->name('articles.massDestroy');
    Route::resource('articles', 'ArticleController');

    // Event
    Route::delete('events/destroy', 'EventController@massDestroy')->name('events.massDestroy');
    Route::resource('events', 'EventController');

    // Event Registration
    Route::get('event-registrations/pemberkasan/{itemPath}', 'EventRegistrationController@downloadPemberkasan')->name('event-registrations.downloadPemberkasan');
    Route::get('event-registrations/add-event-registration/{eventId}', 'EventRegistrationController@customCreate')->name('event-registrations.customCreate');
    Route::post('event-registrations/add-event-registration', 'EventRegistrationController@customStore')->name('event-registrations.customStore');
    Route::delete('event-registrations/destroy', 'EventRegistrationController@massDestroy')->name('event-registrations.massDestroy');
    Route::resource('event-registrations', 'EventRegistrationController');

    // Event Field
    Route::delete('event-fields/destroy', 'EventFieldController@massDestroy')->name('event-fields.massDestroy');
    Route::resource('event-fields', 'EventFieldController');

    // Event Field Response
    Route::delete('event-field-responses/destroy', 'EventFieldResponseController@massDestroy')->name('event-field-responses.massDestroy');
    Route::resource('event-field-responses', 'EventFieldResponseController');

    // Upcoming Proker
    Route::delete('upcoming-prokers/destroy', 'UpcomingProkerController@massDestroy')->name('upcoming-prokers.massDestroy');
    Route::resource('upcoming-prokers', 'UpcomingProkerController');

    // Event Field Choice
    Route::delete('event-field-choices/destroy', 'EventFieldChoiceController@massDestroy')->name('event-field-choices.massDestroy');
    Route::resource('event-field-choices', 'EventFieldChoiceController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
