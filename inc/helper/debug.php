<?php

namespace inc\helper;

/**
 * Debug Function Helpers.
 * That contains any helper function to handling debugging.
 */

if (!function_exists('dd')) {
  /**
   * Dump and die function for debugging.
   *
   * This function outputs the provided variables using var_dump and then terminates
   * script execution using exit().
   *
   * @param mixed ...$vars One or more variables to be dumped.
   * @return void
   */
  function dd(mixed ...$vars)
  {
    var_dump($vars);
    exit;
  }
}
