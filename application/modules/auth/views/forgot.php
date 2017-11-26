<?
$data['page_title'] = "Login";
$this->load->view('headerlogin',$data);

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->

<body class="common-img-bg dark-layout">
<div class="">
	<!-- MAIN CONTENT -->
	<div id="content" class="container login-card">
		<div class="row padding-top-20">
			<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center">
            <img src="<?=base_url("assets/images/situnet-32.png")?>" alt="logo.png">
			</div>
		</div>
		<div class="row padding-top-10">
			
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="auth-box">
					<form method="post" id="login-form" class="smart-form" action="<?=base_url('admin/login')?>">
						<header>
                        <i class="ti-lock on-left"></i> Sign In
                        </header>
                        					
						<fieldset>
                            <legend>Aplikasi Management Hotspot Mikrotik</legend>
                            <section class="error">
                                <p class="text-danger">
                                <?=(!empty($this->session->flashdata("login_failed"))? $this->session->flashdata("login_failed"):"")?>
                                </p>
                            </section>
							<section>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" autocomplete="off" name="username" placeholder="Masukan username">
								</label>
							</section>
                            <section>
                                <span class="timeline-seperator text-center text-primary"> 
                                    <span class="font-sm">ATAU</span> 
                                </span>
                            </section>
							<section>
								<label class="input"> <i class="icon-append fa fa-envelope"></i>
                                    <input type="text" name="email" placeholder="Masukan Email">
								</label>
								
							</section>
						</fieldset>
						<footer class="npt">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
							<button type="submit" class="btn btn-primary">
								Reset
                            </button>
                            
                        </footer>
                        <p class=" m-t-25 text-left">Belum memiliki akun? <a href="<?=site_url("register")?>"> Daftar </a> gratis!</p>
                        <hr>
					</form>
                    <div class="row">
                        <div class=" col-xs-8 col-md-8 p-t-5">
                            <p class=" text-left m-b-0">Copyright sth.cybers-s.net</p>
                        </div>
                        <div class="col-md-4 col-xs-4">
						<img src="<?=base_url()?>assets/images/mikrotik.png" alt="small-logo.png" width="80px">
                        </div>
                    </div>
				</div>
				
				
				
			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
</body>