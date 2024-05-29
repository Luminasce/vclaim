<?php
require_once 'vendor/autoload.php';

// Mengatur informasi koneksi database MySQL
$host = "localhost"; // Ganti dengan nama host Anda
$db_name = "dashboard"; // Ganti dengan nama database Anda
$user = "root"; // Ganti dengan nama pengguna database
$password = ""; // Ganti dengan kata sandi database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $db_name);

// Periksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
function update_api_config($id, $cons_id, $timestamp, $signature, $conn)
{
    // Query untuk memperbarui data dalam tabel berdasarkan ID
    $sql = "UPDATE konfig_api_k 
            SET cons_id = ?, timestamp = ?, signature = ? 
            WHERE id = ?";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);

    // Periksa apakah statement berhasil disiapkan
    if (!$stmt) {
        die("Persiapan update gagal: " . $conn->error);
    }

    // Mengikat parameter dan menjalankan query
    // Parameter disusun sesuai urutan dalam SQL (cons_id, timestamp, signature, id)
    $stmt->bind_param("ssss", $cons_id, $timestamp, $signature, $id);
    if (!$stmt->execute()) {
        die("Eksekusi update gagal: " . $stmt->error);
    }

    // Tutup statement
    $stmt->close();
}


// Fungsi untuk menyimpan data ke dalam tabel konfig_api_k
function insert_api_config($cons_id, $timestamp, $signature, $conn)
{
    // Query untuk memasukkan data ke dalam tabel
    $sql = "INSERT INTO konfig_api_k (cons_id, timestamp, signature) VALUES (?, ?, ?)";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);

    // Periksa apakah statement berhasil disiapkan
    if (!$stmt) {
        die("Penyimpanan data gagal: " . $conn->error);
    }

    // Mengikat parameter dan menjalankan query
    $stmt->bind_param("sss", $cons_id, $timestamp, $signature);
    if (!$stmt->execute()) {
        die("Eksekusi penyimpanan data gagal: " . $stmt->error);
    }

    // Tutup statement
    $stmt->close();
}

function get_api_config_by_id($id, $conn) {
    // Query untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM konfig_api_k WHERE id = ?";

    // Menyiapkan statement
    $stmt = $conn->prepare($sql);

    // Periksa apakah statement berhasil disiapkan
    if (!$stmt) {
        die("Persiapan SELECT gagal: " . $conn->error);
    }

    // Mengikat parameter dan menjalankan query
    $stmt->bind_param("i", $id); // "i" untuk integer
    if (!$stmt->execute()) {
        die("Eksekusi SELECT gagal: " . $stmt->error);
    }

    // Mendapatkan hasil
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Tidak ada data yang ditemukan untuk ID: $id";
        return null;
    }

    // Mengambil data sebagai array asosiatif
    $data = $result->fetch_assoc();

    // Tutup statement
    $stmt->close();

    // Kembalikan data yang diambil
    return $data;
}


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



// Jangan lupa untuk menutup koneksi database
register_shutdown_function(function () use ($conn) {
    $conn->close();
});
