<?php
    $doc_id = $_SESSION['doc_id'];
    $doc_number = $_SESSION['doc_number'];
    $ret="SELECT * FROM  his_docs WHERE doc_id = ? AND doc_number = ?";
    $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('is',$doc_id, $doc_number);
    $stmt->execute() ;//ok
    $res=$stmt->get_result();
    //$cnt=1;
    while($row=$res->fetch_object())
    {
?>
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="d-none d-sm-block"></li>
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="./assets/images/users/photoprofile.png<?php echo $row->doc_dpic;?>" alt="dpic" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $row->doc_fname;?> <?php echo $row->doc_lname;?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bem-vindo(a)!</h6>
                </div>
                <a href="qc_doc_update-account.php" class="dropdown-item notify-item">
                    <i class="fas fa-user-tag"></i>
                    <span>Editar conta</span>
                </a>


                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="qc_doc_logout_partial.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Sair</span>
                </a>

            </div>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="qc_doc_dashboard.php" class="logo text-center">
            <span class="logo-lg">
                <img src="assets/images/logo.png" alt="" height="50">
                <!-- <span class="logo-lg-text-light">UBold</span> -->
            </span>
        </a>
    </div>
</div>
<?php }?>