<?
$data['page_title'] = "Login Hotspot";
$this->load->view('headerlogin',$data);

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->

<body class="common-img-bg dark-layout">
<div class="">
	<!-- MAIN CONTENT -->
	<div id="content" class="container login-card">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center">
            <img src="<?=base_url("assets/images/situnet-32.png")?>" alt="logo.png">
			</div>
		</div>
		<div class="row padding-top-10">
			
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="auth-box">
                    <form class="smart-form" action="<?=isset($post['link-login-only'])?$post['link-login-only']:""?>" 
                    <?=isset($post['chap-id'])? "onSubmit='return doLogin()'":"";?> method="post">
						<header>
                        <i class="ti-lock on-left"></i> Sign In
                        </header>
                        					
						<fieldset>
                            <legend>Login Hotspot Mikrotik</legend>
                            <section class="error">
                                <p class="text-danger">
                                <?=isset($post['error'])?$post['error']: ""?>
                                </p>
                            </section>
							<section>
								<label class="input">
                                    <input type="text" class="hidden" name="username">
                                    <input type="text" class="input-lg" autocomplete="off" placeholder="Silahkan masukan User ID" name="password" onKeyup='set_username(this.value)'>
								</label>
							</section>
						</fieldset>
						<footer class="npt">
                            
							<button type="submit" class="btn btn-primary btn-sm btn-block">
								Masuk
                            </button>
                            
                        </footer>
                        <p class=" m-t-25 text-left">Cara mendapatkan akun <a href=""> Daftar </a></p>
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
<script type="text/javascript" src="<?=base_url()?>assets/js/md5.js"></script>
<script type="text/javascript">
function doLogin() {
    document.sendin.username.value = document.getElementsByName("username")[0].value;
    document.sendin.password.value = hexMD5('<?isset($post['chap-id'])?$post['chap-id']:""?>' + document.getElementsByName("password")[0].value  + '<?=isset($post['chap-challenge'])?$post['chap-challenge']:""?>');
    document.sendin.submit();
    return false;
}

function set_username(v)
{
    document.getElementsByName("username")[0].value = v;
}
</script>
