<?php
header('Content-Type: application/javascript');

// Sample data arrays
$getSuratKontrol = [100, 200, 300, 150, 250, 300, 400, 150, 250, 300];
$getPeserta = [150, 250, 350, 200, 300, 350, 450, 200, 300, 350];
$getPcare = [50, 150, 250, 100, 200, 250, 350, 100, 200, 250];
$timeLabels = ["08:30", "08:31", "08:32", "08:33", "08:34", "08:35", "08:36", "08:37", "08:38", "08:39"];
$batasLancar = array_fill(0, count($timeLabels), 1000); // Threshold for smooth operation
$batasLambat = array_fill(0, count($timeLabels), 2000); // Threshold for slow operation

echo "
    const labels = " . json_encode($timeLabels) . ";
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Get Surat Kontrol',
                data: " . json_encode($getSuratKontrol) . ",
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                lineTension: 0,

                fill: true,
            },
            {
                label: 'Get Peserta',
                data: " . json_encode($getPeserta) . ",
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                lineTension: 0,

                fill: true,
            },
            {
                label: 'Get PCare',
                data: " . json_encode($getPcare) . ",
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
                lineTension: 0,
                backgroundColor: 'rgba(255, 0, 0, 0.1)',
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
                        text: 'Requests'
                    },
                    suggestedMin: 0,
                    suggestedMax: 3500
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
