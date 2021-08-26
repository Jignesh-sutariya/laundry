<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<?= link_tag('assets/images/favicon.png', 'png', 'image/x-icon') ?>
		<?= link_tag('assets/images/favicon.png', 'icon', 'image/x-icon') ?>
		<title> <?= APP_NAME . ' | ' . ucfirst($title) ?> </title>
		<!-- Google font-->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
		<!-- Required Fremwork -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('bootstrap/dist/css/bootstrap.min.css') ?>">
		<!-- themify-icons line icon -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('icon/themify-icons/themify-icons.css') ?>">
		<!-- Font Awesome -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('icon/font-awesome/css/font-awesome.min.css') ?>">
		<!-- ico font -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('icon/icofont/css/icofont.css') ?>">
		<!-- feather Awesome -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('icon/feather/css/feather.css') ?>">
		<?php if (isset($dataTable)) : ?>
		<!-- Data Table Css -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= b_asset('pages/data-table/css/buttons.dataTables.min.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= b_asset('datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>">
		<?php endif ?>
		<!-- Notification.css -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('pages/notification/notification.css') ?>">
		<!-- Animate.css -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('animate.css/animate.css') ?>">
		<!-- sweet alert framework -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('css/sweetalert.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= b_asset('css/component.css') ?>">
		<!-- Switch component css -->
		<link rel="stylesheet" type="text/css" href="<?= b_asset('switchery/dist/switchery.min.css') ?>">
		<link rel="stylesheet" href="<?= b_asset('select2/dist/css/select2.min.css') ?>" />
		<link rel="stylesheet" type="text/css"
			href="<?= b_asset('bootstrap-multiselect/dist/css/bootstrap-multiselect.css') ?>" />
			<link rel="stylesheet" type="text/css" href="<?= b_asset('multiselect/css/multi-select.css') ?>" />
			
			<!-- Style.css -->
			<link rel="stylesheet" type="text/css" href="<?= b_asset('css/style.css') ?>">
			<link rel="stylesheet" type="text/css" href="<?= b_asset('css/jquery.mCustomScrollbar.css') ?>">
		</head>
		<body>
			<!-- Pre-loader start -->
			<div class="theme-loader">
				<div class="ball-scale">
					<div class='contain'>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
						<div class="ring">
							<div class="frame"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- Pre-loader end -->
			<div id="pcoded" class="pcoded">
				<div class="pcoded-overlay-box"></div>
				<div class="pcoded-container navbar-wrapper">
					<nav class="navbar header-navbar pcoded-header">
						<div class="navbar-wrapper">
							<div class="navbar-logo">
								<a class="mobile-menu" id="mobile-collapse" href="javascript:void(0);">
									<i class="feather icon-menu"></i>
								</a>
								<?= anchor(admin(), APP_NAME) ?>
								<a class="mobile-options">
									<i class="feather icon-more-horizontal"></i>
								</a>
							</div>
							<div class="navbar-container">
								<ul class="nav-left">
									<li>
										<a href="javascript:void(0);" onclick="javascript:toggleFullScreen()">
											<i class="feather icon-maximize full-screen"></i>
										</a>
									</li>
								</ul>
								<ul class="nav-right">
									<li class="user-profile header-notification">
										<div class="dropdown-primary dropdown">
											<div class="dropdown-toggle" data-toggle="dropdown">
												<?= img(['src' => 'assets/images/profile.jpg', 'class' => "img-radius"]) ?>
												<span><?= auth()->name ?></span>
												<i class="feather icon-chevron-down"></i>
											</div>
											<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
												<li>
													<?= anchor(admin('profile'), '<i class="feather icon-user"></i> Profile') ?>
												</li>
												<li>
													<?= anchor(admin('logout'), '<i class="feather icon-log-out"></i> Logout', 'onclick="script.logout(); return false;" id="logout"') ?>
												</li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</nav>
					<!-- Sidebar inner chat end-->
					<div class="pcoded-main-container">
						<div class="pcoded-wrapper">
							<nav class="pcoded-navbar">
								<div class="pcoded-inner-navbar main-menu">
									<div class="pcoded-navigatio-lavel">Navigation</div>
									<ul class="pcoded-item pcoded-left-item">
										<li class="<?= (in_array($name, ['dashboard', 'profile'])) ? 'active' : '' ?>">
											<?= anchor(admin(), '<span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span>') ?>
										</li>
										<li class="<?= ($name == 'order') ? 'active' : '' ?>">
											<?= anchor(admin('order'), '<span class="pcoded-micon"><i class="fa fa-file-text-o"></i></span><span class="pcoded-mtext">Completed Orders</span>') ?>
										</li>
										<li class="pcoded-hasmenu <?= (in_array($name, ['category', 'item', 'subCategory'])) ? 'pcoded-trigger' : '' ?>">
											<a href="javascript:void(0)">
												<span class="pcoded-micon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
												<span class="pcoded-mtext">Item(s)</span>
											</a>
											<ul class="pcoded-submenu">
												<li class="<?= ($name == 'item') ? 'active' : '' ?>">
													<?= anchor(admin('item'), '<span class="pcoded-mtext">Item(s)</span>') ?>
												</li>
												<li class="<?= ($name == 'subCategory') ? 'active' : '' ?>">
													<?= anchor(admin('subCategory'), '<span class="pcoded-mtext">Sub Category</span>') ?>
												</li>
												<li class="<?= ($name == 'category') ? 'active' : '' ?>">
													<?= anchor(admin('category'), '<span class="pcoded-mtext">Category</span>') ?>
												</li>
											</ul>
										</li>
										<li class="<?= ($name == 'banner') ? 'active' : '' ?>">
											<?= anchor(admin('banner'), '<span class="pcoded-micon"><i class="fa fa-image"></i></span><span class="pcoded-mtext">Banner</span>') ?>
										</li>
										<li class="<?= ($name == 'user') ? 'active' : '' ?>">
											<?= anchor(admin('user'), '<span class="pcoded-micon"><i class="fa fa-user"></i></span><span class="pcoded-mtext">Users</span>') ?>
										</li>
										<li class="<?= ($name == 'deliveryBoy') ? 'active' : '' ?>">
											<?= anchor(admin('deliveryBoy'), '<span class="pcoded-micon"><i class="fa fa-user"></i></span><span class="pcoded-mtext">Delivery Boy</span>') ?>
										</li>
										<li class="pcoded-hasmenu <?= (in_array($name, ['contact', 'shopAddress'])) ? 'pcoded-trigger' : '' ?>">
											<a href="javascript:void(0)">
												<span class="pcoded-micon"><i class="fa fa-address-card-o" aria-hidden="true"></i></span>
												<span class="pcoded-mtext">Shop Address</span>
											</a>
											<ul class="pcoded-submenu">
												<li class="<?= ($name == 'contact') ? 'active' : '' ?>">
													<?= anchor(admin('contact'), '<span class="pcoded-mtext">Contact US</span>') ?>
												</li>
												<li class="<?= ($name == 'shopAddress') ? 'active' : '' ?>">
													<?= anchor(admin('address'), '<span class="pcoded-mtext">Shop Address</span>') ?>
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</nav>
							<div class="pcoded-content">
								<div class="pcoded-inner-content">
									<!-- Main-body start -->
									<div class="main-body">
										<div class="page-wrapper">
											<!-- Page-header start -->
											<div class="page-header">
												<div class="row align-items-end">
													<div class="col-lg-8">
														<div class="page-header-title">
															<div class="d-inline">
																<h4><?= ucwords($title) ?></h4>
															</div>
														</div>
													</div>
													<div class="col-lg-4">
														<div class="page-header-breadcrumb">
															<ul class="breadcrumb-title">
																<li class="breadcrumb-item" style="float: left;">
																	<?= anchor(admin(), '<i class="feather icon-home"></i>') ?>
																</li>
																<?php if (!isset($operation)) : ?>
																<li class="breadcrumb-item" style="float: left;">
																	<a href="javascript:void(0);"><?= ucwords($title) ?></a>
																</li>
																<?php else : ?>
																<li class="breadcrumb-item" style="float: left;">
																	<?= anchor($url, ucwords($title)) ?>
																</li>
																<li class="breadcrumb-item" style="float: left;">
																	<?= ucwords($operation) ?>
																</li>
																<?php endif ?>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<div class="page-body">
												<div class="row">
													<?= $contents ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="common-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"></h4>
							<button type="button" class="close"
							data-dismiss="modal"
							aria-label="Close">
							<span
							aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer">
							<?= form_button([
							'content' => 'Close',
							'type'  => 'button',
							'data-dismiss' => "modal",
							'class' => 'btn btn-outline-danger btn-round col-2'
							]) ?>
							<?= form_button([
							'content' => 'Save',
							'onclick' => 'saveData()',
							'type'  => 'submit',
							'class' => 'btn btn-outline-info btn-round col-2'
							]) ?>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" id="base_url" value="<?= base_url() ?>" />
			<script src="<?= b_asset('jquery/dist/jquery.min.js') ?>"></script>
			<script src="<?= b_asset('jquery-ui/jquery-ui.min.js') ?>"></script>
			<script src="<?= b_asset('popper.js/dist/umd/popper.min.js') ?>"></script>
			<script src="<?= b_asset('bootstrap/dist/js/bootstrap.min.js') ?>"></script>
			<!-- jquery slimscroll js -->
			<script src="<?= b_asset('jquery-slimscroll/jquery.slimscroll.js') ?>"></script>
			<!-- modernizr js -->
			<script src="<?= b_asset('modernizr/modernizr.js') ?>"></script>
			<script src="<?= b_asset('modernizr/feature-detects/css-scrollbars.js') ?>"></script>
			<?php if (isset($dataTable)) : ?>
			<input type="hidden" id="dataTableUrl" value="<?= base_url($url) ?>" />
			<!-- data-table js -->
			<script src="<?= b_asset('datatables.net/js/jquery.dataTables.min.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
			<script src="<?= b_asset('pages/data-table/js/jszip.min.js') ?>"></script>
			<script src="<?= b_asset('pages/data-table/js/pdfmake.min.js') ?>"></script>
			<script src="<?= b_asset('pages/data-table/js/vfs_fonts.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
			<script src="<?= b_asset('pages/data-table/js/dataTables.bootstrap4.min.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-buttons/js/buttons.colVis.js') ?>"></script>
			<script src="<?= b_asset('datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') ?>"></script>
			<script src="<?= b_asset('js/datatable-custom.js') ?>"></script>
			<?php endif ?>
			<script src="<?= b_asset('js/bootstrap-growl.min.js') ?>"></script>
			<script src="<?= b_asset('pages/notification/notification.js') ?>"></script>
			<!-- sweet alert js -->
			<script src="<?= b_asset('js/sweetalert.js') ?>"></script>
			<!-- Switch component js -->
			<script src="<?= b_asset('switchery/dist/switchery.min.js') ?>"></script>
			<script src="<?= b_asset('select2/dist/js/select2.full.min.js') ?>"></script>
			<script type="text/javascript"
			src="<?= b_asset('bootstrap-multiselect/dist/js/bootstrap-multiselect.js') ?>"></script>
			<script type="text/javascript" src="<?= b_asset('multiselect/js/jquery.multi-select.js') ?>"></script>
			<script src="<?= b_asset('js/jquery.quicksearch.js') ?>"></script>
			<script src="<?= b_asset('pages/advance-elements/select2-custom.js') ?>"></script>
			<!-- Custom js -->
			<script src="<?= b_asset('js/pcoded.min.js') ?>"></script>
			<script src="<?= b_asset('js/vartical-layout.min.js') ?>"></script>
			<script src="<?= b_asset('js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
			<script src="<?= b_asset('ckeditor/ckeditor.js') ?>"></script>
			<script src="<?= b_asset('js/script.js') ?>"></script>
			<?php if (isset($refresh)): ?>
			<script>
				setInterval(function(){ 
                    table.ajax.reload();
                }, 1000 * 60);
			</script>
			<?php endif ?>
		</body>
	</html>