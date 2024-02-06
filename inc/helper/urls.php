<?php

namespace inc\helper;

use inc\classes\Url;

/**
 * URL Function Helper.
 * That contains any helper function to handling URL manipulation.
 */

if (!function_exists('base_url')) {
  /**
   * Base URL function
   * 
   * @param $url string|null The URL to be appended with the base url. If null, will return only the base url
   * @return string the full url
   */
  function base_url(string $url)
  {
    $url = ltrim($url, '/');
    $baseUrl = getenv('BASE_URL');
    return $baseUrl . $url;
  }
}

if (!function_exists('url')) {
  /**
   * Base URL function getter
   * 
   * @param $url string|null The URL to be appended with the base url. If null, will return only the base url
   * @return string the full url
   */
  function url(string $url)
  {
    $url = ltrim($url, '/');
    $baseUrl = getenv('BASE_URL');
    return $baseUrl . $url;
  }
}

if (!function_exists('asset')) {
  /**
   * Base URL function
   * 
   * @param $url string|null The URL to be appended with the base url. If null, will return only the base url
   * @return string the full url
   */
  function asset(string $url)
  {
    return url("assets/{$url}");
  }
}

if (!function_exists('redirect')) {
  /**
   * Redirect function
   * 
   * @param string|null $url The URL to redirect to. If null, use the default base URL.
   * @param int $status The HTTP response status code (optional, defaults to 302)
   * @return Url
   */
  function redirect(?string $url = null, ?int $status = 301)
  {
    return Url::redirect($url, $status); exit();
  }
}
