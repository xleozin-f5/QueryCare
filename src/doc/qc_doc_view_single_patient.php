<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();

  $doc_id = $_SESSION['doc_id'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php');?>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php");?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php");?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- Get Details Of A Single User And Display Them Here -->
        <?php
            $pat_number = $_GET['pat_number'];
            $pat_id = $_GET['pat_id'];
            $ret = "SELECT * FROM his_patients WHERE pat_id = ?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $pat_id);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {
                $mysqlDateTime = $row->pat_date_joined;
        ?>
        <div class="content-page">
            <div class="content">
                <!-- Start Content -->
                <div class="container-fluid">

                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Painel</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pacientes</a></li>
                                        <li class="breadcrumb-item active">Ver Paciente</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->pat_fname . " " . $row->pat_lname; ?>'s Perfil</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->

                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/photoprofile.png" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                <div class="text-left mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Nome completo :</strong> <span class="ml-2"><?php echo $row->pat_fname . " " . $row->pat_lname; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Telefone :</strong><span class="ml-2"><?php echo $row->pat_phone; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Morada :</strong> <span class="ml-2"><?php echo $row->pat_addr; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Data de nascimento :</strong> <span class="ml-2"><?php echo $row->pat_dob; ?></span></p>                                    <hr>
                                    <p class="text-muted mb-2 font-13"><strong>Conta Criada em :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:i", strtotime($mysqlDateTime)); ?></span></p>
                                    <hr>
                                </div>
                            </div> <!-- End card-box -->
                        </div> <!-- End col -->
                    </div> <!-- End row -->
                </div> <!-- End container -->
            </div> <!-- End content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php');?>
            <!-- End Footer -->
        </div> <!-- End content-page -->

        <?php
            } // End while loop
        ?>

    </div> <!-- End wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>
</html>
