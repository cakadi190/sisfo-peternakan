<?php

namespace inc\helper;

/**
 * Auth Function Helper.
 * That contains any helper function to handling authentication.
 */

if (!function_exists('auth')) {
  /**
   * Authentication function helper
   * 
   * @return \inc\classes\Authentication
   */
  function auth()
  {
    global $auth;
    return $auth;
  }
}

if (!function_exists('bcrypt')) {
  /**
   * Hash the given value using the bcrypt algorithm.
   * 
   * @param  string  $value
   * @param  array  $options
   * @return string
   */
  function bcrypt($value, $options = [])
  {
    return password_hash($value, PASSWORD_BCRYPT, ['cost' => $options['cost'] ?? 16]);
  }
}
