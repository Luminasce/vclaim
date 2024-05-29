<?php
// Memasukkan file konfigurasi database
require_once 'config.php';

// Mengambil input data dan secret key dari request
$data = isset($_POST['x_cons_id']) ? $_POST['x_cons_id'] : "default_data";
$secretKey = isset($_POST['secret_key']) ? $_POST['secret_key'] : "default_secret_key";

// Mengatur zona waktu ke UTC
date_default_timezone_set('UTC');

// Menghitung timestamp
$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));

// Menghitung tanda tangan (signature) dengan hashing data & timestamp menggunakan secret key
$signature = hash_hmac('sha256', $data . "&" . $tStamp, $secretKey, true);

// Base64 encoding tanda tangan yang telah dihitung
$encodedSignature = base64_encode($signature);

// Menyimpan data ke dalam tabel konfig_api_k
insert_api_config($data, $tStamp, $encodedSignature, $conn);

// Menampilkan header API yang dibuat
header('Content-Type: application/json');

// Data respons JSON yang mencakup cons-id, timestamp, dan signature
$response = array(
    "X-cons-id" => $data,
    "X-timestamp" => $tStamp,
    "X-signature" => $encodedSignature,
    "status" => "success",
    "message" => "Data received and signed successfully."
);

// Mengirim respons dalam bentuk JSON
echo json_encode($response);
