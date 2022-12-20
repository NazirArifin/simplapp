<?php
namespace App;

class DB {
  private static PDO $instance;

  public static function changeDriver(string $driver): void {
    if (empty(self::$instance)) {
      DbConnection::setDriver($driver);
    } else {
      throw new Exception('Driver tidak bisa diubah setelah instance dibuat');
    }
  }

  // method untuk menjalankan query
  private static function execute($query, $params = []) {
    if (empty(self::$instance)) {
      self::$instance = DbConnection::getInstance();
    }

    $stmt = self::$instance->prepare($query);
    $stmt->execute($params);
    return $stmt;
  }

  // method untuk menjalankan query select
  public static function select($query, $params = []) {
    // validasi select query
    if (!preg_match('/^SELECT/i', $query)) {
      throw new Exception('Query harus SELECT');
    }

    $stmt = self::execute($query, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // method untuk menjalankan query insert
  public static function insert($query, $params = []) {
    // validasi insert query
    if (!preg_match('/^INSERT/i', $query)) {
      throw new Exception('Query harus INSERT');
    }

    $stmt = self::execute($query, $params);
    return self::$instance->lastInsertId();
  }

  // method untuk menjalankan query update
  public static function update($query, $params = []) {
    // validasi update query
    if (!preg_match('/^UPDATE/i', $query)) {
      throw new Exception('Query harus UPDATE');
    }

    $stmt = self::execute($query, $params);
    return $stmt->rowCount();
  }

  // method untuk menjalankan query delete
  public static function delete($query, $params = []) {
    // validasi delete query
    if (!preg_match('/^DELETE/i', $query)) {
      throw new Exception('Query harus DELETE');
    }

    $stmt = self::execute($query, $params);
    return $stmt->rowCount();
  }

  // method untuk menjalankan query lainnya
  public static function query($query, $params = []) {
    $stmt = self::execute($query, $params);
    return $stmt;
  }
}