<?php
require '../config.php';

// Add the CORS headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

$id = 1;

// Retrieve the API endpoint from the configuration
$check = get_api_config_by_id($id, $conn);

if ($check === null) {
    http_response_code(404); // Not found
    echo json_encode(["error" => "Configuration not found"]);
    exit;
}


// INSERT
// $api_url = $check['api_vclaim'] . "SEP/2.0/insert"; // Modify with the correct endpoint


// Delete
$api_url = $check['api_vclaim'] . "SEP/2.0/delete"; // Modify with the correct endpoint


// Data for the POST request, formatted in JSON
// $post_data = '{
//     "request":{
//        "t_sep":{
//           "noKartu":"0001704152182",
//           "tglSep":"2024-05-10",
//           "ppkPelayanan":"0217R084",
//           "jnsPelayanan":"2",
//           "klsRawat":{
//              "klsRawatHak":"1",
//              "klsRawatNaik":"",
//              "pembiayaan":"",
//              "penanggungJawab":""
//           },
//           "noMR":"100284052",
//           "rujukan":{
//              "asalRujukan":"2",
//              "tglRujukan":"2024-05-10",
//              "noRujukan":"",
//              "ppkRujukan":"0217R084"
//           },
//           "catatan":"",
//           "diagAwal":"A09.0",
//           "poli":{
//              "tujuan":"IGD",
//              "eksekutif":"0"
//           },
//           "cob":{
//              "cob":"0"
//           },
//           "katarak":{
//              "katarak":"0"
//           },
//           "jaminan":{
//              "lakaLantas":"0",
//              "penjamin":{
//                 "tglKejadian":"",
//                 "keterangan":"",
//                 "suplesi":{
//                    "suplesi":"0",
//                    "noSepSuplesi":"",
//                    "lokasiLaka":{
//                       "kdPropinsi":"",
//                       "kdKabupaten":"",
//                       "kdKecamatan":""
//                    }
//                 }
//              }
//           },
//           "tujuanKunj":"0",
//           "flagProcedure":"",
//           "kdPenunjang":"",
//           "assesmentPel":"", 
//           "skdp":{
//              "noSurat":"",
//              "kodeDPJP":"39463"
//           },
//           "dpjpLayan":"39463",
//           "noTelp":"08511111100",
//           "user":"admin"
//        }
//     }
//  }';


// sampleData
// $nokartu = "0001704152182";
// $tglsep = "2024-05-16";
// $ppkpelayanan = "0217R084";
// $jnspelayanan = "2";

// $klsrawat = "1";

// $klsRawatNaik = "";
// $pembiayaan = "";
// $penanggungJawab = "";
// $nomr = "100284052";
// $tglrujukan = "2024-05-16";
// $asalrujukan = "2";
// $norujukan = "";
// $ppkrujukan = "0217R084";
// $catatan = "";
// $diagawal = "A09.0";
// $politujuan = "IGD";
// $eksekutif = "0";
// $cob = "0";
// $katarak = "0";
// $lakalantas = "0";
// $nolakalantas = "";
// $tglKejadian = "";
// $keterangan = "";
// $suplesi = "0";
// $noSepSuplesi = "";
// $kdPropinsi = "";
// $kdKabupaten = "";
// $kdKecamatan = "";
// $tujuanKunj = "0";
// $flagProcedure = "";
// $kdPenunjang = "";
// $assesmentPel = "";
// $noSurat = "";
// $kodeDPJP = "39463";
// $dpjpLayan = "39463";
// $notlp = "08511111100";
// $user = "admin";

// // Post

$query = '{
    "request":
     {
    "t_sep":
        {
            "noKartu":"' . $nokartu . '",
            "tglSep":"' . $tglsep . '",
            "ppkPelayanan":"' . $ppkpelayanan . '",
            "jnsPelayanan":"' . $jnspelayanan . '",
            "klsRawat":{
                "klsRawatHak":"' . $klsrawat . '",
                "klsRawatNaik":"' . $klsRawatNaik . '",
                "pembiayaan":"' . $pembiayaan . '",
                "penanggungJawab":"' . $penanggungJawab . '"
            },
            "noMR":"' . $nomr . '",
            "rujukan": {
                "asalRujukan":"' . $asalrujukan . '",
                "tglRujukan":"' . $tglrujukan . '",
                "noRujukan":"' . $norujukan . '",
                "ppkRujukan":"' . $ppkrujukan . '"
            },
            "catatan":"' . $catatan . '",
            "diagAwal":"' . $diagawal . '",
            "poli": {
                "tujuan":"' . $politujuan . '",
                "eksekutif":"' . $eksekutif . '"
            },
            "cob": {
                "cob":"' . $cob . '"
            },
            "katarak": {
                "katarak": "' . $katarak . '"
            },
            "jaminan": {
                "lakaLantas": "' . $lakalantas . '",
                "noLP": "' . $nolakalantas . '",
                "penjamin": {
                    "tglKejadian": "' . $tglKejadian . '",
                    "keterangan": "' . $keterangan . '",
                    "suplesi": {
                        "suplesi": "' . $suplesi . '",
                        "noSepSuplesi": "' . $noSepSuplesi . '",
                        "lokasiLaka": {
                            "kdPropinsi": "' . $kdPropinsi . '",
                            "kdKabupaten": "' . $kdKabupaten . '",
                            "kdKecamatan": "' . $kdKecamatan . '"
                            }
                    }
                }
            },
            "tujuanKunj":"' . $tujuanKunj . '",
            "flagProcedure":"' . $flagProcedure . '",
            "kdPenunjang":"' . $kdPenunjang . '",
            "assesmentPel":"' . $assesmentPel . '",
            "skdp": {
               "noSurat": "' . $noSurat . '",
               "kodeDPJP": "' . $kodeDPJP . '"
            },
            "dpjpLayan": "' . $dpjpLayan . '",
            "noTelp":"' . $notlp . '",
            "user":"' . $user . '"
        }
    }
}';


// SEP SAMPLE DATA DELETE
// $noSEP = '0217R0840524V009340';
// $admin = 'admin';

// //  Delete
// $query = '                                           
// {
//    "request": {
//       "t_sep": {
//          "noSep": "'.$noSEP.'",
//          "user": "'.$admin.'"
//       }
//    }
// }
//           ';

$method = "DELETE";
$contentType = 'Application/x-www-form-urlencoded';
$userkey = '8dfc8a2249965a772db00aa1c3fea034';
$session = curl_init($url);
$arrheader = array(
    'X-cons-id: ' . $_POST['x-cons-id'],
    'X-timestamp: ' . $_POST['x-timestamp'],
    'X-signature: ' . $_POST['X-signature'],
    'Accept: application/json',
    'Content-Type: ' . $contentType
);

$arrheader[] = 'user_key: ' . $userkey;


curl_setopt($session, CURLOPT_URL, $api_url);
curl_setopt($session, CURLOPT_HTTPHEADER, $arrheader);

curl_setopt($session, CURLOPT_VERBOSE, true);
curl_setopt($session, CURLOPT_SSL_VERIFYHOST, true);
curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);


switch ($method) {
    case 'POST':
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $query);
        break;
    case 'PUT':
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($session, CURLOPT_POSTFIELDS, $query);
        break;
    case 'DELETE':
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($session, CURLOPT_POSTFIELDS, $query);
        break;
}
    $response = curl_exec($session);
    $err = curl_errno($session);


// Check for errors
if (curl_errno($session)) {
    echo "2";
    echo "<pre>";
    $info = curl_getinfo($session);
    var_dump($info);
    die;
    // echo json_encode(["error" => curl_error($ch)]); // Return the error message in JSON format
} else {
    // echo "<pre>";
    // $info = curl_getinfo($session);
    // var_dump($response);
    // die;
    // Decode and return the response
    echo json_encode(json_decode($response, true)); // Convert and output as JSON
}

// Close cURL
curl_close($session);
