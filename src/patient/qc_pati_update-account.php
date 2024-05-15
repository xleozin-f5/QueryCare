<?php
session_start();
include('assets/inc/config.php');

// Update profile information
if (isset($_POST['update_profile'])) {
    $pat_fname = $_POST['pat_fname'];
    $pat_lname = $_POST['pat_lname'];
    $pat_id = $_SESSION['pat_id'];
    $pat_email = $_POST['pat_email'];

    // Use prepared statements with parameterized queries
    $query = "UPDATE his_pats SET pat_fname=?, pat_lname=?, pat_email=? WHERE pat_id =?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssi', $pat_fname, $pat_lname, $pat_email, $pat_id);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        $err = "Error updating profile: ". $stmt->error;
    } else {
        $success = "Perfil Atualizado";
    }
}

// Update password
if (isset($_POST['update_pwd'])) {
    $pat_id = $_SESSION['pat_id'];
    $pat_pwd = password_hash($_POST['pat_pwd'], PASSWORD_BCRYPT); // Use a secure hashing algorithm

    // Use prepared statements with parameterized queries
    $query = "UPDATE his_pats SET pat_pwd =? WHERE pat_id =?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $pat_pwd, $pat_id);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        $err = "Error updating password: ". $stmt->error;
    } else {
        $success = "Senha Atualizada";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('assets/inc/head.php');?>

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
        <?php
            $pat_id=$_SESSION['pat_id'];
            $ret="SELECT * FROM his_pats WHERE pat_id=?";
            $stmt= $mysqli->prepare($ret);
            $stmt->bind_param('i',$pat_id);
            $stmt->execute();
            $res=$stmt->get_result();
            while($row=$res->fetch_object())
            {
        ?>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Painel</a></li>
                                        <li class="breadcrumb-item active">Perfil</li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="../pat/assets/images/users/<?php echo $row->pat_dpic;?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                <div class="text-center mt-3">
                                    <p class="text-muted mb-2 font-13"><strong>Nome Completo :</strong> <span class="ml-2"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Número de Paciente :</strong> <span class="ml-2"><?php echo $row->pat_number;?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $row->pat_email;?></span></p>
                                </div>
                            </div> <!-- end card-box -->
                        </div> <!-- end col-->
                        <div class="col-lg-8 col-xl-8">
                            <div class="card-box">
                                <ul class="nav nav-pills navtab-bg nav-justified">
                                    <li class="nav-item">
                                        <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                            Atualizar Perfil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            Mudar Password
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="aboutme">
                                        <form method="post" enctype="multipart/form-data">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i>Informações Pessoais</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="firstname">Nome</label>
                                                        <input type="text" name="pat_fname" class="form-control" id="firstname" placeholder="<?php echo $row->pat_fname;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lastname">Sobrenome</label>
                                                        <input type="text" name="pat_lname" class="form-control" id="lastname" placeholder="<?php echo $row->pat_lname;?>">
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Email</label>
                                                        <input type="email" name="pat_email" class="form-control" id="useremail" placeholder="<?php echo $row->pat_email;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="useremail">Foto de Perfil</label>
                                                        <input type="file" name="pat_dpic" class="form-control btn btn-success" id="useremail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Guardar</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="settings">
                                        <form method="post">
                                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Mudar Password</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userpassword">Nova Password</label>
                                                        <input type="password" name="pat_pwd" class="form-control" id="userpassword" placeholder="Nova Password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" name="update_pwd" class="btn btn-primary waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- content -->
            <?php include('assets/inc/footer.php');?>
        </div>
        <?php } ?>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

<?php include('assets/inc/scripts.php');?>
</body>
</html>