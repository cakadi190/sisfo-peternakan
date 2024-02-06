<?php

use inc\classes\Request;
use inc\classes\Sanitize;

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\random_color;
use function inc\helper\redirect;

require_once __DIR__ . '/../../../../inc/loader.php';

// The middleware
if (!auth()->check()) {
  redirect('/dashboard');
}

/**
 * Checks if the retrieval date is less than today's date
 * If yes, redirects back with an error message
 *
 * @return void
 */
function checkIfLessThanToday()
{
  $retrievalDate = Request::post('entrance_date');
  $today = date('Y-m-d H:i:s');

  if ($retrievalDate < $today) {
    handleErrorRedirect("Tanggal masuk hewan ternak tidak boleh kurang dari hari ini.");
  }
}

if (Request::isMethod('post')) {
  $id = Sanitize::sanitizeInput($_GET['id']);
  $input = Request::only(
    'name',
    'category',
    'entrance_date',
    'status',
    'farm_shed',
    'pic',
  );

  $farmCategory = array_merge($input, [
    'id' => uniqid(),
    'updated_at' => date('Y-m-d H:i:s'),
  ]);

  checkIfLessThanToday();

  try {
    $db->update('farms', $farmCategory, "`id` = '{$id}'");
    $_SESSION['success'] = "Berhasil mengubah data ke dalam database!";
    redirect('/dashboard/farm');
  } catch (\Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    redirect()->back();
  }
} else {
  redirect()->back();
}

/**
 * Redirects to the dashboard with a success message
 *
 * @param string $message The success message to be displayed
 *
 * @return void
 */
function handleSuccessRedirect($message)
{
  $_SESSION['success'] = $message;
  redirect('/dashboard/medicine-usage');
  exit();
}

/**
 * Redirects back with an error message
 *
 * @param string $errorMessage The error message to be displayed
 *
 * @return void
 */
function handleErrorRedirect($errorMessage)
{
  $_SESSION['error'] = $errorMessage;
  redirect()->back();
  exit();
}
