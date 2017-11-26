<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false"
				data-widget-colorbutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="true"
				data-widget-sortable="true">
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Laporan Periode</h2>
                    
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
                        <div class="row smart-form padding-top-10 padding-bottom-10">
                            <div class="col col-lg-3 col-xs-12 col-sm-4 col-md-4 padding-top-10">
                                <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                    <input type="text" name="startdate" readonly="" id="startdate" placeholder="Tanggal mulai">
                                </label>
                            </div>
                            <div class="col col-lg-3 col-xs-12 col-sm-4 col-md-4 padding-top-10">
                                <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                    <input type="text" name="startdate" readonly="" id="finishdate" placeholder="Tanggal akhir">
                                </label>
                            </div>
                            <div class="col col-lg-3 col-xs-12 col-sm-4 col-md-4 padding-top-10">
                                <label class="select">
                                <select class="form-control select" id="agen">
                                <option value="ALL">Semua</option>
                                    <?
                                    foreach($agen->result_array() as $row)
                                    {
                                        echo "<option value=\"$row[id]\">$row[first_name] $row[last_name]</option>";
                                    }
                                    ?>
                                    
                                </select>
                                </label>
                        </div>
                            <div class="col col-lg-3 col-xs-12 col-sm-4 col-md-4 padding-top-10 ">
                                <a class="btn btn-success btn-sm pull-right" class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="javascript:excel()"><span class="icofont icofont-file-excel"></span> Excel</a>
                                <a class="btn btn-danger btn-sm pull-right margin-right-5" class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="icofont icofont-file-pdf"></span> Pdf</a>
                                <a class="btn btn-primary btn-sm pull-right margin-right-5" class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="icofont icofont-printer"></span> Cetak</a>                        

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-inverse table-responsive" id="table-periode">
                            <thead class="thead-default">
                                <tr>
                                    <th>No.</th>
                                    <th>[Username] Nama</th>
                                    <th>Voucher</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Operator</th>
                                </tr>
                                </thead>
                                <tbody>
                                   <tr>
                                       <td colspan='6' class="text-center"> <i>Silahkan pilih periode tanggal </i></td>
                                   </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='4' class="text-center"><strong> Jumlah</strong></td>
                                        <td class='text-right'><strong> 0</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script type="text/javascript">
pageSetUp();
$(document).ready(function(){
	$('#startdate').datepicker({
        dateFormat : 'dd-mm-yy',
        prevText : '<i class="fa fa-chevron-left"></i>',
        nextText : '<i class="fa fa-chevron-right"></i>',
        onSelect : function(selectedDate) {
            $('#finishdate').datepicker('option', 'minDate', selectedDate);
            get_data();
        }
    });
    
    $('#finishdate').datepicker({
        dateFormat : 'dd-mm-yy',
        prevText : '<i class="fa fa-chevron-left"></i>',
        nextText : '<i class="fa fa-chevron-right"></i>',
        onSelect : function(selectedDate) {
            $('#startdate').datepicker('option', 'maxDate', selectedDate);
            get_data();
        }
    });
});
function get_data()
{
    var finishdate = $('#finishdate').val();
	var startdate  = $('#startdate').val();
    var agen       = $("#agen").val()
    if(startdate.length != 0 && finishdate.length != 0 && agen.length != 0)
	{
		var tr = "<tr><td colspan='6' class='text-center'><i class='fa fa-gear fa-spin'></i> Silahkan tunggu sedang mengambil data</td></tr>";
		$("#table-periode tbody").html(tr);
		$.ajax({
			url :"<?=site_url('report/get_agen')?>",
			data:{startdate : startdate,finishdate:finishdate, agen : agen},
			type:'get',
            dataType:'json',
			success:function(data){
                $("#table-periode tbody").html(data.html);
                $("#table-periode tfoot").html(data.footer);
			}
		});
	}
}

function excel()
{
    var finishdate = $('#finishdate').val();
	var startdate  = $('#startdate').val();
    var agen       = $("#agen").val()
    if(startdate.length != 0 && finishdate.length != 0 && agen.length != 0)
	{
		window.open("<?=site_url()?>export/periode/"+startdate+"/"+finishdate+"/"+agen);
	}
}
</script>