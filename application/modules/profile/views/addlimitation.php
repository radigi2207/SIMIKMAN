<div class="modal-header">
    Tambah Profile
</div>

<div class="modal-body no-padding">
    <form action="<?=site_url('profile/addLimitation/'.$edit)?>" method="post" id="formLimitation" class="smart-form">
        <header>
            Registration form
        </header>
        <fieldset>					
            <div class="row">
                <section class="col col-6">
                    <label class="input">
                        <i class=" icon-prepend fa fa-user"></i>
                        <input type="text" class="form-control" name="name" value="<?=(isset($limit->name)) ? $limit->name: ""?>" placeholder="Limitation name">
                    </label>
                </section>
                <section class="col col-6">
                    <label class="input">
                        <i class=" icon-prepend zmdi zmdi-labels"></i>
                        <input type="text" class="form-control"  value="<?=$this->session->userdata("user")?>" disabled readonly  placeholder="Owner">
                    </label>
                </section>
            </div>
        </fieldset>
        <fieldset>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <i class="zmdi zmdi-download icon-prepend"></i>
                        <input type="text" class="form-control" value="<?=(isset($limit->down_limit)) ? byte_mikrotik($limit->down_limit,0): ""?>" name="download-limit"  placeholder="Download">
                    </div>
                </section>
                <section class="col col-6">
                    <div class="input">
                        <i class="zmdi zmdi-upload icon-prepend"></i>
                        <input type="text" class="form-control" value="<?=(isset($limit->up_limit)) ? byte_mikrotik($limit->up_limit,0): ""?>" name="upload-limit"  placeholder="Upload">
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <i class="zmdi zmdi-swap-vertical icon-prepend"></i>
                        <input type="text" class="form-control" value="<?=(isset($limit->trans_limit)) ? byte_mikrotik($limit->trans_limit,0): ""?>" name="transfer-limit"  placeholder="Transfer">
                    </div>
                </section>
                <section class="col col-6">
                    <div class="input">
                        <i class="fa fa-clock-o icon-prepend"></i>
                        <input type="text" class="form-control" name="uptime-limit" value="<?=(isset($limit->uptime_limit)) ? ($limit->uptime_limit): ""?>"  placeholder="Uptime">
                    </div>
                </section>
            </div>
        </fieldset>
        <fieldset>
            <section>
                <div class="input ">
                    <i class="zmdi zmdi-accounts-list icon-prepend"></i>
                    <input type="text" class="form-control" name="address-list" value="<?=(isset($limit->add_list)) ? ($limit->add_list): ""?>" placeholder="Adress List">
                </div>
            </section>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <i class="zmdi zmdi-group icon-prepend"></i>
                        <input type="text" class="form-control" name="group-name" value="<?=(isset($limit->group_name)) ? ($limit->group_name): ""?>"  placeholder="Group Name">
                    </div>
                </section>
                <section class="col col-6">
                    <div class="input">
                        <i class=" icon-prepend zmdi zmdi-code-setting"></i>
                        <input type="text" class="form-control" name="ip-pool" value="<?=(isset($limit->ip_pool)) ? ($limit->ip_pool): ""?>" placeholder="IP Pool">
                    </div>
                </section>
            </div>
            
        </fieldset>
        <footer>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </footer>
    </form>
</div>
<script type="text/javascript">
    pageSetUp();
    var pagefunction = function() {
        
        var formLimitation = $("#formLimitation").validate({

			// Rules for form validation
			rules : {
				name : {
					required : true
				},
			},            
			// Do not change code below
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
                        
                        $.smallBox({
                            title : "Limitations",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            timeout : 3000
                        });
                        if(dt.code == 200)
                        {
                            // $(form).resetForm();
                            var url = location.href.split('#').splice(1).join('#');
                            //console.log(url);
                            loadURL('<?=base_url()?>/'+ url,$('#content'));
                        }
                    }
                });
            },
		});
		
        
	    /* END COLUMN FILTER */   

    };
    loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
    </script>