<div class="modal-header">
    Tambah Profile
</div>

<div class="modal-body no-padding">
    <form action="<?=(!isset($profile))?site_url('profile/addProfile') : site_url('profile/addProfile/'.encode_url($profile->id,'edit'))?>" method="post" id="formaddProfile" class="smart-form" >
        <p class="alert alert-info">
            <i class="fa fa-info"></i> Silahkan isi semua field dibawah untuk menambah profile baru</strong>
        </p>
        <fieldset>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <span class="icon-prepend" ><i class="zmdi zmdi-account-box"></i></span>
                        <input type="text" class="form-control" name="name" value="<?=(isset($profile)) ? $profile->name : ""?>"  placeholder="Profile name">
                    </div>
                </section>
                <section class="col col-6">
                    <div class="input">
                        <span class="icon-prepend" ><i class="zmdi zmdi-accounts-alt"></i></span>
                        <input type="text" name="nameforusers" class="form-control" value="<?=(isset($profile)) ? $profile->nameforusers : ""?>"  placeholder="Name for user">
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <span class="icon-prepend" ><i class="fa fa-clock-o"></i></span>
                        <input type="text" class="form-control" name="validity" value="<?=(isset($profile)) ? $profile->validity : ""?>"  placeholder="Validity">
                    </div>
                </section>
                <section class="col col-6">
                    <div class="select">
                        <span class="icon-prepend" ><span class="zmdi zmdi-square-right"></span></span>
                        <select class="form-control select" name="starts_at">
                            <option value="logon" <?=(isset($profile) && $profile->starts_at == "logon") ? "selected" : "";?>>Logon</option>
                            <option value="now" <?=(isset($profile) && $profile->starts_at == "now") ? "selected" : "";?>>now</option>
                        </select>
                    </div>
                </section>
            </div>
            <div class="row">
                <section class="col col-6">
                    <div class="input">
                        <span class="icon-prepend" ><span class="icofont icofont-money"></span></span>
                        <input type="text" class="form-control" name="price"  placeholder="Price" value="<?=(isset($profile)) ? $profile->price: ""?>">
                    </div> 
                </section>
                    <section class="col col-6">
                        <div class="select">
                        <span class="icon-prepend" ><span class="zmdi zmdi-accounts-list"></span></span>
                        <select class="form-control select" name="overridesharedusers">
                            <?
                            for($i=1;$i <= 10;$i++)
                            {
                                echo "<option value='$i'";
                                echo (isset($profile) && $profile->overridesharedusers == $i) ? "selected" : "";
                                echo ">$i</option>";
                            }
                            ?>
                            <option value="unlimited">unlimited</option>
                        </select>
                    </div>
                </section>
            </div>
        </fieldset>
        <footer>
            <button type="submit" class="btn btn-primary">Simpan</button>
            
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        </footer>
    </form>
</div>
<script type="text/javascript">
	pageSetUp();
	
	var pagefunction = function() {
        
        var formaddProfile = $("#formaddProfile").validate({
            // Rules for form validation
            rules : {
                name : {
                    required : true,
                },
                name_for_users :{
                    required : true,
                }
            },

            // Messages for form validation
            messages : {
                name:{
                    required: "Nama profile harus diisi",
                },
                name_for_users:{
                    required : "Nama untuk user harus diisi",
                }
            },
            errorElement : 'div',
            errorClass:'note note-error',
            // Do not change code below
            errorPlacement : function(error, element) {
                 error.insertAfter(element.parent());
                element.parent().addClass("input-group-danger");
            },
            submitHandler : function(form) {
                $(form).ajaxSubmit({
                    success : function(data) {
                        var dt = JSON.parse(data);

                        $.smallBox({
                            title : "Profile",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            iconSmall : "fa fa-cubes bounce animated",
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
            }
        });
    }

loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
               
</script>
