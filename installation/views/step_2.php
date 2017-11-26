<?php
$data['page_title'] = "Login";
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
		<div class="row padding-top-5">
			
			<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="auth-box">
					<form method="post" id="database" class="smart-form" action="<?php echo site_url("step_2")?>">
                        					
						<fieldset>
                            <legend class="font-md">SIMIKMAN V2.0 Installer</legend>
							<section class="error">
                                <p class="text-danger">
                                <?=(!empty($this->session->flashdata("failed"))? $this->session->flashdata("failed"):"")?>
                                </p>
                            </section>
							<section>
								<label class="input"> <i class="icon-append zmdi zmdi-device-hub"></i>
									<input type="text" autocomplete="off" name="host" placeholder="localhost" value="<?php echo ($post) ? $post['host'] : "localhost"?>">
								</label>
                            </section>
                            <section>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" autocomplete="off" name="user" placeholder="root" value="<?php echo ($post) ? $post['user'] : NULL?>">
								</label>
							</section>

							<section>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password" placeholder="password">
                                     
								</label>
                            </section>
                            <section>
								<label class="input"> <i class="icon-append zmdi zmdi-storage"></i>
                                    <input type="text" name="database" placeholder="db_situnet" value="<?php echo ($post) ? $post['database'] : NULL?>">
                                     
								</label>
                            </section>
						</fieldset>
						<footer class="npt">
							<button type="submit" class="btn btn-primary btn-sm btn-block">
								<i class="fa fa-save"></i> Save
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
<?php $this->load->view('script');
?>
<script type="text/javascript">
	pageSetUp();
	var pagefunction = function() {
        
        var signup = $("#database").validate({
            // Rules for form validation
            rules : {
				host : {
                    required : true
                },
				user : {
					required : true
				},
                database :{
                    required :true
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
            },
            // submitHandler : function(form) {
            //     $("button[type=submit]").addClass("m-progress");
            // }
            
        });
    }

loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

    
</script>