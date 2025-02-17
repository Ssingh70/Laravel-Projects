<?php

use App\Http\Controllers\ContactController;

Route::resource('contacts', ContactController::class);
Route::post('contacts/import', [ContactController::class, 'import'])->name('contacts.import');
