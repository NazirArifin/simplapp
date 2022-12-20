<?php
namespace App;

class App {
  private $routes = [];

  private function processUrl($url) {
    return $url = preg_replace('/\//', '\/', rtrim($url, '/'));
  }
  
  public function get($url, $callback) {
    // url adalah string dan kita ubah jadi regex
    $this->routes['GET'][$this->processUrl($url)] = $callback;
  }

  public function post($url, $callback) {
    $this->routes['POST'][$this->processUrl($url)] = $callback;
  }

  public function run() {
    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    $url = rtrim(explode('?', $url)[0], '/');
    // cari route yang sesuai dengan user_array_search
    foreach ($this->routes[$method] as $route => $callback) {
      if (preg_match("/^$route$/", $url)) {
        // jika string langsung panggil render
        if (is_string($callback)) {
          self::render($callback);
          return;
        }
        // callback kadang menerima parameter
        // contoh: /mahasiswa/(\d+)
        // maka kita perlu ambil parameter
        preg_match("/^$route$/", $url, $matches);
        // hapus index 0 karena itu adalah url yang sudah match
        unset($matches[0]);
        // panggil callback dengan parameter
        call_user_func_array($callback, $matches);
        return;
      }
    }
    self::render('404');
  }

  public static function render($view, $data = []) {
    extract($data);
    if (!file_exists("views/$view.php")) {
      throw new \Exception("View $view tidak ditemukan");
    }
    require_once "views/$view.php";
  }
}