<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-lg-12 layout-spacing">
                <div class="widget shadow">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="widget-heading text-center">
                                <h5 class="text-center">My Profile</h5>
                                <img src="<?= base_url('assets/app-assets/user/') . $guru->avatar; ?>" class="img-thumbnail mt-2" width="200px" alt="">
                                <h6 class="mt-2"><?= $guru->nama_guru; ?></h6>
                                <p style="margin-top: -3px;">GURU SD Muh Prambanan</p>
                                <div class="d-flex justify-content-center text-center">
                                    <table cellpadding="2" class="text-center">
                                        <tr>
                                            <td>Date Created :</td>
                                            <td><?= date('d-M-Y', $guru->date_created); ?></td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <table cellpadding="2" class="mt-3 text-center">
                                        <tr>
                                            <td colspan="2">OPSI</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="javasript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#edit_profile">Upadete Profile</a>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="<?= base_url('assets/app-assets/img/'); ?>profile-guru.svg" class="align-middle" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrapper">
        <div class="footer-section f-section-1">
            <p class="">Copyright © 2021 <a target="_blank" href="https://www.itda.ac.id/itda/" class="text-primary">ITDA</a></p>
        </div>
        <div class="footer-section f-section-2">
            <p class="">ITDA</p>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<!-- MODAL -->
<!-- Modal Update Profile -->


<!-- Modal Update Password -->
<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="edit_profileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_profileLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        x
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama_guru" id="nama_guru" value="<?= $guru->nama_guru; ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="avatar" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" value="reset" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END MODAL -->
<script>
    <?= $this->session->flashdata('pesan'); ?>
</script>