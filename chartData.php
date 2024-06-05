<?php
header('Content-Type: application/javascript');

$filename = './api/api_responses.json'; // Path to your JSON file
$json_data = file_get_contents($filename);

// Check if JSON decoding was successful
$data = json_decode($json_data, true);
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON file: ' . json_last_error_msg());
}

// Initialize arrays to store aggregated data per minute
$getSuratKontrol = [];
$getPeserta = [];
$getPcare = [];
$timeLabels = [];

// Process data per minute
foreach ($data as $entry) {
    $api_name = $entry['api_name'];
    $response_time = $entry['response_time'];
    $timestamp = strtotime($entry['timestamp']);

    // Calculate minute from timestamp
    $minute = date('H:i', $timestamp);

    // Use API name as label for dataset
    switch ($api_name) {
        case 'API Rencana Kontrol':
            if (!isset($getSuratKontrol[$minute])) {
                $getSuratKontrol[$minute] = [];
            }
            $getSuratKontrol[$minute][] = $response_time;
            break;
        case 'API Peserta':
            if (!isset($getPeserta[$minute])) {
                $getPeserta[$minute] = [];
            }
            $getPeserta[$minute][] = $response_time;
            break;
        case 'API PCare':
            if (!isset($getPcare[$minute])) {
                $getPcare[$minute] = [];
            }
            $getPcare[$minute][] = $response_time;
            break;
    }
}

// Calculate averages or other aggregates per minute
$getSuratKontrolAvg = [];
$getPesertaAvg = [];
$getPcareAvg = [];

foreach ($getSuratKontrol as $minute => $times) {
    $getSuratKontrolAvg[] = count($times) > 0 ? array_sum($times) / count($times) : 0;
}

foreach ($getPeserta as $minute => $times) {
    $getPesertaAvg[] = count($times) > 0 ? array_sum($times) / count($times) : 0;
}

foreach ($getPcare as $minute => $times) {
    $getPcareAvg[] = count($times) > 0 ? array_sum($times) / count($times) : 0;
}

// Prepare labels based on available minutes
$timeLabels = array_keys($getSuratKontrol);

// Thresholds for smooth and slow operation (adjust as needed)
$batasLancar = array_fill(0, count($timeLabels), 1000);
$batasLambat = array_fill(0, count($timeLabels), 2000);

// Output JavaScript for Chart.js
echo "
    const labels = " . json_encode($timeLabels) . ";
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Get Surat Kontrol',
                data: " . json_encode($getSuratKontrolAvg) . ",
                borderColor: 'rgba(55, 99, 132, 1)',
                backgroundColor: 'rgba(55, 99, 133, 0.2)',
                lineTension: 0,
                fill: true,
            },
            {
                label: 'Get Peserta',
                data: " . json_encode($getPesertaAvg) . ",
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                lineTension: 0,
                fill: true,
            },
            {
                label: 'Get PCare',
                data: " . json_encode($getPcareAvg) . ",
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                lineTension: 0,
                fill: true,
            },
            {
                label: 'Batas Lancar',
                data: " . json_encode($batasLancar) . ",
                borderColor: 'rgba(0, 255, 0, 0.5)',
                backgroundColor: 'rgba(0, 255, 0, 0.1)',
                lineTension: 0,
                fill: true,
            },
            {
                label: 'Batas Lambat',
                data: " . json_encode($batasLambat) . ",
                borderColor: 'rgba(255, 0, 0, 0.5)',
                backgroundColor: 'rgba(255, 0, 0, 0.1)',
                lineTension: 0,
                fill: true,
            }
        ]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Response Time (ms)'
                    },
                    suggestedMin: 0,
                    suggestedMax: 10000 // Adjust max as needed based on your data
                }
            }
        }
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
";
?>
