<?php

namespace inc\classes;

use mysqli;

use function inc\helper\dd;

/**
 * The class for database connection initialization
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @package siperpus-simple
 */
class Database
{
  /**
   * Connection result
   * @var \mysqli|null $connection The connection result
   */
  protected static $connection;

  /**
   * Preparing DB Connection
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public function __construct($hostname, $username, $password, $database, $port = 3306)
  {
    self::$connection = new mysqli($hostname, $username, $password, $database, $port)
      or die("Sorry, the database cannot connect seamlessly.");
  }

  /**
   * Getting current connection
   * 
   * @return \mysqli $connection
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public static function getConnection()
  {
    return self::$connection;
  }

  public function __destruct()
  {
    if (self::$connection) {
      self::$connection->close();
    }
  }

  /**
   * The insertion query
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param string $table The table name to insert data
   * @param string[] $data the data with key column to insert it
   */
  public static function insert($table, $data)
  {
    $columns      = '`' . implode('`, `', array_keys($data)) . '`';
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $values       = array_values($data);

    $stmt = self::$connection->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    $stmt->bind_param(str_repeat("s", count($values)), ...$values);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      throw new \Exception("Error inserting data: " . $stmt->error);
    }
  }

  /**
   * The update query
   *
   * @author Cak Adi <cakadi190@gmail.com>
   * @since 1.0.0
   * @version 1.0.0
   * @param string $table The table name to update data
   * @param string[] $data The data with key column to update
   * @param string $condition The condition for the update query
   */
  public static function update($table, $data, $condition)
  {
    $setClause = "";
    foreach ($data as $column => $value) {
      $setClause .= "`$column` = ?, ";
    }
    $setClause = rtrim($setClause, ", ");

    // dd("UPDATE `$table` SET $setClause WHERE $condition");

    $stmt = self::$connection->prepare("UPDATE `$table` SET $setClause WHERE $condition");

    $types = str_repeat("s", count($data));
    $values = array_values($data);
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return "Error updating data: " . $stmt->error;
    }
  }

  /**
   * Check if a record exists in the specified table based on given conditions
   *
   * @param string $table The table name to check for existence
   * @param array $conditions The conditions to check for existence
   * @return bool True if the record exists, false otherwise
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public static function exists($table, $conditions)
  {
    $whereClause = "";
    foreach ($conditions as $column => $value) {
      $whereClause .= "`$column` = ? AND ";
    }
    $whereClause = rtrim($whereClause, "AND ");

    $stmt = self::$connection->prepare("SELECT COUNT(*) FROM $table WHERE $whereClause");
    if (!$stmt) {
      throw new \Exception("Error preparing exists query: " . self::$connection->error);
    }

    $types = str_repeat("s", count($conditions));
    $values = array_values($conditions);
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
      $stmt->bind_result($count);
      $stmt->fetch();
      $stmt->close();
      return $count > 0;
    } else {
      $stmt->close();
      throw new \Exception("Error checking existence: " . self::$connection->error);
    }
  }

  /**
   * The selection query
   *
   * @param string $table The table name to select data from
   * @param array $columns The columns to be selected
   * @param array $conditions The conditions for the select query
   * @return array|null The selected data or null if an error occurs
   * @since 1.1.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public static function select($table, $columns = ['*'], $conditions = [])
  {
    $columnsList = implode(', ', $columns);

    $whereClause = "";
    foreach ($conditions as $column => $value) {
      $whereClause .= "`$column` = ? AND ";
    }
    $whereClause = rtrim($whereClause, "AND ");

    $stmt = self::$connection->prepare("SELECT $columnsList FROM $table WHERE $whereClause");
    if (!$stmt) {
      throw new \Exception("Error preparing select query: " . self::$connection->error);
    }

    $types = str_repeat("s", count($conditions));
    $values = array_values($conditions);
    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      return $data;
    } else {
      $stmt->close();
      throw new \Exception("Error executing select query: " . self::$connection->error);
    }
  }
}
