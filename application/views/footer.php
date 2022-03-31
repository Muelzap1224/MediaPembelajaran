<footer class="footer-area p_60">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 ">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Tentang Kami</h6>
                    <ul class="list">
                        <li><a href="#">Tentang Sekolah</a></li>
                        <li><a href="#">Materi </a></li>
                        <li><a href="#">Kontak Sekolah</a></li>
                        <li><a href="http://sdmuhprambanan.sch.id/">Website Resmi Sekolah</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Masuk - Sign in</h6>
                    <ul class="list">
                        <li><a href="<?php echo  site_url('welcome/murid') ?>">Untuk Siswa</a></li>
                        <li><a href="<?php echo  site_url('welcome/guru') ?>">Untuk Guru</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Pelajaran - Materi</h6>
                    <ul class="list">

                        <li><a href="<?php echo  site_url('Welcome/murid') ?>">Bahasa Arab</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="single-footer-widget tp_widgets">
                    <h6 class="footer_title">Tentang Developer</h6>
                    <ul class="list">
                        <li><a href="https://www.itda.ac.id/itda/"> Mahasiswa ITDA</li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="row footer-bottom d-flex justify-content-between align-items-center">
            <p class="col-lg-8 col-md-8 footer-text m-0">
</a> Media Pembelajaran is made with  by <a href="https://www.facebook.com/profile.php?id=100004445748178">Muhammad Zainal Arifin Pohan </a> with MIT License
            
            </p>
            <div class="col-lg-4 col-md-4 footer-social">
                <!-- <a href="https://www.facebook.com/syaaauqi"><i class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/syaaauqi"><i class="fa fa-twitter"></i></a>
                <a href="https://dribbble.com/syaufy"><i class="fa fa-dribbble"></i></a>
                <a href="https://www.behance.net/syaufy"><i class="fa fa-behance"></i></a>
                <a href="https://www.github.com/syauqi"><i class="fa fa-github"></i></a>
                <a href="https://www.instagram.com/syaufy"><i class="fa fa-instagram"></i></a>
            </div>-->
            </div>
        </div>
</footer>

<!--================ End footer Area  =================-->
<!-- Bootstrap 5 CSS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>



<script>
    var animateButton = function(e) {
        e.preventDefault;
        e.target.classList.remove('animate');
        e.target.classList.add('animate');
        setTimeout(function() {
            e.target.classList.remove('animate');
        }, 700);
    };

    var bubblyButtons = document.getElementsByClassName("bubbly-button");

    for (var i = 0; i < bubblyButtons.length; i++) {
        bubblyButtons[i].addEventListener('click', animateButton, false);
    }
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>



</body>

</html>