<!doctype html>

<html
    lang="en"
    class="layout-wide customizer-hide"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="<?= base_url('assets/admin/')?>/assets/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Login Admin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/admin/')?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Vendor -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/')?>/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js. -->
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/js/template-customizer.js"></script>

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?= base_url('assets/admin/')?>/assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card p-md-7 p-1">
                 

                    <div class="card-body mt-1">
                        <h4 class="mb-1">Selamat datang di Sistem Informasi</h4>
                        <p class="mb-5">Untuk memulai Silakan Masukan username dan password anda terlebih dahulu</p>
                        <?= $this->req->flash()?>
                        <form id="formAuthentication" class="mb-5" action="<?= base_url('admin/login/aksi')?>" method="POST">
                            <div class="form-floating form-floating-outline mb-5 form-control-validation">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username anda disiini" autofocus />
                                <label for="username">Username</label>
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle form-control-validation">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input
                                                type="password"
                                                id="password"
                                                class="form-control"
                                                name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <label for="password">Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-5">
                                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                            </div>
                        </form>

                        
                    </div>
                </div>
                <!-- /Login -->
                <img
                    alt="mask"
                    src="<?= base_url('assets/admin/')?>/assets/img/illustrations/auth-basic-login-mask-light.png"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="illustrations/auth-basic-login-mask-light.png"
                    data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/pickr/pickr.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/hammer/hammer.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/i18n/i18n.js"></script>

    <script src="<?= base_url('assets/admin/')?>/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="<?= base_url('assets/admin/')?>/assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->

    <script src="<?= base_url('assets/admin/')?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url('assets/admin/')?>/assets/js/pages-auth.js"></script>
</body>

</html>