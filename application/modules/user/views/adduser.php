<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12 col-md-12 col-lg-6">    
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-4" data-widget-editbutton="false"
				data-widget-colorbutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="true"
				data-widget-sortable="true">
				
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Registration User </h2>	
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
						
						<form action="<?=(isset($edit) != 0 ) ? site_url('user/add/'.$edit) :site_url('user/add')?>" id="registration" class="smart-form" method="post">
							<header>
								Registration User
							</header>
							<fieldset>
								<div class="row">
									<section class="col col-lg-6">
										<label class="input"> <i class="icon-append fa fa-user"></i>
										<input type="text" class="form-control" name="username" autocomplete="off"  placeholder="Username" value="<?=isset($user->username) ? $user->username : ""?>">
									</section>

									<section class="col col-lg-6">
										<label class="input"> <i class="icon-append fa fa-lock"></i>
										<input type="password" class="form-control" name="password" autocomplete="off" placeholder="Password" value="<?=isset($user->password) ? "#passwordsebelumnya#" : ""?>">
									</section>
								</div>
							</fieldset>

							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="input">
                                        <input type="text" class="form-control" name="first-name" autocomplete="off"  placeholder="First Name" value="<?=isset($user->first_name) ? $user->first_name : ""?>">
										</label>
									</section>
									<section class="col col-6">
										<label class="input">
                                        <input type="text" class="form-control" name="last-name" autocomplete="off"  placeholder="Last Name" value="<?=isset($user->last_name) ? $user->last_name : ""?>">
										</label>
									</section>
								</div>
                                <div class="row">
                                    <section class="col col-6">
                                        <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                        <input type="text" class="form-control" name="email" autocomplete="off"  placeholder="Email" value="<?=isset($user->email) ? $user->email : ""?>">
                                        </label>
                                    </section>
                                    <section class="col col-6">
										<label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                        <input type="text" class="form-control" name="phone" autocomplete="off"  placeholder="Phone" value="<?=isset($user->no_tlp) ? $user->no_tlp : ""?>">
										</label>
									</section>
                                </div>
                                <section>
                                    <label for="address" class="input">
                                        <input type="text" class="form-control" name="location" autocomplete="off" value="<?=isset($user->alamat) ? $user->alamat : ""?>"  placeholder="Address">
                                    </label>
                                </section>
								
							</fieldset>
                            
							<footer>
											
								<button type="submit" class="btn btn-primary">
									Simpan
								</button>
							</footer>
						</form>						
						
					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->
        </article>
		<!-- <article class="col-sm-12 col-md-12 col-lg-6">
			<div class="row">
				
		        <div class="col-xs-12 col-sm-6 col-md-4">
		            <div class="panel panel-success pricing-big">
		            	
		                <div class="panel-heading no-padding">
		                    <h3 class="panel-title">
		                        Bronze</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price padding-top-10 padding-bottom-10">
		                        <h1>
		                            <strong>FREE</strong></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Limited <strong> download quota</strong></li>
						          
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Download <span> now!</span></a>
		                	
		                </div>
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-6 col-md-4">
		            <div class="panel panel-teal pricing-big">
		            	
		                <div class="panel-heading no-padding">
		                    <h3 class="panel-title">
		                        Silver</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price padding-top-10 padding-bottom-10">
		                        <h1>
		                            $99<span class="subscript">/ mo</span></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Superbig <strong> download quota</strong></li>
						         
						        </ul>
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Purchase <span>via Paypal</span></a>
		                	
		                </div>
		            </div>
		        </div>
		        
		        <div class="col-xs-12 col-sm-6 col-md-4">
		            <div class="panel panel-primary pricing-big">
		            	<img src="img/ribbon.png" class="ribbon">
		                <div class="panel-heading no-padding">
		                    <h3 class="panel-title">
		                        Gold</h3>
		                </div>
		                <div class="panel-body no-padding text-align-center">
		                    <div class="the-price padding-top-10 padding-bottom-10">
		                        <h1>
		                            $350<span class="subscript">/ mo</span></h1>
		                    </div>
							<div class="price-features">
								<ul class="list-unstyled text-left">
						          <li><i class="fa fa-check text-success"></i> 2 years access <strong> to all storage locations</strong></li>
						          <li><i class="fa fa-check text-success"></i> <strong>Unlimited</strong> storage</li>
						          <li><i class="fa fa-check text-success"></i> Superbig <strong> download quota</strong></li>
						          
							</div>
		                </div>
		                <div class="panel-footer text-align-center">
		                    <a href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Purchase <span>via Paypal</span></a>
		                	
		                </div>
		            </div>
		        </div>
		        	    	
    		</div>
		</article> -->
    </div>
</section>
<script type="text/javascript">

	pageSetUp();

	
	var pagefunction = function() {
	
		var $registration = $("#registration").validate({

			// Rules for form validation
			rules : {
				username : {
					required : true,
					remote:{
                        url : "<?=site_url('user/cekuser/username/'.(isset($edit)? "edit":""))?>",
                        type: "get",
                        data: {
                            username: function() {
                                return $( "input[name=username]" ).val();
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }               
                    }
				},
				email : {
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},
			messages:{
				username:{
					required : "Nama pengguna harus diisi",
					remote 	 : "Username sudah terdaftar"
				},
				email:{
					email:"alamat email tidak sesuai"
				},
				password:{
					required	:"Kata sandi harus diisi",
					minlength	:"kata sandi minimal 3 huruf",
					maxlength	:"katasandi maksimal 20 huruf"
				}
			},
			errorElement : 'div',
            errorClass:'note note-error',
            // Do not change code below
            errorPlacement : function(error, element) {
                 error.insertAfter(element.parent());
                element.parent().addClass("input-group-danger");
            },
            // Ajax form submition
            submitHandler : function(form) {
                $(form).ajaxSubmit({
                    success : function(data) {

						var dt = JSON.parse(data);
						console.log(dt);
                        $.smallBox({
                            title : "User",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            iconSmall : "fa fa-users bounce animated",
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

		
	};
	
	loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);

</script>