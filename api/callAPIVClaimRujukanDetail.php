<?php
require 'config.php';

// Add the CORS headers
header("Access-Control-Allow-Origin: *"); // Allow all origins (or specify particular domains)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allowed custom headers
header("Access-Control-Allow-Credentials: true"); // Allow credentials like cookies

$id = 1;

// Select API endpoint based on some configuration
$check = get_api_config_by_id($id, $conn);

if ($check === null) {
    http_response_code(404); // Not found
    echo json_encode(["error" => "Configuration not found"]);
    exit;
}

$date = date('Y-m-16');
$nomor_rujukan = $_GET['nomor_rujukan'];
$api_url = $check['api_vclaim'] . "Rujukan/$nomor_rujukan";

// Initialize cURL
$session = curl_init();

$contentType = 'Application/x-www-form-urlencoded';
$secretKey = "4sL53AF14A";

$userkey = '8dfc8a2249965a772db00aa1c3fea034';
$arrheader = array(
    'X-cons-id: ' . $_GET['x-cons-id'],
    'X-timestamp: ' . $_GET['x-timestamp'],
    'X-signature: ' . $_GET['X-signature'],
    'Accept: application/json',
    'Content-Type: ' . $contentType,
);

$arrheader[] = 'user_key: ' . $userkey;

curl_setopt($session, CURLOPT_URL, $api_url);
curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);
curl_setopt($session, CURLOPT_HTTPGET, 1); // Use GET method
curl_setopt($session, CURLOPT_VERBOSE, true);
curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
$jsonData = curl_exec($session);

// Check for errors
if (curl_errno($session)) {
    echo json_encode(["error" => curl_error($session)]); // Return the error message in JSON
} else {
    // Decode the JSON response into PHP object
    $responseObj = json_decode($jsonData);

    // Output the response object
    // echo "<pre>";
    // var_dump($responseObj->response);

    $url = $responseObj->response;

    // $url = '';
    $try = stringDecrypt( $_GET['x-cons-id'] . $secretKey .$_GET['x-timestamp'], $url);
    $stringDerypt = decompress($try);

    // Hilangkan informasi panjang dan tanda kutip
    $cleanedJsonString = preg_replace('/string\(\d+\)\s/', '', $stringDerypt);
    $cleanedJsonString = trim($cleanedJsonString, '"');

    // Mendekode JSON menjadi objek PHP
    $pesertaObj = json_decode($cleanedJsonString);

    if (json_last_error() === JSON_ERROR_NONE) {
        // Mengambil nama peserta
        // $nama = $pesertaObj->peserta->nama;  // Output: HARI PRANOTO W
        
        // Membuat array untuk dikembalikan
        $result = [
            'status' => 'success',
            'data'=>$pesertaObj->rujukan
        ];
        
        // Mengembalikan sebagai JSON
        header('Content-Type: application/json');
    
        echo json_encode($result);  // Mengembalikan hasil sebagai JSON
    } else {
        // Mengembalikan kesalahan decoding
        $error = json_last_error_msg();
        $errorResponse = [
            'status' => 'error',
            'message' => $error
        ];
        
        return json_encode($errorResponse);  // Mengembalikan kesalahan sebagai JSON
    }
}

// Close cURL resource
curl_close($session);
