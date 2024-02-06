<?php
/**
 * Medication Retrieval Form Handling
 *
 * This script handles the submission of a medication retrieval form, including file upload and stock verification.
 * It is intended to be included in a larger system.
 *
 * PHP version 7.0 and later
 *
 * @package   sisfo-bbib
 * @author    Amir Zuhdi Wibowo
 * @license   MIT License
 */

use inc\classes\Request;
use inc\classes\Sanitize;

use function inc\helper\auth;
use function inc\helper\dd;
use function inc\helper\redirect;

// Load necessary files and configurations
require_once __DIR__ . '/../../../../inc/loader.php';

// Check authentication status, redirect to dashboard if not authenticated
if (!auth()->check()) {
  redirect('/dashboard');
}

// Check if the form is submitted via POST method
if (Request::isMethod('post')) {
  handleFormSubmission($db);
} else {
  // If not submitted via POST, redirect back
  redirect()->back();
}

/**
 * Uploads the file and returns the generated filename
 *
 * @param array $file The uploaded file data
 *
 * @return string The generated filename after successful upload
 */
function uploadTheFile($file) {
  $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

  if (!in_array($file['type'], $allowedImageTypes)) {
    handleErrorRedirect("Berkas yang anda unggah tidak didukung. Mohon unggah berkas berjenis gambar.");
  }

  $fileName = uniqid();
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'txt';
  $fullFilename = "{$fileName}.{$extension}";

  $uploadPath = Request::moveUploadedFile('evidence', __DIR__ . '../../../../../uploads', "/{$fullFilename}");

  if (!$uploadPath) {
    handleErrorRedirect("Gagal mengunggah berkas.");
  }

  return $fullFilename;
} 

/**
 * Checks the available stock for the given medicine and usage quantity
 *
 * @param int    $usage The quantity of medicine being used
 * @param string $medId The ID of the medicine
 *
 * @return void
 */
function checkTheStock($usage, $medId)
{
  global $db;

  // Get the current stock for the given medicine id
  $getStock = $db->getConnection()->prepare("SELECT `stock` FROM `animal_medicine` WHERE `id` = ?");
  $getStock->bind_param("s", $medId);
  $getStock->execute();
  $dataStock = $getStock->get_result()->fetch_assoc();

  if (!$dataStock) {
    handleErrorRedirect("Data obat ternak tidak valid.");
  }

  // Get the total quantity taken for the given medicine id
  $getTotalQuantity = $db->getConnection()->prepare("SELECT SUM(`quantity_taken`) as total_quantity FROM `medication_retrieval` WHERE `med_id` = ?");
  $getTotalQuantity->bind_param("s", $medId);
  $getTotalQuantity->execute();
  $dataTotalQuantity = $getTotalQuantity->get_result()->fetch_assoc();

  if (!$dataTotalQuantity) {
    handleErrorRedirect("Gagal mengkalkulasi Jumlah Obat Ternak");
  }

  // Calculate the new stock value
  $currentStock = $dataStock['stock'];
  $totalQuantityTaken = $dataTotalQuantity['total_quantity'];
  $newStock = $currentStock - ($totalQuantityTaken + intval($usage));

  if($newStock < 0) {
    return handleErrorRedirect("Maaf, stok obat tidak cukup. Mohon beritahu bagian gudang untuk mengisi ulang stok obat ke dalam gudang Obat.");
  }
}

/**
 * Handles the submission of the form, including file upload and database insertion
 *
 * @param object $db The database connection object
 *
 * @return void
 */
function handleFormSubmission($db)
{
  $input = Request::only('retrieval_date', 'med_id');
  $store = array_merge($input, ['id' => uniqid(), 'taken_by' => intval(Request::post('taken_by')), 'quantity_taken' => intval(Request::post('quantity_taken'))]);
  $fileInfo = Request::file('evidence');
  $id = Sanitize::validateInput($_GET['id']);
  
  // Check if there has negative input to prevent bug
  if($store['quantity_taken'] <= 0) {
    handleErrorRedirect("Nilai jumlah yang diambil harus positif lebih dari nol.");
  }

  // Check medicine stock availability
  checkTheStock(Request::post('quantity_taken'), Request::post('med_id'));

  // If has file is selected for upload
  if ($fileInfo['full_path'] !== "") {
    $fullFilename = uploadTheFile($fileInfo);
    $store['evidence'] = $fullFilename;
  }

  // Insert data into the 'medication_retrieval' table
  $db->update('medication_retrieval', $store, "`id` = '{$id}'");

  // Redirect to success page
  handleSuccessRedirect("Berhasil mengubah data pengambilan obat.");
}

/**
 * Redirects to the dashboard with a success message
 *
 * @param string $message The success message to be displayed
 *
 * @return void
 */
function handleSuccessRedirect($message) {
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