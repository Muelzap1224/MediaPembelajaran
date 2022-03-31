<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-12 layout-spacing">
                <div class="widget shadow p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-heading">
                                <h5 class="">Siswa</h5>
                                <a href="javascript:void(0)" class="btn btn-primary mt-3" data-toggle="modal" data-target="#tambah_siswa">Tambah Siswa</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-primary mt-3 ml-2" data-toggle="modal" data-target="#import_siswa">Import Exel</a> -->
                            </div>
                            <div class="table-responsive">
                                <table id="datatable-table" class="table text-center text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No Induk</th>
                                            <th>Nama</th>

                                            <th>Kelas</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($siswa as $s) : ?>
                                            <tr>
                                                <td><?= $s->no_induk_siswa; ?></td>
                                                <td><?= $s->nama_siswa; ?></td>

                                                <td>
                                                    <?php foreach ($kelas as $kel) : ?>
                                                        <?php if ($kel->id_kelas == $s->id_kelas) : ?>
                                                            <?= $kel->nama_kelas; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td>

                                                    <a href="<?= base_url('guru/hapus_siswa/') . encrypt_url($s->id_siswa); ?>" class="btn btn-danger btn-hapus">
                                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-wrapper">
        <div class="footer-section f-section-1">
            <p class="">Copyright © 2021 <a target="_blank" href="https://www.itda.ac.id/itda/">ITDA</a>, All rights reserved. <a href="https://freepik.com" target="_blank" class="text-primary">Illustration by Freepik</a></p>
        </div>
        <div class="footer-section f-section-2">
            <p class="">ITDA</p>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<!-- MODAL -->
<!-- Modal Tambah -->
<div class="modal fade" id="tambah_siswa" tabindex="-1" role="dialog" aria-labelledby="tambah_siswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambah_siswaLabel">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <a href="javascript:void(0)" class="btn btn-success mb-3 tambah-baris-siswa">tambah baris</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Password</th>
                                <th>Gender</th>
                                <th>Kelas</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-siswa">
                            <tr>
                                <td><input type="text" name="nis[]" required style="border: none; background: transparent; width: 100%; height: 100%;"></td>
                                <td><input type="text" name="nama_siswa[]" required style="border: none; background: transparent; width: 100%; height: 100%;"></td>
                                <td><input type="text" name="password[]" required style="border: none; background: transparent; width: 100%; height: 100%;"></td>
                                <td>
                                    <select name="jenis_kelamin[]" required style="border: none; background: transparent; width: 100%; height: 100%;">
                                        <option value="">pilih</option>
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>

                                <td>
                                    <select name="id_kelas[]" required style="border: none; background: transparent; width: 100%; height: 100%;">
                                        <option value="">pilih</option>
                                        <?php foreach ($kelas as $kel) : ?>
                                            <option value="<?= $kel->id_kelas; ?>"><?= $kel->nama_kelas; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="reset" value="reset" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    <?= $this->session->flashdata('pesan'); ?>
</script>
<script>
    <?php
    if (!empty($_GET['pesan'])) : ?>
        swal({
            title: 'Berhasil!',
            text: 'Siswa telah ditambahkan',
            type: 'success',
            padding: '2em'
        });
    <?php endif; ?>
</script>