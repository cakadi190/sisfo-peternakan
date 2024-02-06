<?php

namespace inc\classes;

class Validator
{
  /**
   * Private variable to store validation bags
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @var array Contains validation error messages
   */
  private $errors = [];

  public function __construct()
  {
    session_destroy();
    session_start();
  }

  /**
   * Validates an email address.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param string $email The email address to validate
   * @return void
   */
  public function validateEmail($email)
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->errors[] = "Invalid email format";
    }
  }

  /**
   * Validates the minimum length of a value.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param string $value The value to validate
   * @param int $minLength The minimum length required
   * @return void
   */
  public function validateMinLength($value, $minLength)
  {
    if (strlen($value) < $minLength) {
      $this->errors[] = "Minimum length should be $minLength";
    }
  }

  /**
   * Validates the maximum length of a value.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param string $value The value to validate
   * @param int $maxLength The maximum length allowed
   * @return void
   */
  public function validateMaxLength($value, $maxLength)
  {
    if (strlen($value) > $maxLength) {
      $this->errors[] = "Maximum length exceeded ($maxLength)";
    }
  }

  /**
   * Validates if a value is required.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param mixed $value The value to validate
   * @return void
   */
  public function validateRequired($value)
  {
    if (empty($value)) {
      $this->errors[] = "This field is required";
    }
  }

  /**
   * Validates if a value is numeric.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @param mixed $value The value to validate
   * @return void
   */
  public function validateNumber($value)
  {
    if (!is_numeric($value)) {
      $this->errors[] = "Invalid number format";
    }
  }

  /**
   * Checks if all the validations pass.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return bool True if all validations pass, false otherwise
   */
  public function isValid()
  {
    return empty($this->errors);
  }

  /**
   * Returns the validation error messages.
   * 
   * @since 1.0.0
   * @version 1.0.0
   * @author Cak Adi <cakadi190@gmail.com>
   * @return array Validation error messages
   */
  public function getErrors()
  {
    return $this->errors;
  }
}