<?php
require_once 'vendor/autoload.php';

// // Mengatur informasi koneksi database MySQL
// $host = "localhost"; // Ganti dengan nama host Anda
// $db_name = "dashboard"; // Ganti dengan nama database Anda
// $user = "root"; // Ganti dengan nama pengguna database
// $password = ""; // Ganti dengan kata sandi database

// // Membuat koneksi ke database
// $conn = new mysqli($host, $user, $password, $db_name);

// // Periksa apakah koneksi berhasil
// if ($conn->connect_error) {
//     die("Koneksi ke database gagal: " . $conn->connect_error);
// }





function stringDecrypt($key, $string)
{


    $encrypt_method = 'AES-256-CBC';

    // hash
    $key_hash = hex2bin(hash('sha256', $key));

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

    return $output;
}

function decompress($string)
{

    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

}



