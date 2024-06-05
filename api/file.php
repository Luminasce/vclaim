<?php

function save_data_to_file($data, $filename) {
    $json_data = json_encode($data, JSON_PRETTY_PRINT);
    if ($json_data === false) {
        return 'JSON encode error: ' . json_last_error_msg();
    }

    $result = file_put_contents($filename, $json_data);
    if ($result === false) {
        return 'File write error';
    }

    return true;
}

function load_data_from_file($filename) {
    if (file_exists($filename)) {
        $json_data = file_get_contents($filename);
        if ($json_data === false) {
            return 'File read error';
        }

        $data = json_decode($json_data, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            return 'JSON decode error: ' . json_last_error_msg();
        }

        return $data;
    }

    return [];
}

?>
