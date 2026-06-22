<!doctype html>


<?php


// jika belum login
if (!$this->session->userdata('id_user')) {
    $this->session->set_flashdata('warning', 'Maaf anda harus masuk terlebih dahulu');
    redirect('admin/login');
}

?>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-skin="default"
    data-bs-theme="light"
    data-assets-path="<?= base_url('assets/admin') ?>/assets/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title><?= $title ?></title>

    <meta name="description" content="" />

    <meta name="baseUrl" content="<?= base_url() ?>">
    <meta name="segment" content="<?= $this->uri->segment(3) ?>">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/admin') ?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin') ?>/assets/vendor/css/pages/page-pricing.css" />

    <!-- Helpers -->
    <script src="<?= base_url('assets/admin') ?>/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.css">


    <script src="<?= base_url('assets/admin') ?>/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'menu.php' ?>

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="ri ri-menu-line icon-base"></i>
                    <i class="ri ri-arrow-right-s-line icon-base"></i>
                </a>
            </div>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav
                    class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base ri ri-menu-line icon-22px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">


                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url('assets/admin') ?>/assets/img/avatars/1.png" alt="avatar" class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">
                                                        <img
                                                            src="<?= base_url('assets/admin') ?>/assets/img/avatars/1.png"
                                                            alt="alt"
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 small"><?= $_SESSION['nama_user'] ?></h6>
                                                    <small class="text-body-secondary">
                                                        <?php

                                                        switch ($_SESSION['level']) {
                                                            case '1':
                                                                echo "Admin";
                                                                break;

                                                            case '2':
                                                                echo "Perencanaan";
                                                                break;

                                                            case '3':
                                                                echo "Pengadaan";
                                                                break;

                                                            default:
                                                                echo "Admin";
                                                                break;
                                                        }

                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <i class="icon-base ri ri-settings-4-line icon-22px me-3"></i><span class="align-middle">Ganti Password</span>
                                        </a>
                                    </li>

                                    <li>
                                        <div class="d-grid px-4 pt-2 pb-1">
                                            <a class="btn btn-sm btn-danger d-flex" onclick="return confirm('Apakah anda yakin ingin keluar?')" href="<?= base_url('admin/logout') ?>">
                                                <small class="align-middle">Keluar</small>
                                                <i class="icon-base ri ri-logout-box-r-line ms-2 icon-16px"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="card mb-3">
                            <div class="card-header">
                                <?= $title ?>
                            </div>
                        </div>
                        <?php $this->load->view($content) ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include 'footer.php' ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->

    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('assets/admin') ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/pickr/pickr.js"></script>

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>


    <script src="<?= base_url('assets/admin') ?>/assets/vendor/libs/i18n/i18n.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- endbuild -->


    <!-- Vendors JS -->
    <script src="<?= base_url() ?>assets/extra/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/extra/datatable/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/extra/datatable/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>assets/extra/datatable/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <!-- datatbale -->

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.5/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.print.min.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('.modalna'),
                theme: 'bootstrap4',
            });
        });
        $(document).ready(function() {
            $('.select2edit').select2({
                dropdownParent: $('.modalnaedit'),
                theme: 'bootstrap4',
            });
        });

        // add datatable and with export button and show button for who has class datatabelna
        $(document).ready(function() {
            $('.datatabelna').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });

        
    </script>

    <!-- Main JS -->
    <script src="<?= base_url() ?>assets/extra/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script src="<?= base_url('assets/js/page/admin.js') ?>"></script>
    <?= (isset($script)) ? "<script src='" . base_url() . "assets/js/page/" . $script . ".js'></script>" : '' ?>
    <!-- Page JS -->

    <script src="<?= base_url('assets/admin') ?>/assets/vendor/js/menu.js"></script>

    <script src="<?= base_url('assets/admin') ?>/assets/js/main.js"></script>
</body>

</html>