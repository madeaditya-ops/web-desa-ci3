<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Desa Blahbatuh</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/admin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/admin/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= base_url('assets/admin/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

    <!-- Logo icon -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/image/logo_desa_blahbatuh.png'); ?>">

    <!-- Sweet Alert -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
.toast-notif {
    position: fixed;
    right: 20px;
    bottom: 20px;
    background: #1cc88a;
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,.2);
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    z-index: 9999;
    min-width: 250px;
}

.toast-notif.show {
    opacity: 1;
    transform: translateY(0);
}
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    