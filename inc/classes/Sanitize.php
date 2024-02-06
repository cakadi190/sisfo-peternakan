<?php

namespace inc\classes;

/**
 * XSS Protection Class
 * 
 * @since 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @version 1.0.0
 */
class Sanitize
{
  /**
   * Sanitize user input to prevent XSS attacks.
   *
   * @param mixed $input The user input to sanitize.
   * @return mixed The sanitized user input.
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @version 1.0.0
   */
  public static function sanitizeInput($input)
  {
    if (is_array($input)) {
      return array_map(array('self', 'sanitizeInput'), $input);
    }

    $sanitizedInput = strip_tags($input ?? '');
    $sanitizedInput = htmlspecialchars($sanitizedInput, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return $sanitizedInput;
  }

  /**
   * Validate user input to prevent XSS attacks and other security vulnerabilities.
   *
   * @param mixed $input The user input to validate.
   * @return mixed The validated user input.
   * @since 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @version 1.0.0
   */
  public static function validateInput($input)
  {
    if (is_array($input)) {
      foreach ($input as $key => $value) {
        $input[$key] = self::validateInput($value);
      }

      return $input;
    }

    $validatedInput = trim($input);
    $validatedInput = str_replace(chr(0), '', $validatedInput);

    return $validatedInput;
  }
}