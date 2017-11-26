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
					<form method="post" id="signup-form" class="smart-form" action="<?=base_url('register')?>">
						<header>
                        <i class="ti-lock on-left"></i> Sign Up <span class="pull-right "><a class="text-success" href="<?=site_url("admin/login")?>">Sign In</a></span>
                        </header>
                        					
						<fieldset>
                            <legend>Aplikasi Management Hotspot Mikrotik</legend>
							<section class="error">
                                <p class="text-success">
                                <?=(!empty($this->session->flashdata("register_msg"))? $this->session->flashdata("register_msg"):"")?>
                                </p>
                            </section>
							<section>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" autocomplete="off" name="username" placeholder="Masukan username">
								</label>
                            </section>
                            <section>
								<label class="input"> <i class="icon-append fa fa-envelope"></i>
									<input type="text" autocomplete="off" name="email" placeholder="Masukan alamat email">
								</label>
							</section>

							<section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" id="password" name="password" placeholder="Masukan Password">
                                     
								</label>
                            </section>
                            <section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="passwordConfirm" placeholder="Masukan Password">
								</label>
							</section>

							<section class="nmb">
								<label class="checkbox">
									<input type="checkbox" name="term">
									<i></i>Saya telah membaca dan menyetujui semua <a href="#">syarat - syarat.</a></label>
							</section>
						</fieldset>
						<footer class="npt">
                            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
							<button type="submit" class="btn btn-primary btn-sm btn-block">
								Sign up
                            </button>
                            
                        </footer>
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
<?$this->load->view('script');
?>
<script type="text/javascript">
	pageSetUp();
	var pagefunction = function() {
        
        var signup = $("#signup-form").validate({
            // Rules for form validation
            rules : {
				username : {
					required : true,
                    remote      :{
                        url : "<?=site_url('usercek')?>",
                        type: "get",
                        data: {
                            user: function() {
                                return $( "input[name=username]" ).val();
                            },
                            key : function(){
                                return "<?=$this->encrypt->encode('qazwsxedc',now())?>";
                                },
                            time: function(){
                                return "<?=now()?>"
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }
                    }
				},
				email : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					required : true,
					equalTo : '#password'
				},
                term :{
                    required :true
                }
			},

			// Messages for form validation
			messages : {
				username : {
					required    : 'Nama pengguna harus diisi',
                    remote      : 'Nama Pengguna sudah terdaftar'
				},
				email : {
					required    : 'Alamat email harus diisi',
					email       : 'Silahkan masukan alamat yang benar'
				},
				password : {
					required    : 'Silahkan masukan kata sandi',
                    minlength   : "minimal 3 huruf",
                    maxlength   : "maksimal 20 huruf"
				},
				passwordConfirm : {
					required    : 'Please enter your password one more time',
					equalTo     : 'Please enter the same password as above'
				}
			},
            errorElement : 'b',
            errorPlacement : function(error, element) {
                error.insertAfter(element).addClass("tooltip tooltip-top-right");               
                element.parent().addClass("state-error");
            },
            // showErrors: function (errorMap, errorList) {
            //     var i, elements;
            //     for (i = 0; errorList[i]; i++) {

            //         errorList[i].message = '<b class="tooltip tooltip-top-right">'+errorList[i].message+'</b>';
                    
            //     }
            //     this.defaultShowErrors();
            // },
            // highlight: function(element,error,validate)
            // {
            //     this.findByName(element.name).parent().addClass("input-group-danger").addClass("m-b-0");
            // },
            success : function(label,element)
            {
                // this.findByName(element.name).parent().removeClass();
                $("input[name="+element.name+"]").parent().removeClass("state-error");
                $("input[name="+element.name+"]").next().remove();
            }
        });
    }

loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

    
</script>