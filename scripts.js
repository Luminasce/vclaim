$(document).ready(function () {
  const fetchInterval = 180000; // 3 menit dalam milidetik
  // const fetchInterval = 1000; // 3 menit dalam milidetik



  
  //  Dashboard Kunjungan

  function fetchData() {
    console.log("Fetching data...");

    const timeoutDuration = 10000; // Batas waktu untuk permintaan tunggal, 10 detik

    // Menyiapkan permintaan AJAX
    const ajaxPromise = $.ajax({
      url: "./api/refreshToken.php", // Ganti dengan endpoint Anda
      method: "GET",
      dataType: "json",
    });

    // Mengatur waktu habis untuk AJAX menggunakan setTimeout
    const timeoutPromise = new Promise((resolve, reject) => {
      setTimeout(() => {
        reject(new Error("Request timeout, trying again..."));
      }, timeoutDuration);
    });

    // Menggunakan Promise.race untuk menangani batas waktu
    Promise.race([ajaxPromise, timeoutPromise])
      .then((response) => {
        sessionStorage.clear();

        console.log("Data fetched successfully", response);

        // $("#result").html(JSON.stringify(response));
        sessionStorage.setItem("x-cons-id", response.x_cons_id);
        sessionStorage.setItem("x-timestamp", response.x_timestamp);
        sessionStorage.setItem("x-signature", response.x_signature);
      })
      .catch((error) => {
        console.error(error.message);
        $("#result").html("Error: " + error.message);
      });
  }

  // Mengatur interval untuk menjalankan fetchData secara berulang-ulang
  setInterval(fetchData, fetchInterval);

  // Memulai permintaan pertama segera setelah halaman dimuat
  fetchData();

  // function fetchDataDashboardKunjungan() {
  //   console.log("Fetching data Kunjungan...");

  //    var formData = {
  //   'x-cons-id': sessionStorage.getItem('x-cons-id'), // example retrieval from front-end storage
  //   'x-timestamp': sessionStorage.getItem('x-timestamp'),
  //   'X-signature': sessionStorage.getItem('x-signature')
  // };
  //   $.ajax({
  //       url: "./api/callAPIVClaimKunjungan.php", // The URL to send the data to
  //       type: "GET", // The HTTP method to use
  //       data: formData, // The serialized form data
  //       success: function (response) {
  //         console.log("hello",response.data.sep.map());
  //     console.log("Sukses Generated");
  //       },
  //       error: function (xhr, status, error) {
  //         // Handle errors
  //         console.error("Error submitting form:", error);
  //         alert("There was an error submitting the form.");
  //       },
  //     });
  // }

  /*-------------- 7 Pie chart chartjs start ------------*/
  function fetchDataDashboardKunjunganRI() {
    console.log("Fetching data Kunjungan Rawat Inap...");

    var formData = {
      "x-cons-id": sessionStorage.getItem("x-cons-id"), // example retrieval from front-end storage
      "x-timestamp": sessionStorage.getItem("x-timestamp"),
      "X-signature": sessionStorage.getItem("x-signature"),
    };

    $.ajax({
      url: "./api/callAPIVClaimKunjunganRI.php", // The URL to send the data to
      type: "GET", // The HTTP method to use
      data: formData, // The serialized form data
      success: function (response) {
        console.log("Response received:", response);

        // Assuming the response contains data in the expected format
        var sepData = response.data.sep;

        $("#countRawatInap").text(sepData.length);
       
       
// Group the data by kelasRawat
var groupedData = sepData.reduce((acc, item) => {
  if (!acc[item.kelasRawat]) {
    acc[item.kelasRawat] = 0;
  }
  acc[item.kelasRawat]++;
  return acc;
}, {});

$("#countRawatInap").text(sepData.length);
console.log("Total Rawat Inap", sepData.length);
// Extract labels and data values from the grouped data
console.log("grouped Data", Object.keys(groupedData));
var labels = Object.keys(groupedData).map(
  (label) => `Kelas rawat inap ${label}`
);
var dataValues = Object.values(groupedData);

// Prepare data for ZingChart
var seriesData = Object.keys(groupedData).map((key, index) => ({
  values: [groupedData[key]],
  text: labels[index],
  "background-color": ["#8919FE", "#12C498", "#F8CB3F", "#E36D68"][index % 4]
}));

// Check if the chart element exists before updating
if ($('#coin_distribution').length) {
    zingchart.THEME = "classic";

    var myConfig = {
        "globals": {
            "font-family": "Roboto"
        },
        "graphset": [{
            "type": "pie",
            "background-color": "#fff",
            "legend": {
                "background-color": "none",
                "border-width": 0,
                "shadow": false,
                "layout": "float",
                "margin": "auto auto 16% auto",
                "marker": {
                    "border-radius": 3,
                    "border-width": 0
                },
                "item": {
                    "color": "%backgroundcolor"
                }
            },
            "plotarea": {
                "background-color": "#FFFFFF",
                "border-color": "#DFE1E3",
                "margin": "25% 8%"
            },
            "labels": [{
                "x": "45%",
                "y": "47%",
                "width": "10%",
                "text": `${sepData.length} Rawat Inap`,
                "font-size": 17,
                "font-weight": 700
            }],
            "plot": {
                "size": 70,
                "slice": 90,
                "margin-right": 0,
                "border-width": 0,
                "shadow": 0,
                "value-box": {
                    "visible": true
                },
                "tooltip": {
                    "text": "%v Rawat Inap",
                    "shadow": false,
                    "border-radius": 2
                }
            },
            "series": seriesData
        }]
    };

    zingchart.render({
        id: 'coin_distribution',
        data: myConfig,
    });
}
        console.log("Chart updated successfully");
      },
      error: function (xhr, status, error) {
        console.error("Error submitting form:", error);
        alert("There was an error submitting the form.");
      },
    });
  }

  function fetchDataDashboardWaktu() {
    console.log("Fetching data Kunjungan Rawat Jalan...");

    var formData = {
      "x-cons-id": sessionStorage.getItem("x-cons-id"), // example retrieval from front-end storage
      "x-timestamp": sessionStorage.getItem("x-timestamp"),
      "X-signature": sessionStorage.getItem("x-signature"),
    };

    $.ajax({
      url: "./api/callAPIVClaimWaktu.php", // The URL to send the data to
      type: "GET", // The HTTP method to use
      data: formData, // The serialized form data
      success: function (response) {
        console.log("Response received:", response);

        console.log("Line chart updated successfully");
      },
      error: function (xhr, status, error) {
        console.error("Error submitting form:", error);
        alert("There was an error submitting the form.");
      },
    });
  }

// function fetchDataDashboardKlaim() {
//     console.log("Fetching data Dashboard Klaim...");

//     var formData = {
//         "x-cons-id": sessionStorage.getItem("x-cons-id"), // example retrieval from front-end storage
//         "x-timestamp": sessionStorage.getItem("x-timestamp"),
//         "X-signature": sessionStorage.getItem("x-signature"),
//     };

//     $.ajax({
//         url: "./api/callAPIVClaimDataKlaim.php", // The URL to send the data to
//         type: "GET", // The HTTP method to use
//         data: formData, // The serialized form data
//         success: function (response) {
//             console.log("Response received:", response);

//             if ($("#salesanalytic").length) {
//                 var chartData = response.data.klaim.map(function(item) {
//                     return {
//                         "date": item.tglSep,
//                         "No Sep": item.noSEP,
//                         "Nama Peserta": item.peserta.namapeserta,
//                         "Poli": item.poli,
//                         "Biaya Yang disetujui": item.biaya.bySetujui
//                     };
//                 });

//                 var fields = Object.keys(chartData[0]).filter(key => key !== "date" && key !== "Kelas Rawat");
//                 var valueAxes = fields.map((field, index) => {
//                     return {
//                         id: "v" + (index + 1),
//                         title: field.charAt(0).toUpperCase() + field.slice(1),
//                         position: "lef",
//                         autoGridCount: false,
//                         labelFunction: function (value) {
//                             return value;
//                         },
//                         gridAlpha: (index % 2 === 0) ? 1 : 0,
//                     };
//                 });

//                 var graphs = fields.map((field, index) => {
//                     console.log("Nama Field", fields[index]);
//                     return {
//                         id: "g" + index,
//                         valueAxis: "v" + (index + 1),
//                         lineColor: "#" + ((1 << 24) * Math.random() | 0).toString(16), // Random color for each graph
//                         fillColors: "#" + ((1 << 24) * Math.random() | 0).toString(16),
//                         fillAlphas: 1,
//                         type: "column",
//                         title: field.charAt(0).toUpperCase() + field.slice(1), // Capitalize field name
//                         valueField: fields[index],
//                         clustered: false,
//                         columnWidth: 0.5,
//                         legendValueText: "[[value]]",
//                         balloonText: "[[title]]<br /><small style='font-size: 130%'>[[value]]</small>",
//                     };
//                 });

//                 console.log("chartData", chartData);
//                 var chart = AmCharts.makeChart("salesanalytic", {
//                     type: "serial",
//                     theme: "light",
//                     dataDateFormat: "YYYY-MM-DD",
//                     precision: 3,
//                     valueAxes: valueAxes,
//                     graphs: graphs,
//                     chartScrollbar: {
//                         graph: "g1",
//                         oppositeAxis: false,
//                         offset: 50,
//                         scrollbarHeight: 45,
//                         backgroundAlpha: 0,
//                         selectedBackgroundAlpha: 0.5,
//                         selectedBackgroundColor: "#f9f9f9",
//                         graphFillAlpha: 0.1,
//                         graphLineAlpha: 0.4,
//                         selectedGraphFillAlpha: 0,
//                         selectedGraphLineAlpha: 1,
//                         autoGridCount: true,
//                         color: "#95a1f9",
//                     },
//                     chartCursor: {
//                         pan: true,
//                         valueLineEnabled: true,
//                         valueLineBalloonEnabled: true,
//                         cursorAlpha: 0,
//                         valueLineAlpha: 0.2,
//                     },
//                     categoryField: "date",
//                     categoryAxis: {
//                         parseDates: true,
//                         dashLength: 1,
//                         minorGridEnabled: true,
//                         color: "#5C6DF4",
//                     },
//                     legend: {
//                         useGraphSettings: true,
//                         position: "top",
//                     },
//                     balloon: {
//                         borderThickness: 1,
//                         shadowAlpha: 0,
//                     },
//                     export: {
//                         enabled: false,
//                     },
//                     dataProvider: chartData,
//                 });
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error("Error submitting form:", error);
//             alert("There was an error submitting the form.");
//         },
//     });
// }




  function fetchDataDashboardKunjunganRJ() {
    console.log("Fetching data Kunjungan Rawat Jalan...");

    var formData = {
      "x-cons-id": sessionStorage.getItem("x-cons-id"), // example retrieval from front-end storage
      "x-timestamp": sessionStorage.getItem("x-timestamp"),
      "X-signature": sessionStorage.getItem("x-signature"),
    };

    $.ajax({
      url: "./api/callAPIVClaimKunjunganRJ.php", // The URL to send the data to
      type: "GET", // The HTTP method to use
      data: formData, // The serialized form data
      success: function (response) {
        console.log("Response received:", response);

        // Assuming the response contains data in the expected format
        var sepData = response.data.sep;

        // Group the data by poli
        var groupedData = sepData.reduce((acc, item) => {
          if (!acc[item.poli]) {
            acc[item.poli] = 0;
          }
          acc[item.poli]++;
          return acc;
        }, {});

        $("#countRawatJalan").text(sepData.length);
        console.log("Total Rawat Inap", sepData.length);
        // Extract labels and data values from the grouped data
        console.log("Grouped Data", Object.keys(groupedData));
        var labels = Object.keys(groupedData).map((label) => `Poli ${label}`);
        var dataValues = Object.values(groupedData);

        // Generate unique colors for each poli
        var backgroundColors = generateUniqueColors(labels.length);

        // Update the Highcharts chart dynamically
        if ($("#socialads").length) {
          Highcharts.chart("socialads", {
            chart: {
              type: "column",
            },
            title: false,
            xAxis: {
              categories: labels, // Using the same categories as the doughnut chart
            },
            colors: backgroundColors, // Using the same background colors
            yAxis: {
              min: 0,
              title: false,
            },
            tooltip: {
              pointFormat:
                '<span style="color:{point.color}">{point.category}</span>: <b>{point.y}</b><br/>',
              shared: true,
            },
            plotOptions: {
              column: {
                stacking: "normal", // Normal stacking for demonstration purposes
              },
            },
            series: [
              {
                name: "Total Visits",
                data: dataValues, // Using data values from the response
              },
            ],
          });
        }

        console.log("Column chart updated successfully");

        // Update the line chart dynamically
        if ($("#seolinechart1").length) {
          var ctx = document.getElementById("seolinechart1").getContext("2d");
          var chart = new Chart(ctx, {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Kunjungan Poli",
                  backgroundColor: "rgba(104, 124, 247, 0.6)",
                  borderColor: "#8596fe",
                  data: dataValues,
                },
              ],
            },
            options: {
              legend: {
                display: false,
              },
              animation: {
                easing: "easeInOutBack",
              },
              scales: {
                yAxes: [
                  {
                    display: !1,
                    ticks: {
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold",
                      beginAtZero: true,
                      maxTicksLimit: 5,
                      padding: 0,
                    },
                    gridLines: {
                      drawTicks: false,
                      display: false,
                    },
                  },
                ],
                xAxes: [
                  {
                    display: !1,
                    gridLines: {
                      zeroLineColor: "transparent",
                    },
                    ticks: {
                      padding: 0,
                      fontColor: "rgba(0,0,0,0.5)",
                      fontStyle: "bold",
                    },
                  },
                ],
              },
              elements: {
                line: {
                  tension: 0, // disables bezier curves
                },
              },
            },
          });
        }

        console.log("Line chart updated successfully");
      },
      error: function (xhr, status, error) {
        console.error("Error submitting form:", error);
        alert("There was an error submitting the form.");
      },
    });
  }

  // Function to generate unique colors
  function generateUniqueColors(numColors) {
    const colors = [];
    for (let i = 0; i < numColors; i++) {
      colors.push(getRandomColor());
    }
    return colors;
  }



  // Function to generate a random color
  function getRandomColor() {
    const letters = "0123456789ABCDEF";
    let color = "#";
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  /*-------------- 7 Pie chart chartjs end ------------*/

  function postDataSEP() {
    console.log("Fetching data POST...");

    var formData = {
      "x-cons-id": sessionStorage.getItem("x-cons-id"), // example retrieval from front-end storage
      "x-timestamp": sessionStorage.getItem("x-timestamp"),
      "X-signature": sessionStorage.getItem("x-signature"),
    };
    $.ajax({
      url: "./api/callAPIVClaimKunjungan_POST.php", // The URL to send the data to
      type: "POST", // The HTTP method to use
      data: formData, // The serialized form data
      success: function (response) {
        console.log("Sukses Generated");
      },
      error: function (xhr, status, error) {
        // Handle errors
        console.error("Error submitting form:", error);
        alert("There was an error submitting the form.");
      },
    });
  }

  // postDataSEP();
  fetchDataDashboardKunjunganRI();
  fetchDataDashboardKunjunganRJ();
  // fetchDataDashboardKlaim();
  // fetchDataDashboardWaktu();
  //   setInterval(fetchDataDashboardKunjungan,3000);

  $("#myForm").on("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Check if the form is valid
    if (this.checkValidity() === false) {
      // If the form is not valid, show the validation messages
      $(this).addClass("was-validated");
    } else {
      // If the form is valid, proceed with AJAX submission
      var formData = $(this).serialize(); // Serialize form data

      $.ajax({
        url: "./api/generate-headers.php", // The URL to send the data to
        type: "POST", // The HTTP method to use
        data: formData, // The serialized form data
        success: function (response) {
          // Handle a successful response
          alert("Form submitted successfully!");
          // You could also reset the form or redirect the user here
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.error("Error submitting form:", error);
          alert("There was an error submitting the form.");
        },
      });
    }
  });
});
