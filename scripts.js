$(document).ready(function () {
  const fetchInterval = 180000; // 3 menit dalam milidetik
  // const fetchInterval = 1000; // 3 menit dalam milidetik



  

  /*-------------- 7 Pie chart chartjs start ------------*/
  function fetchDataDashboardKunjunganRI() {
    console.log("Fetching data Kunjungan Rawat Inap...");


    $.ajax({
      url: "./api/callAPIVClaimKunjunganRI.php", // The URL to send the data to
      type: "GET", // The HTTP method to use
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
        console.log("Batal ", xhr);
        // console.error("Error submitting form:", error);
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

  function fetchBridging() {
    console.log("Fetching data Kunjungan Rawat Jalan...");

    $.ajax({
      url: "./api/3.php", // The URL to send the data to
      type: "GET", // The HTTP method to use
      success: function (response) {
        console.log("-");
      },
      error: function (xhr, status, error) {

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
