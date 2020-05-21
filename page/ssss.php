<?php include "../function.php" ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/apple-icon.png') ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative Tim
    </title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no" name="viewport" />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/light-bootstrap-dashboard.css?v=2.0.0') ?> " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo base_url('assets/css/demo.css') ?>" />
    <script src="<?php echo base_url('assets/js/jquery-3.5.0.min.js') ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="<?php echo base_url('assets/css/jquery.dataTables.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/jquery.dataTables.min.css') ?>" rel="stylesheet" />
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.js') ?>"></script>
</head>

<body>

    <body>

        <div class="container">
            <table class="table" id="111">
                <thead>
                    <tr>
                        <th></th>
                        <th> Guest name</th>
                        <th>Room</th>
                        <th>Phone</th>
                        <th>Checkin</th>
                        <th>Checkout</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="22">

                    <!-- <th><button type="submit" id="Agency" class="btn btn-primary"> + info </button></th> -->
                </tbody>
            </table>
        </div>



    </body>

    <style>
        .fixposition {
            margin-top: 25px;
            margin-left: 25px;
        }
    </style>

    <script src="<?php echo base_url('application/info_checkin.js') ?>"></script>

    <!--   Core JS Files   -->
    <script src="<?php echo base_url('assets/js/core/jquery.3.2.1.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/core/popper.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js') ?>" type="text/javascript"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-switch.js') ?>"></script>
    <!--  Google Maps Plugin    -->
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.dataTables.js') ?>"></script>
    <!--  Chartist Plugin  -->
    <script src="<?php echo base_url('assets/js/plugins/chartist.min.js') ?>"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js') ?>"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="<?php echo base_url('assets/js/light-bootstrap-dashboard.js?v=2.0.0') ?> " type="text/javascript"></script>
    <!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
    <script src="<?php echo base_url('assets/js/demo.js') ?>"></script>
    <!--    Data table     -->

    <script src="<?php echo base_url('application/add_reservations.js') ?>"></script>
    <script src="<?php echo base_url('application/save_addroom.js') ?>"></script>
    <script src="<?php echo base_url('application/edit_infoguest.js') ?>"></script>

</html>