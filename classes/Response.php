<?php
namespace App;

class Response {
  /**
   * Menampilkan view
   *
   * @param string $view
   * @param array $data
   * @return void
   */
  public static function view(string $view, array $data = []) {
    extract($data);
    App::render($view, $data);
  }

  /**
   * Render json
   *
   * @param array $data
   * @return void
   */
  public static function json(array $data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  /**
   * Redirect ke halaman lain
   *
   * @param string $path
   * @return void
   */
  public static function redirect(string $path) {
    header("Location: $path");
    // stop script
    exit;
  }

  /**
   * Download file
   *
   * @param string|null $pathToFile
   * @return void
   */
  public static function download(? string $pathToFile) {
    if (! \is_file($pathToFile)) {
      throw new \Exception("File tidak ditemukan");
    }
    $filename = basename($pathToFile);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Length: " . filesize($pathToFile));
    readfile($pathToFile);
    exit;
  }
}