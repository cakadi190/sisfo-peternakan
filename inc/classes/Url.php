<?php

namespace inc\classes;

use function inc\helper\url;

/**
 * URL Helper class.
 * Contains helper functions for handling URL manipulation.
 */
class Url
{
  /**
   * Base URL function
   *
   * @param string $url The URL to be appended with the base url. If null, will return only the base url
   * @return string The full URL
   */
  public static function base_url(string $url)
  {
    $url = ltrim($url, '/');
    $baseUrl = getenv('BASE_URL');
    return $baseUrl . $url;
  }

  /**
   * URL function getter
   *
   * @param string $url The URL to be appended with the base url. If null, will return only the base url
   * @return string The full URL
   */
  public static function url(string $url)
  {
    $url = ltrim($url, '/');
    $baseUrl = getenv('BASE_URL');
    return $baseUrl . $url;
  }

  /**
   * Asset function
   *
   * @param string $url The URL to be appended with the base url. If null, will return only the base url
   * @return string The full URL
   */
  public static function asset(string $url)
  {
    return self::url("assets/{$url}");
  }

  /**
   * Redirect function
   *
   * @param string|null $url The URL to redirect to. If null, use the default base URL.
   * @param int $status The HTTP response status code (optional, defaults to 302)
   * @return Url Return an instance of the Url class for chaining
   */
  public static function redirect(?string $url = null, ?int $status = 301)
  {
    $target = self::base_url($url ?? '/');
    header("Location: {$target}", true, $status);
    return new self();
  }

  /**
   * Chainable method to go back to the previous URL
   * @return void
   */
  public static function back()
  {
    $url = $_SERVER['HTTP_REFERER'] ?? url('/');
    header("Location: {$url}");
  }
}
