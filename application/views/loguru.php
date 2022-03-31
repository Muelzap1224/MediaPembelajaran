<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/img-01.jpg');">
            <div class="wrap-login100 p-t-190 p-b-30">
                <form class="login100-form validate-form" method="POST" action="">
                    <div class="login100-form-avatar">
                        <img src="<?php echo base_url('assets/img/say.png') ?>" alt="AVATAR">
                    </div>

                    <span class="login100-form-title p-t-20 p-b-45">
                        Welcome Guru
                    </span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <?= $this->session->flashdata('message'); ?>
                        <input class="input100" type="text" name="nama" placeholder="masukkan nama anda">
                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="masukkan password anda">

                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn" type="submit">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>