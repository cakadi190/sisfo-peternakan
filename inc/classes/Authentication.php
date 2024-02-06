<?php

namespace inc\classes;

use mysqli;

/**
 * Authentication class with login, status, and logout user
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @package siperpus-simple
 */
class Authentication
{
  /**
   * The DB connection
   * @var \mysqli $db The db connection
   */
  protected static $db;

  /**
   * The Database initialization
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   */
  public function __construct($connection)
  {
    session_start();
    self::$db = $connection;
  }

  /**
   * Setting new cookie into cookie and table remember_token
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return void
   */
  public static function setRememberToken($email, $token)
  {
    $stmt = self::$db->prepare("UPDATE users SET remember_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();
    $stmt->close();

    // Set the remember token as a cookie
    self::setCookie("remember_token", $token, time() + (86400 * 30)); // Cookie expires in 30 days
  }

  /**
   * Getting user credentials
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return \mysql|null|string[] $user
   */
  public static function user()
  {
    $user = null;

    if (isset($_COOKIE['user_id']) or isset($_COOKIE['remember_token'])) {
      $token = $_COOKIE['remember_token'] ?? null;
      $id    = $_COOKIE['user_id'] ?? null;

      $stmt = self::$db->prepare("SELECT * FROM users WHERE id = ? OR remember_token = ?");
      $stmt->bind_param("ss", $id, $token);
      $stmt->execute();
      $result = $stmt->get_result();
      $user   = $result->fetch_assoc();
      $stmt->close();
    }

    return $user;
  }

  /**
   * Logout function
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return void
   */
  public static function logout()
  {
    self::deleteCookie('remember_token');
    self::deleteCookie('user_id');
    session_destroy();
  }

  /**
   * Authentication Check
   * 
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return boolean
   */
  public static function check()
  {
    return self::user() ? true : false;
  }

  /**
   * Authentication action
   * 
   * @return array[]
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return boolean
   */
  public static function attempt($credentials, $remember = false)
  {
    $stmt = self::$db->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $credentials['email']);
    $stmt->execute();
    $stmt->bind_result($id, $email, $password);
    $stmt->fetch();
    $stmt->close();

    if (!is_null($password) && password_verify($credentials['password'], $password)) {
      if ($remember) {
        $token = bin2hex(random_bytes(64));
        self::setRememberToken($email, $token);
      }

      self::setCookie('user_id', $id, time() + 3600);
      return true;
    } else {
      return false;
    }
  }

  /**
   * Get ID from authed user
   * 
   * @return string Returned string of ID user.
   */
  public static function id()
  {
    return self::check() ? self::user()['id'] : null;
  }

  private static function setCookie($name, $value, $expiration)
  {
    setcookie($name, $value, $expiration, "/");
  }

  private static function deleteCookie($name)
  {
    setcookie($name, "", time() - 3600, "/");
  }
}
