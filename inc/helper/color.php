<?php

namespace inc\helper;

/**
 * Determines if a given color is considered light based on its RGB values.
 *
 * @param string $color The color in hexadecimal format (e.g., "#ffffff").
 * @return string Returns the text color (either "#FFF" or "#000") based on the luminance of the color.
 */
function isLightColor($color)
{
  [$r, $g, $b] = sscanf($color, "#%02x%02x%02x");
  $luminance = ($r * 0.299 + $g * 0.587 + $b * 0.114) / 255;
  return $luminance < 0.75 ? "#FFF" : "#000";
}

/**
 * Generates a random RGB color.
 *
 * @return string A string representing a random RGB color in the format "rgb(red, green, blue)".
 */
function random_color()
{
  $randomInt = mt_rand(0x000000, 0xFFFFFF);
  return sprintf("#%06X", $randomInt);
}
