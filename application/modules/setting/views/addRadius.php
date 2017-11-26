
<div class="modal-header">
    Tambah Radius Server
</div>
<div class="modal-body no-padding">
    <form action="<?=isset($radius) ? current_url() : site_url('setting/addRadius')?>" method="post" id="formaddradius" class="smart-form" >
    <div class="row">
        <section class="col col-lg-12 nmb">
            <fieldset>
                <div class="alert alert-block alert-info">
                    <h5 class="alert-heading"><i class="fa fa-check-square-o"></i> Form Radius Server!</h5>
                    <p>
                        Silahkan masukan konfigurasi radius server!
                    </p>
                </div>
                <div class="row">
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append zmdi zmdi-router"></i>
                            <input type="text" autocomplete="off" name="name" placeholder="Masukan Nama Radius" value="<?=isset($radius->name)?$radius->name:""?>">
                        </label>
                    </section>
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append icofont icofont-network"></i>
                            <input type="text"  name="ip" autocomplete="off" placeholder="IP Address" value="<?=isset($radius->ip)?$radius->ip:""?>">
                        </label>
                    </section>
                </div>
                <section>
                    <label class="input"> <i class="icon-append icofont icofont-ui-password"></i>
                        <input type="text" name="secret" autocomplete="off"  placeholder="Shared secret" value="<?=isset($radius->secret)?$radius->secret:""?>">
                    </label>
                </section>
            </fieldset>
            <footer>
                <button type="submit" class="btn btn-primary">Simpan</button>
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </footer>
        </section>
    </div>
    
    </form>
</div>
<script type="text/javascript">
    pageSetUp();    
        
    var pagefunction = function() 
    {
        $.validator.addMethod(
            "ip",
            function(value, element, regexp) 
            {
                if (regexp.constructor != RegExp)
                    regexp = new RegExp(regexp);
                else if (regexp.global)
                    regexp.lastIndex = 0;
                return this.optional(element) || regexp.test(value);
            },
            "Alamat Ip tidak sesuai"
        ); 

        var formaddradius = $("#formaddradius").validate({
            rules: {
                name:{
                    required:true,
                    remote:{
                        url : "<?=site_url('setting/cekname/'.(isset($radius)? "edit":""))?>",
                        type: "get",
                        data: {
                            name: function() {
                                return $( "input[name=name]" ).val();
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }               
                    }
                },
                ip: {
                    required: true,
                    remote:{
                        url : "<?=site_url('setting/cekip/'.(isset($radius)? "edit":""))?>",
                        type: "get",
                        data: {
                            ip: function() {
                                return $( "input[name=ip]" ).val();
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }
                    },
                    ip: /\b\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\b/
                    
                },
                secret:{
                    required:true
                }
            },
            messages:{
                name:{
                    required:"Nama router tidak boleh kosong",
                    remote:"Nama router sudah ada"
                },
                ip:{
                    required:"alamat IP tidak boleh kosong",
                    remote : "alamat IP sudah ada"
                },
                secret:{
                    required:"Shared secret tidak  boleh kosong"
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
                $(form).ajaxSubmit({
                    success : function(data) {
                        $.smallBox({
                            title : "Radius Server",
                            content : "<i>Radius Server berhasil disimpan</i>",
                            color : "#739E73",
                            iconSmall : "zmdi zmdi-router",
                            timeout : 3000
                        });
                        // $(form).resetForm();
                        var url = location.href.split('#').splice(1).join('#');
                        //console.log(url);
                        loadURL('<?=base_url()?>/'+ url,$('#content'));
                    }
                });
            },
        });
    };
    loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
</script>