<?php

use Illuminate\Support\Facades\Route;

// Automatically load module routes
$moduleDir = base_path('modules');

$modules = glob($moduleDir . '/*', GLOB_ONLYDIR);

foreach ($modules as $module) {
    $moduleRoutesFile = $module . '/routes.php';

    if (file_exists($moduleRoutesFile)) {
        require $moduleRoutesFile;
    }
}

Route::view('/', 'welcome')
    ->name('home');
