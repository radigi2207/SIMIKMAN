<div class="modal-header">
    Tambah Bandwidth
</div>

<div class="modal-body no-padding">
    <form action="<?=current_url()?>" method="post" id="formBandwidth" class="smart-form" >
        <p class="alert alert-info">
            <i class="fa fa-info"></i> Silahkan isi semua field dibawah untuk menambah bandwidth baru</strong>
        </p>
        <fieldset>
            <section>
                <label for="name">Nama Bandwidth</label>
                <label class="input"> <i class="icon-prepend fa fa-tags"></i>
                    <input type="text" name="name" placeholder="Nama bandwidth"  id="name" value="<?=isset($bandwidth)? $bandwidth->name:NULL?>">
                </label>
            </section>
            <div class="row">
                <section class="col col-xs-10">
                    <label for="rate_download">Rate Download</label>
                    <label class="input">
                        <input type="text" name="rate_down" placeholder="Rate download" id="rate_download" value="<?=str_replace("KB","",str_replace("MB","",isset($bandwidth)? byte_format($bandwidth->rate_down,0):""))?>">
                        <b class="tooltip tooltip-bottom-right">Don't forget your password</b>
                    </label>
                </section>
                <section class="col col-xs-2 ">
                    <label class="hidden-xs" for="unit_down"></label>
                    <label class="select">
                        <select name="rate_down_unit">
                            <option value="K" <?=strpos(byte_format(isset($bandwidth)? $bandwidth->rate_down:NULL,0),"KB") ? "Selected" : NULL ?>>Kbps</option>
                            <option value="M" <?=strpos(byte_format(isset($bandwidth)? $bandwidth->rate_down:NULL,0),"MB") ? "Selected" : NULL ?>>Mbps</option>
                        </select> <i></i> </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-xs-10 ">                    
                    <label  for="rate_upload">Rate Upload</label>
                    <label class="input">
                        <input type="text" name="rate_upload" placeholder="Rate Upload" id="rate_upload" value="<?=str_replace("KB","",str_replace("MB","",isset($bandwidth)? byte_format($bandwidth->rate_upload,0):""))?>">
                    </label>
                </section>
                <section class="col col-xs-2 ">
                    <label class="hidden-xs" for="unit_upload"></label>
                    <label class="select">
                        <select name="rate_upload_unit">
                            <option value="K" <?=strpos(byte_format(isset($bandwidth)? $bandwidth->rate_upload:NULL,0),"KB") ? "Selected" : NULL ?>>Kbps</option>
                            <option value="M" <?=strpos(byte_format(isset($bandwidth)? $bandwidth->rate_upload:NULL,0),"MB") ? "Selected" : NULL ?>>Mbps</option>
                        </select> <i></i> </label>
                </section>
            </div>
            <div class="row">
                <section class="col col-xs-6 ">                    
                    <label  for="shared_users">Shared Users</label>
                    <select class="form-control select" name="shared_users" id="shared_users">
                        <?
                        for($i=1;$i <= 10;$i++)
                        {
                            echo "<option value='$i'";
                            
                            echo ">$i</option>";
                        }
                        ?>
                        
                    </select>
                </section>
                <section class="col col-xs-6 ">
                    <label for="address_list">Address List</label>
                    <div class="input ">
                        <i class="zmdi zmdi-accounts-list icon-prepend"></i>
                        <input type="text" class="form-control" name="address_list" value="<?=isset($bandwidth)? $bandwidth->address_list:NULL?>" id="address_list" placeholder="Adress List">
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
        
    var pagefunction = function() 
    {
        var formBandwidth = $("#formBandwidth").validate({
            rules: {
                name:{
                    required:true,
                    remote:{
                        url : "<?=site_url("services/checkBandwidth/name/".(isset($bandwidth)? "edit":""))?>",
                        type: "get",
                        data: {
                            val: function() {
                                return $( "input[name=name]" ).val();
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }
                    }                    
                },
                rate_down:{
                    required:true
                },
                rate_upload:{
                    required:true
                }
                
            },
            messages:{
                name:{
                    required:"Nama Bandwidth harus diisi",
                    remote:"Nama Bandwidth sudah ada"
                },
                rate_down:{
                    required:"Rate Download harus diisi"
                },
                rate_upload:{
                    required:"Rate Upload harus diisi"
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
                            title : "Bandwidth",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            timeout : 3000
                        });

                        if(dt.code == 200)
                        {
                            $(form).resetForm();
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