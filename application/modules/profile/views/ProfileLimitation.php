<div class="modal-header">
        Profil Limitations
    </div>
    
    <div class="modal-body no-padding">
        <form action="<?=site_url('profile/ProfileLimitation/'.$profile)?>" class="smart-form" method="post" id="formProfileLimitation" >
            <div class="row">
                <section class="col col-lg-12 nmb">
                    <fieldset>
                        <section>
                            <label class="label">Periode (Days)</label>
                            <div class="inline-group">
                            <?
                            foreach ($week as $row) {
                            ?>
                                <label class="checkbox">
                                    <input type="checkbox" value="<?=$row?>" <?=(count($limit) == 0) ? "checked":""?> <?=(count($limit) > 0 && in_array($row,$limit[0]['weekdays'])) ? "checked":""?>  name="weekdays[]" class="cday">
                                    <i></i><?=$row?></label>
                            <?
                            }
                            ?>
                            </div>
                            <!-- <div class="row">
                                <div class="col col-4">
                                    
                                    <label class="checkbox">
                                        <input type="checkbox" value="monday" checked name="weekdays[]" class="cday">
                                        <i></i>monday</label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="tuesday" checked name="weekdays[]" class="cday">
                                        <i></i>tuesday</label>
                                </div>
                                <div class="col col-4">
                                    <label class="checkbox">
                                        <input type="checkbox" value="wednesday" checked name="weekdays[]" class="cday">
                                        <i></i>wenesday</label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="thursday" checked name="weekdays[]" class="cday">
                                        <i></i>thursday</label>											
                                </div>
                                <div class="col col-4">
                                    <label class="checkbox">
                                        <input type="checkbox" value="friday" checked name="weekdays[]" class="cday">
                                        <i></i>friday</label>
                                    <label class="checkbox">
                                        <input type="checkbox" value="saturday" checked name="weekdays[]" class="cday">
                                        <i></i>saturday</label>
                                    
                                </div>
                            </div> -->
                        </section>
                        <section>
                            <label class="label">Time</label>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" class="form-control hour" name="from_time" data-mask="99:99:99" value="<?=(count($limit) > 0)?$limit[0]['from_time']:"00:00:00"?>">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-clock-o"></i>
                                        <input type="text" class="form-control hour" name="till_time" data-mask="99:99:99" value="<?=(count($limit) > 0)?$limit[0]['till_time']:"23:59:59"?>">
                                    </label>
                                </section>
                            </div>
                        </section>
                        <section>
                            <label class="label">Limits</label>
                                <div class="inline-group">
                                <?
                                foreach($limitation as $row)
                                {
                                ?>
                                    <label class="checkbox">
                                        <input type="checkbox" value="<?=$row['name']?>" name="limitation[]" <?
                                        foreach ($limit as $l) {
                                            echo (in_array($row['name'],$l)) ? "checked" : "";
                                        }?> class="climit">
                                        <i></i><?=$row['name']?></label>                                        
                                <?}?>
                                </div>
                        </section>
                    </fieldset> 
                    <footer>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </footer>                           
                </section>
            </div>                  
        </div>  
        </form>  
    </div>
<script>
    pageSetUp();
	
	var pagefunction = function() {
        var formProfileLimitation = $("#formProfileLimitation").validate({
            // Rules for form validation
            rules : {
                from_time : {
                    required : true,
                },
                till_time :{
                    required : true,
                }
            },

            // Messages for form validation
            messages : {
                from_time:{
                    required: "waktu mulai harus diisi",
                },
                till_time:{
                    required : "waktu selesai harus diisi",
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
                        $.smallBox({
                            title : "User",
                            content : "<i>Limitations Profile berhasil disimpan</i>",
                            color : "#739E73",
                            iconSmall : "fa fa-cubes bounce animated",
                            timeout : 3000
                        });
                        // $(form).resetForm();
                        var url = location.href.split('#').splice(1).join('#');
                        //console.log(url);
                        loadURL('<?=base_url()?>/'+ url,$('#content'));
                    }
                });
            }
        });
    }
    loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
</script>