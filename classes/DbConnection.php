<?php
namespace App;

class DbConnection {
  // instance db dibuat private agar tidak bisa diakses dari luar class
  private static PDO $instance;
  
  // driver database
  private static string $driver = 'mysql';

  // config database berisi DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_PORT
  private static array $config = [];

  // constructor sengaja dibuat private agar tidak bisa diakses dari luar class
  private function __construct() {}

  // setter driver
  public static function setDriver(string $driver): void {
    // jika instance sudah dibuat, maka driver tidak bisa diubah
    if (! empty(self::$instance)) {
      throw new Exception('Driver tidak bisa diubah setelah instance dibuat');
    }

    // hanya bisa mengubah driver jika driver yang diubah berbeda dengan driver sebelumnya
    if (self::$driver !== $driver) {
      switch ($driver) {
        case 'mysql':
          self::$driver = 'mysql';
          break;
        case 'pgsql':
          self::$driver = 'pgsql';
          break;
        default:
          self::$driver = 'mysql';
          break;
      }
    }
  }

  // method untuk mengambil instance db
  public static function getInstance(): PDO {
    if (empty(self::$instance)) {
      // jika config database belum di set, maka set config database
      // yang ada di folder dbconfig/driver.ini
      if (empty(self::$config)) {
        self::$config = parse_ini_file('dbconfig/' . self::$driver . '.ini');
      }

      // jika instance belum dibuat, maka buat instance baru
      try {
        self::$instance = new PDO(
          self::$driver . ':host=' . self::$config['DB_HOST'] . ';dbname=' . self::$config['DB_NAME'] . ';port=' . self::$config['DB_PORT'],
          self::$config['DB_USER'],
          self::$config['DB_PASS']
        );
      } catch (PDOException $e) {
        throw new Exception('Koneksi Gagal: ' . $e->getMessage());
      }
    }

    // hanya jika instance sudah dibuat, maka kembalikan instance
    return self::$instance;
  } 
}