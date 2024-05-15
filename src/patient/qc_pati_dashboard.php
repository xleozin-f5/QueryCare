<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$pat_id=$_SESSION['pat_id'];
$pat_number = $_SESSION['pat_number'];

?>
<!DOCTYPE html>
<html lang="en">

<!--Head Code-->
<?php include("assets/inc/head.php");?>

<body>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- Topbar Start -->
        <?php include('assets/inc/nav.php');?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include('assets/inc/sidebar.php');?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">

                                <h4 class="page-title">QueryCare - Painel do Paciente</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Patient Information -->
                        <div class="col-xl-6">
                            <div class="card-box">
                                <h4 class="header-title mb-3">Informações do Paciente</h4>
                                <!-- Exibir informações do paciente -->
                                <p>ID do Paciente: <?php echo $pat_number; ?></p>
                                <!-- Você pode adicionar mais informações do paciente aqui -->
                            </div>
                        </div>
                        <!-- end Patient Information -->
                    </div>

                    <div class="row">
                        <!-- Adicionar mais seções para recursos ou informações do paciente aqui -->
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php');?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <!-- Conteúdo da barra lateral direita -->
    </div>
    <!-- /Right-bar -->
    <!-- Overlay da barra lateral direita-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Plugins js-->
    <!-- Incluir plugins ou scripts adicionais conforme necessário -->

    <!-- App js-->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
