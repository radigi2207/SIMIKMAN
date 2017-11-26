<section id="widget-grid" class="">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-blueDark" data-widget-editbutton="true"
                data-widget-colorbutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="true"
				data-widget-sortable="true">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Radius Server</h2>
                    <div class="widget-toolbar" role="menu">
                        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="<?=site_url("setting/addRadius")?>" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus">&nbsp; </span>Radius Server</a>
                        <!-- <a class="btn btn-danger btn-xs" href="javascript:void(0);"><span class="glyphicon glyphicon-repeat "></span> Reset Aplikasi</a> -->
                    </div>
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
                        <table id="routers" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Router Name</th>
                                    <th>Ip Address</th>
                                    <th>Secret</th>
                                    <th>Time Zone</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            foreach ($routers->result_array() as $row) {
                                echo "<tr>
                                        <td>$row[name]</td>
                                        <td>$row[ip]</td>
                                        <td>$row[secret]</td>
                                        <td>$row[time_zone]</td>
                                        <td class='text-center'>
                                            <a class='btn btn-primary btn-xs' class=' m-l-10 btn btn-sm btn-primary waves-effect md-trigger' href='".site_url("setting/addRadius/".encode_url($row['id_api'],'edit'))."' data-toggle='modal' data-target='#modal'><span class='zmdi zmdi-edit'></span></a>
                                            <a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url('setting/delRadius/'.encode_url($row['id_api'],'delradius'))."\")'><i class='zmdi zmdi-delete'></i></a>
                                        </td>
                                    </tr>";
                            }
                            ?>    
                            </tbody>
                        </table>

					</div>
				</div>
			</div>
		</article>
	</div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="remoteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">        
            
            
            
        </div>
    </div>
</div>
<!-- //<i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="Email is not a valid email"></i> -->
<script type="text/javascript">
	pageSetUp();
	
	var pagefunction = function() {
        var router = $('#routers').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true
        });
        
    }
loadScript("<?=base_url('assets')?>/js/plugin/datatables/jquery.dataTables.min.js", function(){
    loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.colVis.min.js", function(){
        loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.tableTools.min.js", function(){
            loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                loadScript("<?=base_url('assets')?>/js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
            });
        });
    });
});
</script>