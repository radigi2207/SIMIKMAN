<?php
$data['page_title'] = "Login";
$this->load->view('headerlogin',$data);

?>

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
                        <stong class="font-md">PHP SIMIKMAN V2.0 Installer</strong>
                    </header>
                    <hr>
                    <h1 class="text-center font-xl"><i class="fa fa-check-circle"> </i><br>Selesai</h1>
                    <dl class="dl-horizontal">
                        <dt>Username</dt>
                        <dd>admin</dd>
                        <dt>Password</dt>
                        <dd>1234</dd>                    
                    </dl>
                    <h5 class="text-info text-center"><a href="<?php echo site_url("admin")?>"><?php echo site_url("admin")?></a></h5>
                    <p>Hapus folder <strong>installation</strong></p>
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
</body>
<?php $this->load->view('script');
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
<?php
exit;
?>