<?php
    $pat_id = $_SESSION['pat_id'];
    $ret = "SELECT * FROM his_patients WHERE pat_id = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $pat_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_object()) {
?>
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="d-none d-sm-block"></li>
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="assets/images/users/<?php echo $row->pat_dpic;?>" alt="dpic" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bem-vindo(a)!</h6>
                </div>
                <a href="qc_pati_update-account.php" class="dropdown-item notify-item">
                    <i class="fas fa-user-tag"></i>
                    <span>Editar conta</span>
                </a>


                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="qc_pati_logout_partial.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Sair</span>
                </a>

            </div>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="qc_admin_dashboard.php" class="logo text-center">
            <span class="logo-lg">
                <img src="assets/images/logo.png" alt="" height="50">
                <!-- <span class="logo-lg-text-light">UBold</span> -->
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
        <li class="dropdown d-none d-lg-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                Criar Nova
                <i class="mdi mdi-chevron-down"></i>
            </a>
            <div class="dropdown-menu">


                <!-- item-->
                <a href="his_doc_register_patient.php" class="dropdown-item">
                    <i class="fe-activity mr-1"></i>
                    <span>Consulta</span>
                </a>
            </div>
        </li>
    </ul>
</div>
<?php } ?>
