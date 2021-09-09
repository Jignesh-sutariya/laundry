<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <?= link_tag('assets/images/favicon.png', 'png', 'image/x-icon') ?>
        <?= link_tag('assets/images/favicon.png', 'icon', 'image/x-icon') ?>
        <title> <?= APP_NAME.' | '.ucfirst($title) ?> </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= b_asset('bootstrap/dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= b_asset('icon/themify-icons/themify-icons.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= b_asset('icon/icofont/css/icofont.css') ?>">

        <!-- Notification.css -->
        <link rel="stylesheet" type="text/css" href="<?= b_asset('pages/notification/notification.css') ?>">
        <!-- Animate.css -->
        <link rel="stylesheet" type="text/css" href="<?= b_asset('animate.css/animate.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= b_asset('css/style.css') ?>">
    </head>
    <body class="fix-menu">
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
        <section class="login-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">
                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="logo.png" width="200">
                        </div>
                        <?= $contents ?>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="base_url" value="<?= base_url(admin()) ?>">
        <script src="<?= b_asset('jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?= b_asset('jquery-ui/jquery-ui.min.js') ?>"></script>
        <script src="<?= b_asset('popper.js/dist/umd/popper.min.js') ?>"></script>
        <script src="<?= b_asset('bootstrap/dist/js/bootstrap.min.js') ?>"></script>
        <script src="<?= b_asset('jquery-slimscroll/jquery.slimscroll.js') ?>"></script>
        <script src="<?= b_asset('modernizr/modernizr.js') ?>"></script>
        <script src="<?= b_asset('modernizr/feature-detects/css-scrollbars.js') ?>"></script>
        <script type="text/javascript" src="<?= b_asset('js/bootstrap-growl.min.js') ?>"></script>
        <script type="text/javascript" src="<?= b_asset('pages/notification/notification.js') ?>"></script>
        <script src="<?= b_asset('js/common-pages.js') ?>"></script>
    </body>
</html>