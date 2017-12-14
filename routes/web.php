<?php
Route::get('/fetch', 'ImapController@execute');
Route::get('/move-back', 'ImapController@moveBackFromProcessed');
