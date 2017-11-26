<?
$data['page_title'] = "Login";
$this->load->view('headerlogin',$data);

?>

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
                    <form method="post" id="router-form" class="smart-form" action="<?=base_url('register/router')?>">
						<header>
                        <i class="ti-lock on-left"></i> Sign Up <span class="pull-right "><a class="text-success" href="<?=site_url("admin/login")?>">Sign In</a></span>
                        </header>
                        					
						<fieldset>
                            <legend>Aplikasi Management Hotspot Mikrotik</legend>
                            <section class="error">
                                <p class="text-danger">
                                <?=(!empty($this->session->flashdata("router_failed"))? $this->session->flashdata("router_failed"):"")?>
                                </p>
                            </section>
							<section>
								<label class="input"> <i class="icon-append zmdi zmdi-router"></i>
                                <input type="text" class="form-control" placeholder="Host Mikrotik" name="host" value="<?=isset($config['host'])?$config['host']:""?>">
								</label>
                            </section>
                            <section >
                                <label class="input">
                                    <select name="port" class="form-control">
                                        <option value="8728">8728</option>
                                        <option value="22">22</option>
                                        <option value="443">443</option>
                                    </select>
								
								</label>
							</section>

							<section>
								<label class="input"> <i class="icon-append fa fa-user"></i>
                                <input type="text" class="form-control" placeholder="User mikrotik" name="user" value="<?=isset($config['user'])?$config['user']:""?>">
                                     
								</label>
                            </section>
                            <section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
                                <input type="password" class="form-control" placeholder="Password" name="pass">
								</label>
							</section>
						</fieldset>
						<footer class="npt">                            
							<button type="submit" class="btn btn-primary btn-sm btn-block">
								Simpan
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
</body>
<?$this->load->view('script');
?>
<script type="text/javascript">
	pageSetUp();
	var pagefunction = function() {
        
        var signup = $("#router-form").validate({
            // Rules for form validation
            rules : {
				host : {
					required : true,
                    
				},
				port : {
					required : true
				},
				user : {
					required : true,
					minlength : 3,
					maxlength : 20
				},
				// pass: {
				// 	required : true,
				// }
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