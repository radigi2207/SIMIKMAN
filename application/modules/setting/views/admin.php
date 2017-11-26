<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-offset-3 col-lg-6">
			<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="true"
                data-widget-colorbutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="true"
				data-widget-sortable="true">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Pengaturan admin</h2>
                    
				</header>
                <div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
                        <form class="smart-form" action="<?php echo current_url()?>" method="post" id="admin">
                            <fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="fname" placeholder="First name" value="<?php echo isset($user) ? $user->first_name : "" ?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="lname" placeholder="Last name" value="<?php echo isset($user) ? $user->last_name : "" ?>">
										</label>
									</section>
								</div>
								<div class="row">
									<section class="col col-lg-6">
										<label class="input"> <i class="icon-prepend fa fa-user"></i>
											<input type="text" name="username" placeholder="Username" value="<?php echo isset($user) ? $user->username : "" ?>">
										</label>
									</section>
									<section class="col col-lg-6">
										<label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
											<input type="email" name="email" placeholder="E-mail" value="<?php echo isset($user) ? $user->email : "" ?>">
										</label>
									</section>
								</div>
                                
                                <div class="row">
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-eye-slash"></i>
											<input type="password" name="password" id="password" placeholder="Password" >
										</label>
									</section>
									<section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-eye-slash"></i>
											<input type="password" name="passwordConfirm" placeholder="Konfirmasi Password" >
										</label>
									</section>
								</div>
							</fieldset>
                            <footer class="text-center">
                                <section>
                                    <button type="submit" class="btn btn-primary btn btn-block">
                                        Simpan
                                    </button>
                                </section>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script type="text/javascript">
	pageSetUp();
	var pagefunction = function() {
        
        var signup = $("#admin").validate({
            // Rules for form validation
            rules : {
                fname:{
                    required:true
                },
				username : {
					required : true
				},
				email : {
					required : true,
					email : true
				},
				password : {
					minlength : 3,
					maxlength : 20
				},
				passwordConfirm : {
					equalTo : '#password'
				}
			},

			// Messages for form validation
			messages : {
                fname:{
                    required    : "Nama depan harus diisi"
                },
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
           
            success : function(label,element)
            {
                // this.findByName(element.name).parent().removeClass();
                $("input[name="+element.name+"]").parent().removeClass("state-error");
                $("input[name="+element.name+"]").next().remove();
            },
            submitHandler : function(form) {
                $("button[type=submit]").addClass("m-progress");
                $(form).ajaxSubmit({
                    success : function(data) {
                        
                        var dt = JSON.parse(data);
                        $.smallBox({
                            title : "User profile",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            iconSmall : "zmdi zmdi-users",
                            timeout : 3000
                        });

                        if(dt.code == 200)
                        {
                            setTimeout(function() {
                                location.reload();
                            },3000);
                        }
                        $("button[type=submit]").removeClass("m-progress");
                        
                        
                    }
                });
            },
        });
    }

loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

    
</script>