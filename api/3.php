<?php

$nik = '3578066803580001';
$date = date('Y-m-d');
$filename = 'api_responses.json';

require 'file.php'; // Mengimpor file_storage.php

function call_api($url, $headers) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $start = microtime(true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => $error_msg, 'response_time' => 0];
    }

    $end = microtime(true);

    $response_time = round(($end - $start) * 1000, 2);

    curl_close($ch);

    return [
        'response' => $response,
        'response_time' => $response_time
    ];
}

// Konfigurasi header untuk autentikasi
require '../api/config.php';
require '../api/refreshToken.php';

$userkey = '8dfc8a2249965a772db00aa1c3fea034';
$contentType = 'application/x-www-form-urlencoded';

$headers = [
    'X-cons-id: ' . $data,
    'X-timestamp: ' . $tStamp,
    'X-signature: ' . $encodedSignature,
    'Accept: application/json',
    'Content-Type: ' . $contentType,
    'user_key: ' . $userkey,
];

$api_urls = [
    'API Rencana Kontrol' => "https://new-apijkn.bpjs-kesehatan.go.id/vclaim-rest/RencanaKontrol/ListRencanaKontrol/tglAwal/$date/tglAkhir/$date/filter/1",
    'API Peserta' => "https://new-apijkn.bpjs-kesehatan.go.id/vclaim-rest/Peserta/nik/$nik/tglSEP/$date",
    'API PCare' => "https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest/peserta/$nik",

];

$data = load_data_from_file($filename);

if (is_string($data)) {
    // echo 'Error loading data from file: ' . $data . '<br>';
    $data = []; // Reset to empty array if error occurred
}

foreach ($api_urls as $api_name => $url) {
    $result = call_api($url, $headers);
    
    $data[] = [
        'api_name' => $api_name,
        'response_time' => $result['response_time'],
        'error' => $result['error'] ?? '',
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

$save_result = save_data_to_file($data, $filename);
if ($save_result !== true) {
    // echo 'Error saving data to file: ' . $save_result . '<br>';
} else {
    // echo 'Data berhasil disimpan ke file.<br>';
}

foreach ($data as $entry) {
    // echo '<h2>' . $entry['api_name'] . '</h2>';
    // echo 'Response Time: ' . $entry['response_time'] . ' ms<br>';
    // echo 'Timestamp: ' . $entry['timestamp'] . '<br>';
    // if (!empty($entry['error'])) {
    //     echo 'Error: ' . $entry['error'] . '<br><br>';
    // } 
}
?>
