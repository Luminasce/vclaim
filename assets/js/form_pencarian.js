// Function to initialize the DataTable
function initializeTable() {
    return $('#identitasTable').DataTable({
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all"
        }],
        columns: [
            { title: "No" },
            { title: "No Kunjungan" },
            { title: "Tanggal Kunjungan" },
            { title: "No Kartu" },
            { title: "Nama" },
            { title: "PPK Perujuk" },
            { title: "Sub Spesialis" }
        ]
    });
}

// Function to handle the search button click
function handleSearchButtonClick() {
    console.log("Search button clicked");

    var $cariButton = $('#cari');
    $cariButton.prop('disabled', true); // Disable the button to prevent multiple clicks

    var formData = {
        "x-cons-id": sessionStorage.getItem("x-cons-id"),
        "x-timestamp": sessionStorage.getItem("x-timestamp"),
        "X-signature": sessionStorage.getItem("x-signature")
    };

    console.log("FormData:", formData);

    $.ajax({
        url: "./api/callAPIVClaimRujukan.php",
        type: "GET",
        data: formData,
        success: function(response) {
            console.log("Response Rujukan:", response);

            var table = $('#identitasTable').DataTable();
            table.clear();

            if (response.data.rujukan && response.data.rujukan.length > 0) {
                response.data.rujukan.forEach(function(item, index) {
                    table.row.add([
                        index + 1,
                        item.noKunjungan,
                        item.tglKunjungan,
                        item.peserta.noKartu,
                        item.peserta.nama,
                        item.ppkPerujuk,
                        item.subSpesialis
                    ]);
                });
            } else {
                table.row.add([
                    '',
                    'No Data Available',
                    '',
                    '',
                    '',
                    '',
                    ''
                ]);
            }

            table.draw();
        },
        error: function(xhr, status, error) {
            console.error("Error submitting form:", xhr, status, error);
            alert("There was an error submitting the form.");
        },
        complete: function() {
            $cariButton.prop('disabled', false); // Re-enable the button after the request completes
        }
    });
}

// Initialize DataTable when the document is ready
$(document).ready(function() {
    initializeTable();
});

// Bind the click event to the button
$('#cari').on('click', function() {
    handleSearchButtonClick();
});
