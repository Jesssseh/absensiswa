

<div class="page-header">
<ul class="breadcrumbs">
<li class="nav-home">
<a href="#">
<i class="flaticon-home"></i>
</a>
</li>
<li class="separator">
<i class="flaticon-right-arrow"></i>
</li>
<li class="nav-item">
<a href="#">Akun Saya</a>
</li>
</ul>
</div>

<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Pengaturan Akun</h4>
								</div>
								<div class="card-body">
									<ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
										<li class="nav-item">
											<a class="nav-link" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Ganti Password</a>
										</li>
									</ul>
									<div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
										<div class="tab-pane fade show" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
											<hr>
												<form action="" method="post">
											<div class="form-group">
												<input name="pass" type="text" class="form-control" placeholder="Password Lama">
											</div>
											<div class="form-group">
												<input name="pass1" type="text" class="form-control" placeholder="Password Baru">
											</div>
											<div class="form-group">									
										<button name="changePassword" type="submit" class="btn btn-success btn-block">Ganti Password</button>
									</div>
								
									</form>

									<?php 
									if (isset($_POST['changePassword'])) {
										$passLama = $data['password'];
										$pass = ($_POST['pass']);
										$newPass = ($_POST['pass1']);

										if ($passLama == $pass) {
											$set = mysqli_query($con, "UPDATE tb_siswa SET password='$newPass' WHERE id_siswa='$data[id_siswa]'");
						echo "
													<script type='text/javascript'>
													setTimeout(function () { 

													swal('Berhasil', 'Password Berhasil Diubah', {
													icon : 'success',
													buttons: {        			
													confirm: {
													className : 'btn btn-success'
													}
													},
													});    
													},10);  
													window.setTimeout(function(){ 
													window.location.replace('?page=akun');
													} ,3000);   
													</script>";
												
										}else{


													echo "
													<script type='text/javascript'>
													setTimeout(function () { 

													swal('Gagal', 'Password Lama Tidak cocok', {
													icon : 'error',
													buttons: {        			
													confirm: {
													className : 'btn btn-danger'
													}
													},
													});    
													},10);  
													window.setTimeout(function(){ 
													window.location.replace('?page=akun');
													} ,3000);   
													</script>";


										}
									}
									 ?>

										</div>
										<div class="tab-pane fade" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
											      <form action="" method="post" enctype="multipart/form-data">
    
      </form>
										</div>
									</div>
								</div>
							</div>
						</div>

	<a href="javascript:history.back()" class="btn btn-default btn-block mb-1">
		<i class="fas fa-arrow-circle-left">
			
		</i> Kembali</a>
