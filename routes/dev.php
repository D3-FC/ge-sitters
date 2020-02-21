<?php


Route::get('/ping', function () {
    return 'pong';
});


Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/me/admin', function () {
        /** @var \App\User $user */
        $user = Auth::user();

        if ($user->is_admin) {
            return $user;
        }

        $user->becomeAdmin();

        return $user;


    });

});
