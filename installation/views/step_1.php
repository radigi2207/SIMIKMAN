<?php
$data['page_title'] = "Login";
$this->load->view('headerlogin',$data);

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<? include_once("short_open_tag.php")?>
<body class="common-img-bg dark-layout">
<div class="">
	<!-- MAIN CONTENT -->
	<div id="content" class="container login-card">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4 text-center">
            <img src="<?=base_url("assets/images/situnet-32.png")?>" alt="logo.png">
			</div>
		</div>
		<div class="row padding-top-5">
			
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="auth-box">
					
					<header>
						<stong class="font-md">SIMIKMAN V2.0 Installer</strong>
					</header>
					<hr>			
					<fieldset>
						<dl>
							<dt>PHP Version</dt>
							<dd><?php echo "&nbsp;". (version_compare(PHP_VERSION, '5.3', '>=') ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " ". PHP_VERSION; ?></dd>
							<dt>PHP Extensions</dt>
							<dd><?php echo ((in_array("mcrypt",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " mcrypt ";?></dd>
							<dd><?php echo ((in_array("pdo_mysql",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " pdo mysql ";?></dd>
							<dd><?php echo ((in_array("session",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " session ";?></dd>
							<dd><?php echo ((in_array("json",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " json ";?></dd>
							<dd><?php echo ((in_array("date",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " date ";?></dd>
							<dd><?php echo ((in_array("bcmath",get_loaded_extensions())) ? "<i class='glyphicon glyphicon-ok text-success'></i>" : "<i class='glyphicon glyphicon-remove text-danger' ></i>"); echo " bcmath ";?></dd>
							<dt>PHP Configuration</dt>
							<dd><?php echo (function_exists('cek_short')) ? "<i class='glyphicon glyphicon-ok text-success'></i> Short Open Tag <sub>(<i>php.ini</i>)</sub>" : "<i class='glyphicon glyphicon-remove text-danger' ></i> Short Open Tag <sub class='font-xs'><a class='text-danger' target='_blank' href='http://php.net/manual/en/language.basic-syntax.phptags.php'>Solusi</a></sub>"; ?></dd> 
						</dl>
					</fieldset>
					<footer class="npt">
						<a class="btn btn-primary btn-sm btn-block <?php echo !function_exists('cek_short') ? "disabled" : NULL ?>" href="<?php echo function_exists('cek_short') ? site_url("step_2") : NULL ?>">
							Continue
						</a>
						
					</footer>
					<hr>
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