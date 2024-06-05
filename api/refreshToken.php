<?php

// Start the session
session_start();
// Memasukkan file konfigurasi database
require_once 'config.php';



//baseurl
//CDN
$api_vclaim = 'https://new-apijkn.bpjs-kesehatan.go.id/vclaim-rest/';
//NON CDN
//$api_vclaim = 'https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/';

// Mengambil input data dan secret key dari request
$data ="21540";
$secretKey =  "4sL53AF14A";

// Mengatur zona waktu ke UTC
date_default_timezone_set('UTC');


// var_dump($check);die;

// Menghitung timestamp
$tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));


// Menghitung tanda tangan (signature) dengan hashing data & timestamp menggunakan secret key
$signature = hash_hmac('sha256', $data . "&" . $tStamp, $secretKey, true);

// Base64 encoding tanda tangan yang telah dihitung
$encodedSignature = base64_encode($signature);


