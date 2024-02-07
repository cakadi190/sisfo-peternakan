<?php

namespace inc\helper;

/**
 * Change date into Indonesian Language with optional time
 * 
 * @param string $date The string of any date
 * @param bool $includeTime Whether to include time or not (default is false)
 * 
 * @return string The converted date and time in Indonesian language
 */
function indonesiaDate($date, $includeTime = false) {
  // Months in Indonesian
  $months = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
  );

  // Days in Indonesian
  $days = array(
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
  );

  // Parse the date string
  $timestamp = strtotime($date);

  // Get the day, month, and year
  $day = date('d', $timestamp);
  $month = date('n', $timestamp);
  $year = date('Y', $timestamp);

  // Convert the date into Indonesian format
  $indonesian_date = $days[date('l', $timestamp)] . ', ' . $day . ' ' . $months[$month] . ' ' . $year;

  // If including time, add it to the result
  if ($includeTime) {
    $time = date('H:i', $timestamp);
    $indonesian_date .= ' ' . $time . ' WIB'; // Assuming WIB as the timezone (Western Indonesian Time)
  }

  return $indonesian_date;
}