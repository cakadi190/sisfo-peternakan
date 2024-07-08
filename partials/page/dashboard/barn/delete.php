<?php

use function inc\helper\redirect;

function redirectToDashboard($message)
{
  $_SESSION['error'] = $message;
  redirect('/dashboard/barn');
}

function getFileFullPath($filename)
{
  return __DIR__ . '../../../../../uploads' . '/' . $filename;
}

function deleteFileIfExists($filename)
{
  $filePath = getFileFullPath($filename);
  if (file_exists($filePath) && !unlink($filePath)) {
    redirectToDashboard("Gagal menghapus berkas bukti dokumentasi!");
  }
}

function deleteMedicationData($db, $id)
{
  $stmt = $db->getConnection()->prepare("DELETE FROM barn_retrievals WHERE id = ?");
  $stmt->bind_param('s', $id);
  return $stmt->execute();
}

$id = $_GET['id'] ?? null;

if (!$id) {
  redirectToDashboard("ID target data pengambilan Pakan Ternak tidak diberikan!");
}

$stmt = $db->getConnection()->prepare("SELECT evidence FROM barn_retrievals WHERE id = ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  redirectToDashboard("Data pengambilan Pakan Ternak dengan ID tersebut tidak ditemukan!");
}

$rowData = $result->fetch_assoc();
deleteFileIfExists($rowData['evidence']);

if (deleteMedicationData($db, $id)) {
  $_SESSION['success'] = "Berhasil menghapus data pengambilan Pakan Ternak!";
} else {
  $_SESSION['error'] = "Gagal menghapus data pengambilan Pakan Ternak!";
}

redirect('/dashboard/barn');
