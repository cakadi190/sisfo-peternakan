<?php

namespace inc\classes;

/**
 * XSS Protection Class
 * 
 * @since 1.0.0
 * @author Cak Adi <cakadi190@gmail.com>
 * @version 1.0.0
 */
class Input
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
      // Sanitize each element of the array recursively
      return array_map(array('self', 'sanitizeInput'), $input);
    }

    // Remove HTML tags and entities
    $sanitizedInput = strip_tags($input);

    // Convert special characters to HTML entities
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
      // Validate each element of the array recursively
      foreach ($input as $key => $value) {
        $input[$key] = self::validateInput($value);
      }

      return $input;
    }

    // Trim leading and trailing whitespaces
    $validatedInput = trim($input);

    // Prevent null byte poisoning
    $validatedInput = str_replace(chr(0), '', $validatedInput);

    return $validatedInput;
  }
}