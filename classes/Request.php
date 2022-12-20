<?php
namespace App;

class Request {
  /**
   * Mengambil input dari user melalui $_REQUEST (GET, POST, PUT, DELETE)
   *
   * @param string $key
   * @return void
   */
  public static function input(string $key) {
    if (isset($_REQUEST[$key])) {
      return $_REQUEST[$key];
    }
    return null;
  }

  /**
   * Mengambil semua input dari user melalui $_REQUEST (GET, POST, PUT, DELETE)
   *
   * @return void
   */
  public static function all() {
    return $_REQUEST;
  }

  /**
   * Mengambil file dari user melalui $_FILES
   *
   * @param string $key
   * @return void
   */
  public static function file(string $key) {
    if (isset($_FILES[$key])) {
      return $_FILES[$key];
    }
    return null;
  }

  /**
   * Menentukan apakah request method adalah GET atau POST atau PUT atau DELETE
   *
   * @return void
   */
  public static function method() {
    return $_SERVER['REQUEST_METHOD'];
  }
}