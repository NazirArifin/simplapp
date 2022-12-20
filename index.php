<?php
require_once 'vendor/autoload.php';

use App\App;

$app = new App();

$app->get('/', function () {
  App::render('home');
});

$app->get('/mahasiswa/(in|out)/(\d+)', function ($status, $id) {
  var_dump($status);
});

try {
  $app->run();
} catch (\Exception $e) {
  echo $e->getMessage();
}