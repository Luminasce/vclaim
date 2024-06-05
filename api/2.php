<?php
require_once 'vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$cons_id = "21540";

$timestamp = "1715827193";
$signature = "YOJzfQa7XMiZjk8fzh+YDX6kaLCBp0stAtLvL9nhbk4=";
$secretKey = "4sL53AF14A";

// function decrypt


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

// function lzstring decompress 
// download libraries lzstring : https://github.com/nullpunkt/lz-string-php

// $url = "HP0v55Fy3DNrUc8v+gLpHbSgQbyEp1G7yrYhPyTimqtCRyH6i4ziwD9AKFUKwpDZEUvb/2Mbme0L4beHZIue1+egnxuFeNI95bIxw/gN6bqGhyATK2ZXZlmebAwnlVnejJgUSnVbS+BWC8GxAmBee/wT5nBUddgY2ImS8ugd6m/zbGfli7VlX2tDOpO2R7scHRsPsLZ/RoZfKHQey5TKnl2zyTERvripgUejUU94tcoA6ixSSBwi4YP5Gr5MVmHDJEYUYVwo/0nERAh7UulBA2YLPdyjUL63Ow5F5H/jkUG8YIujP4lFUI4ByE8FhDG/Igfy5GHsvBLT2j0YlprVcil5Ek/fZCVuBkqSA0nhzXer3q7jX6BoUVVPOny9IUkmRhK81pu8zlyFaIP/jAg+CTOZcRng7wqZuURlsvRjhEqUJdPGZ4a5x4U/YrpX+l9o8a+TW0lOjT0KV14OwAXHqO3xVFrNwu6jAC7pLYpCjUa/uj1FowtrwrJIuFk+1Fb9DUIqW1sSQaJi7276BCOyUZOHKZLmXon1qFQQwVf3Hklh7UJj5lCcSwloH54F8i4tCBbPrGOOWpVzxz/rxYWgoH/We2vmbS6oZgtngvoNgzgKGtJ3MB4shJky2zWizskS2ifjHcUlSF3sRcgCCfCjtv7bzAFwIeeiE53Mi6fdoWH3bHzmNulCLvHRiV2BE2sX0J7XivJcf8H6a32CBEeBmWiRjRIivxN4xAZD+4Gspig7FaBYrm0WylJkC1R9QeFTvXLiEYchfKgni6X1OtrC+UMB/NySdkB3FrgI6XVo3PP0zAMtpSM5UHHfzRiXs0dq8K375oGhM3SwufPv7V12YSczgSS/bPROb+7AEMxTfjzPfpIJ8JjEoViGkib3jmLpy4TtHeoTPjoGS3UTLfsMkNbOdAFXeYAXMdlwrG+QURnT3jUaX7KoIAX4kZBT26uxPtkvCXPes6GVUyMlqx5jahIhRCuvm4tUWHZ73l8hv6xu6bTGbgHl8+BWyyJFVDry1uelL6DcMMMGwBOWkFGiEwvaFiJ1/blsBQU9GINax1rqrEli1ejK8KQ80RBft9I3GkToBgnFT8bBLcnQKCwp+h2K60uNfTIluvulzUXJNtgMTWCXX6t5T4FyZRE8u2tpS2XVFAae+pd+oRtqUhCZqPjNFvn5IYX+q7AckhEPRn2Tjhx22Wb4nr1h2VA3Kf3croqROOpVFmVQ11vCPm1zEt5QoJ0pkNtoQSGpabb2jPQylulJ9aHLVNAZbhHysOG5xmEV/vqEw5+xVWOcZLbZAMcK3JcDcIuWKFpI+4YEQhC/6ybL6ci10WVkGo2cery8N6TpLGPXeRIxZkKGeZHimlEZnPaTAztb5YWA7mFZw44mSBwUUgvBDJ4Mg1ZwAEazudJiBhZ9fGts2+tDrt4YlchmlkLjRc8NroKCxH3iDYzQB9BtgZ0NdCSM8P5WvM3tDW7YI6oqU69b/XRl5q8X5KDXGyZkd49twfnHcUuC+w50TzUIaw3Xb7yKieUGUGMGUyJIa0ibKiXpPq4tgR9iZy08M/dICO6kO7a6DjJK7/UwZTwIaA6OzqrHHx8sBxlFjsLsMT9Eif0/y7W0rC8DRdwWrZvOtP9CsY7qg4T0vR5fQZtUJq7uvlYYpSmq8rgoOEvhyNWTYRczx9jfSUpoPATHwzbOdhiqBcqsZEB8/FNZ1+boAkApW93lT4SyEZmacO6pnmr90rS2IO2ZwVbKaLdLy0DGMaVDs8FAJMKfcbJVy3ho7mCTeLHB4g1mMP9mG9M0fK9ofOB5KBZiw80Qm0UFYPQZ0l78dCVRiPNE++6uZ4qxtF+Jizglht27GM5w7Kkv2xoQnvnpwo19h5fUaSfFlVIdrvCLfrRM4v4ds0JbcZzu+HfD5P7vOtf5D2GVjj/dqgNgbcWdbTpPBorxJ6wM1a7xEgoiM8GEe+WI2YRwX+3eXjulaLZ440C+PAKzw1dUHTZ7W7yYYhfMSqNonCtW2B4oitlthfZCy1XJeK3dhUMbKpj0aJ9/MRsPAbQxOaWlzEH5sKQH4CLbAu1vcQCAH74mqxyDxLCttkZSKijjWvwZHj3OXeoJXIjDMS/UcwqUtsaAt+ueSM1Zl+SgTY9M2QatNGmOjiVg/dzo5FUBm9SjdV+9L4omIRLZwbGXBKvcbFZvuHV94boO6rr71pKkPjDHPQanKeGI7z7cdpt8jx/5w31bHF35daDX4KgpO2iR6uYfBUTeGa/3hiekWkO0tBL8l9Bt8gZwrziOZQbK3AshxHBNRRAwx73pJ7EpF4YDWtaiz8A5Mo3Qb4NlzZbJf67jYs44WBM9EQqXqbVgrzzAdAQw2H2d/Iom5KyLj8koLMKCQOO06ehTV4Nc2a0mO7ywG3lCN2b2KWkt7yUWGKj5zp/pwousLFkeHsTDY3z2iGZZ+JAofFBpZJl4MxOSe7YGMeVmiMHBoZqTlD7dR6pGfA/2aiQNSmVEGXNygQ9uL7ohGLdY2oztCEP3oGw1TFjYnLlpVp3uTOAxwcdkWcM9ZRjPkz/d7karp+d/O2hSBPJOtjpN3VyidbRgyziWsVuRRlzL53JiQpsDxITM5JnBe5gPIihY5fG3BmV9F4sR6ua+Ir/K3f+L7AekaDzY/tuZph1w2MzJ16YmVu5hyreTsEMgwQZwX2VBxVyg0e8jaKGIN3DlDf1cd5apwgsddmlw0XvX/MCM2yTbZkZFpwFECyIpGpMFEjd8QH8j4e/ASx/EX8PzNBfEzOWC34ANnh/3t339wzOTCsinSNjkeiPL6xOsRgzKlLuY0MqclnqiBY2oJgHBK6QV1AgupB2KbC5iKOikbUDxxqkG8l1lEBx7yxcuNICykkbPXhABGEPMdDxvF9jIsaEZ94Qqyg==";


// $url = 'zzHkXWI2wThg0oeW\/Bkvi4TtiZr2Qm+xTsM8FS+fX2yO7Q3NXNTwanu6nUcfyttCkX7cTvPDtIyd6KaHoJCHCPiGuTNMqVGV\/M+E436glrICCGZu4hU+ST58s2b+NjzbP\/7LtqWnNpSonHU39fZEam7s32fwXTaTgP0zHMZ7AqZ1usBTZ4aCSyDE++ormPC4vClxWCjUbaeqTO0lXEk1ocvIAQS3qs+a+VtLLIuVzELqiMXMgLlsITINRiBKxiavY14qtc0IjfGIutfl1howA21anCNFlfaqFsn1+5\/M58vf+aUljLk\/Tr8WMGOPgbtN+8gUF\/\/MO4d9RWI53z\/hkPtpXJgLrwatR6SHgKtqPQC7Ju9x5bYbLDuaRrpbFUOF2yKGwAuHIx4AhWSCEEnp0VRB3iX33NCzEmMSLJ7vw7S3Zo9+vNfDDz7J01+VjCrb2tk4NpLOu7VciNfAt9yxUf2ycKVv18msXtEATxbVcz7TZj5oR2tiX9K8C1PnvEUFCNBf2Gs0I\/ohZJ6MDilBwZGbIumlXB2dOQzhQ5wHlV018rf9FD\/4d7w9It5AC2u\/FtGu7kVP8lmSxe\/BUq8A6BMDxFXVBy6cnE4PYiYxa6Ncr1IhdPEeLnJIGzmX7UU9f0AprdBNaXjEhlj3ioqQkA5laiMJ8g3tClwkk8SVRwPWZMur0TpX4hWFG7iBJVxZ3j91th4JGdfG2yIlMVSzOoB82S7ixrnxV6r1jrfH+5Ti+9wQfb4oq7GjgtJCqXcHGl5XxqzdtRHmpH7Q\/tIUVH2LuETTRE9Yg5OIoRO+gRRgv9iofHg6O5iNbYLAFboiRbZKuec2GHrNtbnxAvJotIGwYZpW33mSQ1xP6u5VivP1AVkD27kvuW+xZx+EnAnl';
$try = stringDecrypt($cons_id . $secretKey . $timestamp, $url);
$stringDerypt = decompress($try);

// Hilangkan informasi panjang dan tanda kutip
$cleanedJsonString = preg_replace('/string\(\d+\)\s/', '', $stringDerypt);
$cleanedJsonString = trim($cleanedJsonString, '"');

// Mendekode JSON menjadi objek PHP
$pesertaObj = json_decode($cleanedJsonString);

// Cek kesalahan decoding
if (json_last_error() === JSON_ERROR_NONE) {
    // Mengambil nama peserta
    // $nama = $pesertaObj->peserta->nama;  // Output: HARI PRANOTO W
    
    // Membuat array untuk dikembalikan
    $result = [
        'status' => 'success',
        'data' => [
            'peserta' => $pesertaObj
        ]
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
// echo $try;
// if ($res2 != null) {
//     // echo "-";
//     var_dump($res2);
//     // echo $res2;

// } else {
//     echo "--";
// }
// var_dump($signature);
// echo $cons_id.$timestamp.$secretKey;
function decompress($string)
{

    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);

}

?>