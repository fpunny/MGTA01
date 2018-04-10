<?php

DEFINE("_SERVER_", "localhost");
DEFINE("_USERNAME_", "root");
DEFINE("_PASSWORD_", "password");
DEFINE("_DATABASE_", "MGTA01");
header('Content-type: application/json');

class Database {

  private static $conn;

  public static function connect() {

    self::$conn = new mysqli(_SERVER_, _USERNAME_, _PASSWORD_, _DATABASE_);
    if (self::$conn === false) {
      self::json_err(400, "Connection Error: " . self::$conn->connection_error);
      return false;
    }
    return self::$conn;
  }

  public static function query($query) {
    return self::$conn->query($query);
  }

  public static function error() {
    return self::$conn->error;
  }

  public static function SQLtoObject($sql) {
    $obj = array();
    while ($row = $sql->fetch_assoc()) {
      $obj[] = $row;
    }
    $sql->close();
    self::$conn->next_result();
    return $obj;
  }

  public static function json_err($status, $msg) {
    http_response_code($status);
    $obj["error"] = $msg;
    echo json_encode($obj);
  }

  public static function json_res($msg) {
    http_response_code(200);
    $obj["data"] = $msg;
    echo json_encode($obj);
  }
}

class API {

  private static $db;
  private static $conn;

  public static function run() {
    self::$db = new Database();
    self::$conn = self::$db->connect();
    if (self::$conn) {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        self::GET();
      } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        self::POST();
      } else {
        self::$db->json_err(400, "Invalid method");
      }
    }
  }

  private function GET() {
    $sql = self::$db->query("SELECT def, word FROM questions");
    if ($sql) {
      self::$db->json_res(self::$db->SQLtoObject($sql));
    }
  }

  private function POST() {
    $file = file_get_contents('php://input');
    $obj = json_decode($file, true);
    if ($obj == null && json_last_error() !== JSON_ERROR_NONE) {
      self::$db->json_err(400, "Invalid JSON");
    } else {
      $query = "INSERT INTO questions(word, def) VALUES ('%s', '%s')";
      $sql = self::$db->query(sprintf($query, self::$conn->real_escape_string($obj['word']), self::$conn->real_escape_string($obj['def'])));
      if ($sql) {
        self::$db->json_res("Insert Successful");
      } else {
        self::$db->json_err(400, self::$db->error());
      }
    }
  }

}

API::run();

?>
