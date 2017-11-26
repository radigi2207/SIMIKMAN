<div class="modal-header">
    Transksi User
</div>

<div class="modal-body no-padding">
    <form action="<?=site_url('user/transaksi/'.$id)?>" method="post" id="transaksi" class="smart-form" >
        <p class="alert alert-info">
            <i class="fa fa-info"></i> Silahkan pilih jenis voucher untuk mengkatifkan user</strong>
        </p>
        <fieldset>
            <section>
                <label class="select">
                    <select name="profile">
                        <option value="0" selected="" disabled="">Voucher</option>
                        <?
                        foreach ($voucher->result_array() as $row) {
                            echo "<option value='".$row['name']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select> <i></i> </label>
            </section>
        </fieldset>
        <fieldset>
            <table class="table table-striped table-bordered nowrap table-hover" id="usertransaksi" width="100%">
                <thead>
                    <tr>
                        <th>Voucher</th>
                        <th>Tgl. Daftar</th>
                        <th>Tgl Pakai</th>
                        <th>Price</th>
                        <th>Masa Aktiv</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach ($transaksi->result_array() as $row) {
                        echo "<tr>
                                <td>$row[profile]</td>
                                <td>$row[date]</td>
                                <td></td>
                                <td>".number_format($row['price'],0,',','.')."</td>
                                <td>$row[validity]</td>
                              </tr>";
                    }
                    ?>
                </tbody>
                
            </table>
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
        var otable = $('#usertransaksi').DataTable({
			"sDom": "t"+
					"<'dt-toolbar-footer'<'col-xs-12'p>>",
            "autoWidth" : true,
            "pageLength": 3,
            "ordering": false
		
        });

        var $transaksi = $("#transaksi").validate({

			// Rules for form validation
			rules : {
				profile : {
					required : true
				}
			},
			messages:{
				profile:{
					required :"Silahkan pilih jenis voucher "
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
                $.SmartMessageBox({
                    title : "<i class='fa fa-save on-left'></i> Apakah anda yakin akan menambahkan Voucher <b>"+ $("select[name=profile]").val()+
                            "</b> pada <b><?=$user->username?></b> ?",
                    content : "Semua data voucher sebelumnya akan terhapus dan mulai kembali dari 0 (nol)",
                    buttons : '[Batal][Ya]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Ya") {
                        $(form).ajaxSubmit({
                            success : function(data) {
                                $.smallBox({
                                    title : "Transaksi voucher",
                                    content : "<i><b>"+ $("select[name=profile]").val()+"</b> berhasil di tambahkan pada <b><?=$user->username?></b> </i>",
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
                    if (ButtonPressed === "Batal") {
                    }
                
                    
                
                });                
            },
		});
    };
loadScript("<?=base_url('assets')?>/js/plugin/datatables/jquery.dataTables.min.js", function(){
    loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.colVis.min.js", function(){
        loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.tableTools.min.js", function(){
            loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                loadScript("<?=base_url('assets')?>/js/plugin/datatable-responsive/datatables.responsive.min.js", function(){
                    loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction)
                });
            });
        });
    });
});
$(document).ready(function(){
    $(".dataTables_empty").attr("colspan",5);
});
</script>
