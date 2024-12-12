<?php

use Pecee\SimpleRouter\SimpleRouter;

//$disc = $_POST['disc'];

// ----- HOME -----
SimpleRouter::get('/', 'HomeController@index');

// ------- DISCS --------
SimpleRouter::get('/discs', 'DiscsController@showAllDiscs');
SimpleRouter::get('/discs/{fromUrl}', 'DiscsController@showOneDisc');


// -------- Add Discs ----------
SimpleRouter::get('/addisc', 'DiscsController@AdDisc');

// -------- Validate Discs ----------
SimpleRouter::get('/validatediscs', 'DiscsController@ValidateDiscs');

// -------- Store Approve Discs ----------
SimpleRouter::post('/storevalidateddiscs', 'DiscsController@StoreValidatedDiscs');

// -------- Add Plastic ----------
SimpleRouter::get('/addplastic', 'DiscsController@AddPlastic');

// -------- Store Discs ----------
SimpleRouter::post('/storeplastic', 'DiscsController@StorePlastic');

    // -------- Add Manufacturer ----------
SimpleRouter::get('/addmanufacturer', 'DiscsController@AddManufacturer');

// -------- Store Discs ----------
SimpleRouter::post('/store', 'DiscsController@StoreDiscs');

// -------- Store Discs ----------
SimpleRouter::post('/storemanufacturer', 'DiscsController@StoreManufacturer');

// -------- Edit Discs ----------
SimpleRouter::get('/editdisc/{fromUrl}', 'DiscsController@EditDisc');

// -------- Update Discs ----------
SimpleRouter::post('/updatedisc', 'DiscsController@UpdateDisc');

// -------- Delete Disc ----------
SimpleRouter::post('/deletedisc', 'DiscsController@DeleteDisc');

// -------- Delete Disc ----------
SimpleRouter::post('/predeletedisc', 'DiscsController@PreDeleteDisc');


// -------LOGIN----------
SimpleRouter::get('/login', 'LoginController@loginForm');
SimpleRouter::post('/logincheck', 'LoginController@loginCheck');

// -------LOGIN----------
SimpleRouter::get('/login2', 'LoginController@loginForm2');
SimpleRouter::post('/logincheck2', 'LoginController@loginCheck2');

// ---------LOGOUT----------
SimpleRouter::get('/logout', 'LoginController@logout');

// ---------CREATE USER ------------
SimpleRouter::get('/createuser', 'LoginController@createUser');

// ---------STORE USER ------------
SimpleRouter::post('/storeuser', 'LoginController@storeUser');


// ---------Settings ------------
SimpleRouter::get('/settings', 'SettingsController@Settings');

// ---------Store Settings ------------
SimpleRouter::post('/storesettings', 'SettingsController@StoreSettings');