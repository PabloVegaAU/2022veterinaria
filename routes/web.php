<?php

Auth::routes();

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::get('/About', 'HomeController@about')->name('about');

Route::get('/Contact', 'HomeController@contact')->name('contact');

Route::resource('/Events', 'Evento\EventoController');
Route::resource('/Participants', 'Evento\LParticipantesController');
Route::resource('/Duels', 'Evento\DuelosController');

//USER CONTROLLER
Route::group(['middleware' => ['can:MyPets']], function () {
    Route::resource('/Mascotas', 'Usuario\MascotasController');
    Route::resource('/MFotos', 'Usuario\MFotosController');
    Route::resource('/MVideos', 'Usuario\MVideosController');
});

//ADMIN CONTROLLER
Route::group(['middleware' => ['can:Mantenimientos']], function () {
    Route::resource('/Usuarios', 'Administrador\UsersController');
    Route::resource('/MMascotas', 'Administrador\MascotasController');
});

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session(['locale' => $locale]);
    return redirect(url(URL::previous()));
})->name('language');
