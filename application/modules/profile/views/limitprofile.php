<div class="modal-header">
    Limitations Profile
</div>

<div class="modal-body no-padding" id='<?=decode_url($profile,"limit")?>'>
    <form action="<?=site_url('profile/ProfileLimitation/'.$profile)?>" class="smart-form" method="post" id="formProfileLimitation" >
        <div class="row">
            <section class="col col-lg-12 nmb">
                <fieldset>
                    <section>
                        <label class="label"><?=$this->lang->line("date_periode")?> (<?=$this->lang->line("date_days")?>)</label>
                        <div class="row">
                        <?
                        foreach ($week as $row) {
                        ?>
                            <div class="col col-lg-3">
                            <label class="checkbox">
                                <input type="checkbox" value="<?=$row?>" <?=(count($limit) == 0) ? "checked":""?> <?=(count($limit) > 0 && in_array($row,$limit[0]['weekdays'])) ? "checked":""?>  name="weekdays[]" class="cday">
                                <i></i><?=$this->lang->line("cal_".$row)?></label>
                            </div>
                        <?
                        }
                        ?>
                        </div>
                        
                    </section>
                    <section>
                        <label class="label"><?=$this->lang->line("date_time")?></label>
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
                            foreach($limitation->result_array() as $row)
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
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </footer>                           
            </section>
        </div>                   
    </form>
</div>
<script type="text/javascript">
	pageSetUp();
	
	var pagefunction = function() {

        var id = $("#<?=decode_url($profile,"limit")?>");
        
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
                        
                    }
                });
            }
        });
    }

loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction);
               
</script>
