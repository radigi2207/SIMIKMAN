
<div class="modal-header">
    Tambah Router
</div>
<div class="modal-body no-padding">
    <form action="<?=current_url() ?>" method="post" id="formaddradius" class="smart-form" >
    <div class="row">
        <section class="col col-lg-12 nmb">
            <fieldset>
                <div class="alert alert-block alert-info">
                    <h5 class="alert-heading"><i class="fa fa-check-square-o"></i> Form tambah Router!</h5>
                    <p>
                        Silahkan masukan konfigurasi router!
                    </p>
                </div>
                <section>
                    <label class="input"> <i class="icon-append zmdi zmdi-router"></i>
                        <input type="text" autocomplete="off" name="name" placeholder="Nama Router" value="<?=isset($router->name)?$router->name:""?>">
                    </label>
                </section>
                <div class="row">
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append icofont icofont-network"></i>
                            <input type="text"  name="host" autocomplete="off" placeholder="IP Address Router" value="<?=isset($router->host)?$router->host:""?>">
                        </label>
                    </section>
                    
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append icofont icofont-ui-password"></i>
                            <input type="text" name="port" autocomplete="off"  placeholder="Port" value="<?=isset($router->port)?$router->port:""?>">
                        </label>
                    </section>
                </div>
                <div class="row">
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append zmdi zmdi-router"></i>
                            <input type="text" autocomplete="off" name="user" placeholder="username" value="<?=isset($router->user)?$router->user:""?>">
                        </label>
                    </section>
                    <section class="col col-6">
                        <label class="input"> <i class="icon-append icofont icofont-ui-password"></i>
                            <input type="text" name="pass" autocomplete="off"  placeholder="Password router" value="<?=isset($router->pass)?$router->pass:""?>">
                        </label>
                    </section>
                </div>
                
                
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
                        url : "<?=site_url('setting/nameRouter/'.(isset($router)? "edit":""))?>",
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
                user :
                {
                    required :true,
                },
                host: {
                    required: true,
                    remote:{
                        url : "<?=site_url('setting/cekipRouter/'.(isset($router)? "edit":""))?>",
                        type: "get",
                        data: {
                            host: function() {
                                return $( "input[name=host]" ).val();
                            }
                        },
                        dataFilter: function (data) {
                            return data;
                        }
                    }
                    
                },
                port:{
                    required:true
                }
            },
            messages:{
                name:{
                    required:"Nama router tidak boleh kosong",
                    remote:"Nama router sudah ada"
                },
                user:{
                    required : "user router harus diisi",
                },
                host:{
                    required:"alamat IP tidak boleh kosong",
                    remote : "alamat IP sudah ada"
                },
                port:{
                    required : "monor Port harus diisi"
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
                            title : "Router",
                            content : "<i>"+dt.msg+"</i>",
                            color : dt.color,
                            iconSmall : "zmdi zmdi-router",
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