<!DOCTYPE html>
<html lang="en">

<head>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Bahasa
	</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/logo.png') ?>">

	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">


	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/responsive.css') ?>">

	<!-- Scripts -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


</head>

<body>


	<header class="header_area">

		<div style="background-color:#ffd480;" class="top_menu row m0">

			<div class="container">
				<div class="float-left">
					<ul class="list header_social">
						<li><a href="https://web.facebook.com/dmuhpramb.dmuhpramb"><i class="fab fa-facebook"></i></a></li>
						<li><a href="https://api.whatsapp.com/send?phone=62(82161303614)&text=Assalamualaikum Mr saya ingin bertanya mengenai plajaran Bahasa Arab"><i class="fab fa-whatsapp"></i></li>
						<li><a href="0274 – 496171"><i class="fas fa-phone"></i></a></li>
						<li><a href="https://www.instagram.com/sdmuhpramb_official/"><i class="fab fa-instagram"></i></a></li>
						<li><a href="https://www.youtube.com/c/SDMuhammadiyahPrambanan/videos"><i class="fab fa-youtube"></i></a></li>

					</ul>
				</div>

			</div>
		</div>

		<nav class="alert ">

			<div class="container">
				<ul class=" nav nav-pills nav-fill">

					<a class="navbar-brand" href="#">
						<img src="<?php echo base_url('assets/img/logo.png') ?>" alt="" width="50" height="54" class="d-inline-block align-top">
					</a>
					<li class="nav-item">
						<a class="nav-link " aria-current="page" href="http://localhost/pembelajaran">Beranda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo  site_url('Welcome/kontak') ?>">Kontak</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo  site_url('Welcome/pelajaran') ?>">Pelajaran</a>
					</li>
					<style type="text/css">
						.dropdown:hover>.dropdown-menu,
						.dropright:hover>.dropdown-menu {
							display: block;

						}
					</style>
					<li class="nav-item dropdown ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Masuk</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
							<a class="dropdown-item " href="<?php echo  site_url('Welcome/guru') ?>">Guru</a>
							<a class="dropdown-item " href="<?php echo  site_url('Welcome/murid') ?>">Murid</a>

						</div>
					</li>
				</ul>
			</div>
		</nav>

	</header>