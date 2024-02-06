<?php

namespace inc\classes;

/**
 * Class Request
 *
 * Represents an HTTP request and provides static methods to access request data.
 *
 * @package inc\classes
 */
class Request
{
  /**
   * Get all the input data for the request.
   *
   * @return array The array containing all the request data.
   */
  public static function all()
  {
    return $_REQUEST;
  }

  /**
   * Get the request method (GET, POST, PUT, DELETE, etc.).
   *
   * @return string The request method.
   */
  public static function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Check if the request is an AJAX request.
   *
   * @return bool True if the request is AJAX, false otherwise.
   */
  public static function isAjax()
  {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  }

  /**
   * Check if the request method matches the given method.
   *
   * @param string $method The method to check against (e.g., GET, POST, PUT).
   * @return bool True if the request method matches, false otherwise.
   */
  public static function isMethod($method)
  {
    return strtoupper($method) === self::method();
  }

  /**
   * Get a specific value from the GET parameters.
   *
   * @param string $key The key to retrieve from the GET parameters.
   * @param mixed $default The default value if the key is not found.
   * @return mixed The value of the requested key or the default value.
   */
  public static function get($key, $default = null)
  {
    return Sanitize::sanitizeInput(isset($_GET[$key]) ? $_GET[$key] : $default);
  }

  /**
   * Get a specific value from the POST parameters.
   *
   * @param string $key The key to retrieve from the POST parameters.
   * @param mixed $default The default value if the key is not found.
   * @return mixed The value of the requested key or the default value.
   */
  public static function post($key, $default = null)
  {
    return Sanitize::sanitizeInput(isset($_POST[$key]) ? $_POST[$key] : $default);
  }

  /**
   * Get a specific value from the FILES parameters.
   *
   * @param string $key The key to retrieve from the FILES parameters.
   * @param mixed $default The default value if the key is not found.
   * @return mixed The value of the requested key or the default value.
   */
  public static function file($key, $default = null)
  {
    return isset($_FILES[$key]) ? $_FILES[$key] : $default;
  }

  /**
   * Get all the input data for the request except for specified keys.
   *
   * @param mixed $keys The keys to exclude from the request data.
   * @return array The array containing all the request data except for specified keys.
   */
  public static function except(mixed ...$keys)
  {
    $requestData = self::all();

    foreach ($keys as $key) {
      unset($requestData[$key]);
    }

    return $requestData;
  }

  /**
   * Get only the specified keys from the request data.
   *
   * @param array $keys The keys to include in the result.
   * @return array The array containing only the specified keys from the request data.
   */
  public static function only(mixed ...$keys)
  {
    $requestData = self::all();
    return array_intersect_key($requestData, array_flip($keys));
  }

  /**
   * Check if a key exists in the request data.
   *
   * @param string $key The key to check for existence.
   * @return bool True if the key exists, false otherwise.
   */
  public static function exists($key)
  {
    return array_key_exists($key, $_REQUEST);
  }


  /**
   * Move the uploaded file to a destination directory.
   *
   * @param string $key The key for the file in the FILES parameters.
   * @param string $destinationDir The destination directory for the uploaded file.
   * @param string $fileName The desired name for the uploaded file.
   * @return bool|string The path to the uploaded file or false on failure.
   */
  public static function moveUploadedFile($key, $destinationDir, $fileName)
  {
    if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
      $uploadPath = $destinationDir . $fileName;

      // Move uploaded file to the specified directory
      if (move_uploaded_file($_FILES[$key]['tmp_name'], $uploadPath)) {
        return $uploadPath;
      }
    }

    return false;
  }
}
