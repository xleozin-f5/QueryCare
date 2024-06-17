<?php
	session_start();
	include('assets/inc/config.php');
	
	if(isset($_POST['update_doc'])) 
	{
		$doc_fname=$_POST['doc_fname'];
		$doc_lname=$_POST['doc_lname'];
		$doc_number=$_GET['doc_number'];
		$doc_email=$_POST['doc_email'];
		$doc_pwd=sha1(md5($_POST['doc_pwd']));
		$doc_dpic=$_FILES["doc_dpic"]["name"];
		move_uploaded_file($_FILES["doc_dpic"]["tmp_name"],"../doc/assets/images/users/".$_FILES["doc_dpic"]["name"]);

        $query="UPDATE his_docs SET doc_fname=?, doc_lname=?, doc_email=?, doc_pwd=?, doc_dpic=? WHERE doc_number = ?";
		$stmt = $mysqli->prepare($query);
		$rc=$stmt->bind_param('ssssss', $doc_fname, $doc_lname, $doc_email, $doc_pwd, $doc_dpic, $doc_number);
		$stmt->execute();
		
		if($stmt) 
		{
			$success = "Detalhes do Médico Atualizados";
		}
		else {
			$err = "Por favor, tente novamente ou tente mais tarde";
		}
	}
?>
<!DOCTYPE html>
<html lang="pt">
    <?php include('assets/inc/head.php');?>
    <body>
        <div id="wrapper">
            <?php include("assets/inc/nav.php");?>
            <?php include("assets/inc/sidebar.php");?>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="qc_admin_dashboard.php">Painel</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Médico</a></li>
                                            <li class="breadcrumb-item active">Gerenciar Médico</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Atualizar Detalhes do Médico</h4>
                                </div>
                            </div>
                        </div>     
                        <?php
                            $doc_number=$_GET['doc_number'];
                            $ret="SELECT  * FROM his_docs WHERE doc_number=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$doc_number);
                            $stmt->execute() ;
                            $res=$stmt->get_result();
                            $row=$res->fetch_object();
                            if($row) {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Preencha todos os campos</h4>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Primeiro nome</label>
                                                    <input type="text" required="required" value="<?php echo $row->doc_fname;?>" name="doc_fname" class="form-control" id="inputEmail4" >
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Sobrenome</label>
                                                    <input required="required" type="text" value="<?php echo $row->doc_lname;?>" name="doc_lname" class="form-control"  id="inputPassword4">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputAddress" class="col-form-label">Email</label>
                                                <input required="required" type="email" value="<?php echo $row->doc_email;?>" class="form-control" name="doc_email" id="inputAddress">
                                            </div>
                                            
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Password</label>
                                                    <input required="required"  type="password" name="doc_pwd" class="form-control" id="inputCity">
                                                </div> 
                                                
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Foto de Perfil</label>
                                                    <input required="required"  type="file" name="doc_dpic" class="btn btn-success form-control"  id="inputCity">
                                                </div>
                                            </div>                                            

                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Atualizar Detalhes do Médico</button>

                                        </form>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <?php } ?>
                    </div> <!-- container -->
                </div> <!-- content -->
                <?php include('assets/inc/footer.php');?>
            </div>
        </div> <!-- END wrapper -->
        <div class="rightbar-overlay"></div>
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>
        <script src="assets/js/pages/loading-btn.init.js"></script>
    </body>
</html>
