<!DOCTYPE html>
<html lang="en">

<?php require './header2.php' ?>

<body>


    <div class="page-container">
        <?php require './sidebar.php'; ?>
        <div class="main-content">
            <?php require './navbar.php' ?>

            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">
                    <div class="box">
                        <div class="container mt-5">
                            <h2>Surat Eligibilitas Peserta</h2>
                            <div class="card mb-3">
                                <div class="row no-gutters">
                                    <div class="col-md-4 text-center p-3">
                                        <img id="profile-picture" src="https://via.placeholder.com/150" class="img-fluid rounded-circle mb-3" alt="Profile Picture">
                                        <h5 id="participant-name"></h5>
                                        <p id="participant-noRujukan"></p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <p class="card-text"><i class="fas fa-id-card"></i><span id="nik"></span> </p>
                                            <p class="card-text"><i class="fas fa-calendar-alt"></i> <span id="birthdate"></span></p>
                                            <p class="card-text"><i class="fas fa-user"></i> <span id="pisa"></span></p>
                                            <p class="card-text"><i class="fas fa-home"></i> <span id="hak_kelas"></span></p>
                                            <p class="card-text"><i class="fas fa-hospital"></i> <span id="perujuk_nama"></span></p>
                                            <p class="card-text"><i class="fas fa-calendar"></i> <span id="tmt_tat"></span></p>
                                            <p class="card-text"><i class="fas fa-briefcase"></i> <span id="jenis_peserta"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="process.php" method="post">
                                <div class="form-group">
                                    <label for="spesialis">Spesialis/SubSpesialis *</label>
                                    <input type="text" id="spesialis" name="spesialis" class="form-control" placeholder="JANTUNG DAN PEMBULUH DARAH" required>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="eksekutif" name="eksekutif">
                                        <label class="form-check-label" for="eksekutif">Eksekutif</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dpjp">DPJP yang Melayani *</label>
                                    <input type="text" id="dpjp" name="dpjp" class="form-control" placeholder="ketik nama dokter DPJP yang melayani" required>
                                </div>

                                <div class="form-group">
                                    <label for="asal_rujukan">Asal Rujukan *</label>
                                    <select id="asal_rujukan" name="asal_rujukan" class="form-control" required>
                                        <option value="Faskes Tingkat 1">Faskes Tingkat 1</option>
                                        <!-- Add other options here -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="ppk_asal_rujukan">PPK Asal Rujukan *</label>
                                    <input type="text" id="ppk_asal_rujukan" name="ppk_asal_rujukan" class="form-control" placeholder="Pakis" required>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_rujukan">Tgl. Rujukan (yyyy-mm-dd) *</label>
                                    <input type="date" id="tgl_rujukan" name="tgl_rujukan" readonly class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="no_rujukan">No. Rujukan *</label>
                                    <input type="text" id="no_rujukan" name="no_rujukan" class="form-control" placeholder="13011604524Y000388" required>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_sep">Tgl. SEP (yyyy-mm-dd) *</label>
                                    <input type="date" id="tgl_sep" name="tgl_sep" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="no_mr">No. MR *</label>
                                    <input type="text" id="no_mr" name="no_mr" class="form-control" placeholder="100277600" required>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="peserta_cob" name="peserta_cob">
                                        <label class="form-check-label" for="peserta_cob">Peserta COB</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="diagnosa">Diagnosa *</label>
                                    <input type="text" id="diagnosa" name="diagnosa" class="form-control" placeholder="Hypertensive heart disease with (congestive) heart failure" required>
                                </div>

                                <div class="form-group">
                                    <label for="no_telepon">No. Telepon *</label>
                                    <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="087759813993" required>
                                </div>

                                <div class="form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea id="catatan" name="catatan" class="form-control" placeholder="ketik catatan apabila ada"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status_kecelakaan">Status Kecelakaan *</label>
                                    <select id="status_kecelakaan" name="status_kecelakaan" class="form-control" required>
                                        <option value="">-- Silahkan Pilih --</option>
                                        <!-- Add other options here -->
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Parse query string parameters
            var urlParams = new URLSearchParams(window.location.search);

            // Fungsi untuk memformat tanggal menjadi yyyy-mm-dd
            function formatDate(dateString) {
                var date = new Date(dateString);
                var year = date.getFullYear();
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                var day = ('0' + date.getDate()).slice(-2);
                return `${year}-${month}-${day}`;
            }



            console.log("<pre>")
            console.log("Document ", urlParams);
            // Populate form fields with query string data
            $('#participant-name').text(`${urlParams.get('peserta[nama]')}`);
            console.log("after")

            $('#participant-noRujukan').text(` ${urlParams.get('peserta[noKartu]')}`);
            $('#nik').text(` ${urlParams.get('peserta[nik]')}`);
            $('#birthdate').text(` ${urlParams.get('peserta[tglLahir]')}`);
            $('#pisa').text(urlParams.get('peserta[pisa]') === '1' ? 'Peserta' : '');
            $('#hak_kelas').text(`${urlParams.get('peserta[hakKelas][keterangan]')}`);
            $('#perujuk_nama').text(`${urlParams.get('provPerujuk[kode]')} - ${urlParams.get('provPerujuk[nama]')} `);
            $('#tmt_tat').text(`${urlParams.get('peserta[tglTMT]')} s.d  ${urlParams.get('peserta[tglTAT]')} `);
            $('#jenis_peserta').text(`${urlParams.get('peserta[jenisPeserta][keterangan]')} `);
            // Tentukan gambar berdasarkan jenis kelamin
            var gender = urlParams.get('peserta[sex]');
            var profilePicture = $('#profile-picture');
            if (gender === "L") {
                profilePicture.attr('src', 'https://vclaim.bpjs-kesehatan.go.id/VClaim/image/male.png'); // URL gambar cowok
            } else {
                profilePicture.attr('src', 'https://vclaim.bpjs-kesehatan.go.id/VClaim/image/female.png'); // URL gambar cewek
            }

            var tglKunjungan = urlParams.get('tglKunjungan');
            console.log("Original tglKunjungan:", tglKunjungan); // Log original date
            var formattedDate = formatDate(tglKunjungan);
            console.log("Formatted tglKunjungan:", formattedDate); // Log formatted date
            $("#spesialis").val(urlParams.get('poliRujukan[nama]'));
            $("#ppk_asal_rujukan").val(`${urlParams.get('provPerujuk[nama]')}`);
            $("#tgl_rujukan").val(formattedDate);
            // peserta[jenisPeserta][keterangan]
            // $('#eksekutif').prop('checked', urlParams.get('eksekutif') === 'true');
            // $('#dpjp').val(urlParams.get('nmDpjp'));
            // $('#asal_rujukan').val(urlParams.get('asalRujukan'));
            // $('#ppk_asal_rujukan').val(urlParams.get('ppkRujukan.nmProvider'));
            // $('#tgl_rujukan').val(urlParams.get('tglKunjungan'));
            // $('#no_rujukan').val(urlParams.get('noRujukan'));
            // $('#tgl_sep').val(urlParams.get('tglSep'));
            // $('#no_mr').val(urlParams.get('noMr'));
            // $('#diagnosa').val(urlParams.get('diagnosa.kdDiag'));
            // $('#no_telepon').val(urlParams.get('peserta.noTelp'));
            // $('#catatan').val(urlParams.get('catatan'));
            // $('#status_kecelakaan').val(urlParams.get('kdStatusKecelakaan'));
        });
    </script>
    <!-- jQuery -->
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <?php require './footerscript.php' ?>

</body>

</html>