<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-4 layout-spacing">
                <div class="infobox-3 bg-white" style="width: 100%;">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                    </div>
                    <h5 class="info-heading"><?= $guru->nama_guru; ?></h5>

                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-group">
                                <li class="list-group-item bg-primary light text-center">Kelas Saya</li>
                                <?php foreach ($kelas as $kel) : ?>
                                    <li class="list-group-item" <?= $kel->id_kelas; ?>><?= $kel->nama_kelas; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-group">
                                <li class="list-group-item bg-primary light text-center">Mapel Saya</li>
                                <?php foreach ($mapel as $kel) : ?>
                                    <li class="list-group-item" <?= $kel->id_mapel; ?>><?= $kel->nama_mapel; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 layout-spacing">
                <div class="widget widget-five infobox-3" style="width: 100%; padding: 10px;">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h5 class="info-heading mt-4 text-center">Jumlah Siswa</h5>
                    <div class="widget-content">
                        <div class="w-content" style="padding: 0;">
                            <div class="">
                                <p class="task-left"><?= count($siswa); ?></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 layout-spacing">
                <div class="widget widget-five infobox-3" style="width: 100%; padding: 10px;">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <h5 class="info-heading mt-4 text-center">Jumlah Kelas</h5>
                    <div class="widget-content">
                        <div class="w-content" style="padding: 0;">
                            <div class="">
                                <p class="task-left"><?= count($kelas); ?></p>

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