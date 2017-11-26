<?php
$data['page_title'] = "Login";
$this->load->view('headerlogin',$data);

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->

<body class="common-img-bg dark-layout">
<div class="">
	<!-- MAIN CONTENT -->
	<div id="content" class="container login-card " style="padding-top:15px !important">
		<div class="row ">
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
                            <div class="scroll">
                                <dl>
                                    <dt>Application Name</dt>
                                    <dd>SIMIKMAN V2.0 </dd>
                                    <dt>Realease Date</dt>
                                    <dd>10 November 2017</dd>
                                    <dt>Donasi (an/ Radi Ginanjar)</dt>
                                    <dd>0066.42525.8100 / BANK JABAR BANTEN (BJB)</dd>
                                    <dt>email / phone</dt>
                                    <dd><a class="txt-color-white " href="mail:rdi.ginanjar@yahoo.co.id">rdi.ginanjar@yahoo.co.id</a> / <a class="txt-color-white " href="phone:085723028647">0857 2302 8647</a></dd>
                                    <dt>Website</dt>
                                    <a class="txt-color-white " href="https://cybers-s.net">https://cybers-s.net</a>
                                    <dt class="padding-top-10">Syarat Penggunaan</dt>
                                    <dd class="text-justify dd-scroll custom-scroll">
                                        <ul>
                                            <li>Gunakan aplikasi ini dengan bijak dan benar. Anda dapat mendesain ulang aplikasi ini
                                                sesuai dengan yang anda butuhkan.
                                            </li>
                                            <li>
                                                Kami tidak bertanggung jika anda mengalami ERROR atau mengalami segala kerugian ketika
                                                menggunakan aplikasi ini, anda hanya bisa memberikan laporan atau feedback kepada kami
                                                yang berisi laporan ERROR. Terkecuali anda membeli Lisensi aplikasi ini dari kami.
                                            </li>
                                            <li>
                                                Anda dapat menggunkan aplikasi ini selamanya tanpa ada batasan waktu,
                                            </li>
                                            <li>
                                                Aplikasi ini bersifat free / bebas, namun ada beberapa modul tambahan atau modul custom
                                                yang bisa anda dapatkan dengan cara ber-DONASI.
                                            </li>
                                            <li>Jika ada kekeliruan dikemudian hari, kami berhak untuk mengubah Syarat Penggunaan ini
                                                tanpa ada pemberitahuan sebelumnya.</li>
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
							
						</fieldset>
						<footer class="npt">
							<a class="btn btn-primary btn-sm btn-block" href="<?php echo site_url("step_1")?>">
								Accept & Continue
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
<style>
.dd-scroll{
    height:160px;
    overflow-y: auto;
    padding-top:10px;
    padding-right:7px;
}
ul li{
    margin-bottom: 5px !important;
}
</style>