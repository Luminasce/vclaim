<!DOCTYPE html>
<html lang="en">

<?php require './header2.php'; ?>

<body>


    <div class="page-container">

        <?php require './sidebar.php'; ?>
        <div class="main-content">
            <?php require './navbar.php' ?>


            <div class="main-content-inner">

                <div class="sales-report-area mt-5 mb-5">

                    <div class="box">

                        <h2 class="ml-2">Surat Eligibilitas Peserta</h2>
                        <form class="ml-2" action="process.php" method="post">
                            <div class="form-group">
                                <label>Pilih</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pilih" id="rujukan" value="Rujukan" checked>
                                    <label class="form-check-label" for="rujukan">Rujukan</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pilih" id="rujukan_manual_igd" value="Rujukan Manual/IGD">
                                    <label class="form-check-label" for="rujukan_manual_igd">Rujukan Manual/IGD</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tgl_sep">Tgl.SEP (yyyy-mm-dd)</label>
                                <input type="date" id="tgl_sep" name="tgl_sep" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="asal_rujukan">Asal Rujukan</label>
                                <select id="asal_rujukan" name="asal_rujukan" class="form-control" required>
                                    <?php
                                    $asal_rujukan_options = [
                                        'Faskes Tingkat 1',
                                        'Faskes Tingkat 2',
                                        'Rumah Sakit A',
                                        'Klinik B'
                                    ];
                                    foreach ($asal_rujukan_options as $option) {
                                        echo "<option value=\"$option\">$option</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="no_rujukan">No.Rujukan</label>
                                <div class="input-group">
                                    <input type="text" id="no_rujukan" name="no_rujukan" class="form-control" placeholder="ketik nomor rujukan faskes" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#noIdentitasModal">
                                            <i class="fas fa-list"></i> No.Identitas
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="noIdentitasModal" tabindex="-1" role="dialog" aria-labelledby="noIdentitasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="margin-left: 150px;margin-right: 150px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noIdentitasModalLabel">Rujukan Faskes Tingkat 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_rujukan_modal">Nomor</label>
                        <div class="input-group">
                            <input type="text" id="no_rujukan_modal" name="no_rujukan_modal" class="form-control" placeholder="ketik nomor" required>
                            <div class="input-group-append">
                                <div class="btn btn-secondary" style="padding-left:45px">
                                    <input class="form-check-input" type="radio" name="pilih_modal" id="rujukan_modal" value="NIK" checked>
                                    <label class="form-check-label" for="rujukan_modal" style="padding-right:25px; color:white">NIK(eKTP)</label>

                                    <input class="form-check-input" type="radio" name="no_kartu" id="no_kartu">
                                    <label class="form-check-label" for="no_kartu_modal" style="color:white">BPJS</label>
                                </div>
                            </div>
                            <button type="button" id="cari" class="btn btn-secondary ml-3">Cari</button>
                        </div>

                        <br>
                        <table id="identitasTable" class="table table-bordered mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">No Rujukan</th>
                                    <th scope="col">Tgl Rujukan</th>
                                    <th scope="col">No Kartu</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">PPK Perujuk</th>
                                    <th scope="col">Sub / Spesialis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table Data -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function() {
            // Cache jQuery selectors
            var $identitasTable = $('#identitasTable');
            var $no_rujukan_modal = $('#no_rujukan_modal');
            var $no_rujukan = $('#no_rujukan');
            var $modal = $('#noIdentitasModal');
            var $cariButton = $('#cari');

            // Initialize DataTable with specified options
            var table = $('#identitasTable').DataTable({
                paging: true,
                pageLength: 10, // Show 10 entries per page
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                columns: [{
                        title: "No"
                    },
                    {
                        title: "No Rujukan"
                    },
                    {
                        title: "Tanggal Rujukan"
                    },
                    {
                        title: "No Kartu"
                    },
                    {
                        title: "Nama"
                    },
                    {
                        title: "PPK Perujuk"
                    },
                    {
                        title: "Sub Spesialis"
                    }
                ]
            });

            // Event handler for search button
            $cariButton.on('click', function() {
                $cariButton.prop('disabled', true); // Disable button to prevent multiple clicks

                var formData = {
                    "x-cons-id": sessionStorage.getItem("x-cons-id"),
                    "x-timestamp": sessionStorage.getItem("x-timestamp"),
                    "X-signature": sessionStorage.getItem("x-signature"),
                    "nomor_kartu": $no_rujukan_modal.val()
                };

                $.ajax({
                    url: "./api/callAPIVClaimRujukan.php",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        console.log("Response Rujukan:", response);

                        table.clear();

                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(item, index) {
                                table.row.add([
                                    index + 1,
                                    '<button id="noRujukanBtn_' + index + '" class="no-rujukan-btn" data-rujukan="' + item.noKunjungan + '">' + item.noKunjungan + '</button>', item.tglKunjungan,
                                    item.peserta.noKartu,
                                    item.peserta.nama,
                                    item.provPerujuk.nama,
                                    item.poliRujukan.nama
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
                        console.error("Error submitting form:", error);
                        alert("There was an error submitting the form.");
                    },
                    complete: function() {
                        $cariButton.prop('disabled', false); // Re-enable button after request is complete
                    }
                });
            });

            // Event handler for the No Rujukan button clicks
            $identitasTable.on('click', '.no-rujukan-btn', function() {
                var noRujukan = $(this).data('rujukan');
                handleNoRujukanClick(noRujukan);
            });

            // Function to handle No Rujukan button click
            function handleNoRujukanClick(noRujukan) {
                // Do something with the noRujukan value, e.g., populate an input field or call another function
                console.log("No Rujukan clicked:", noRujukan);

                var formData = {
                    "x-cons-id": sessionStorage.getItem("x-cons-id"),
                    "x-timestamp": sessionStorage.getItem("x-timestamp"),
                    "X-signature": sessionStorage.getItem("x-signature"),
                    "nomor_rujukan": noRujukan
                };

                $.ajax({
                    url: "./api/callAPIVClaimRujukanDetail.php",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        console.log("Response Rujukan Detail:", response);
                        // Handle response for Rujukan Detail
                        var queryString = $.param(response.data);

                        // Open fileB.php in a new window or tab with the query string
                        window.open('formSEP.php?' + queryString, '_blank');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting form:", error);
                        alert("There was an error submitting the form.");
                    }
                });
            }
        });
    </script>


    <?php require './footerscript.php' ?>

</body>

</html>