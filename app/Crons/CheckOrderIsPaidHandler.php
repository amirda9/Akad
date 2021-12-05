#!/usr/bin/env php
<?php
define('LARAVEL_START', microtime(true));

require '../../vendor/autoload.php';

$app = require_once '../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')
    ->handle(Illuminate\Http\Request::capture());

$controller = new App\Http\Controllers\Panel\CronController();
$controller->checkOrderIsPaid();

exit(1);
