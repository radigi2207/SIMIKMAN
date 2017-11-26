<!-- widget grid -->
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false"
				data-widget-colorbutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="true"
				data-widget-sortable="true">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>User</h2>
					<div class="widget-toolbar" role="menu">
                        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="glyphicon glyphicon-plus">&nbsp; </span>user</a>
                        <!-- <a class="btn btn-danger btn-xs" href="javascript:void(0);"><span class="glyphicon glyphicon-repeat "></span> Reset Aplikasi</a> -->
                    </div>
				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">

                        <table id="user-man" class="table table-striped table-bordered nowrap table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th data-class="expand">Account Name</th>
                                    <th data-hide="phone">Username</th>
                                    <th >Status</th>
                                    <th data-hide="phone,tablet">Actual Profile</th>
                                    <th data-hide="phone,tablet">Uptime</th>
                                    <th data-hide="phone,tablet">Download</th>
                                    <th data-hide="phone, tablet">Upload</th>
                                    <th >Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($user_mikrotik->result_array() as $row) {
                                    $status = (isset($row['status']) && $row['status'] == 1) ? '<label class="label label-success">Activ</label>' : '<label class="label label-danger">Not Activ</label>';
                                    $status = (isset($row['disabled']) && $row['disabled'] == 'false') ? $status : '<label class="label label-default">Disabled</label>';
                                    echo "<tr>
                                            <td>".$row['first_name']." ".$row['last_name']."</td>
                                            <td>".$row['username']."</td>
                                            <td class='text-center'>".$status."</td>
                                            <td>".$row['actual_profile']."</td>
                                            <td>".$row['time_used']."</td>
                                            <td>".byte_format($row['download'])."</td>
                                            <td>".byte_format($row['upload'])."</td>
                                            <td class='text-center'>
                                                <a class='btn btn-xs text-center btn-info  icon-btn' data-toggle='modal' href='".site_url('user/transaksi/'.encode_url($row['id'],'transaksi'))."' data-target='#modal'><i class='zmdi zmdi-eye'></i></a>
                                                <a class='btn btn-xs text-center btn-primary  icon-btn' href='#user/add?edit=".encode_url($row["id"]."#".$row['id_api'],'edit')."'><i class='zmdi zmdi-edit'></i></a>
                                                <a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url('user/del/'.$row['id'])."\")'><i class='zmdi zmdi-delete'></i></a>
                                            </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                            
                        </table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

	</div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="remoteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">        
            
            
            
        </div>
    </div>
</div>
<!-- end widget grid -->
<script type="text/javascript">
	pageSetUp();
	
	
	var pagefunction = function() {
        var responsiveHelper_datatable_fixed_column = undefined;
        var breakpointDefinition = {
				tablet : 1024,
				phone : 425,
                desktop:1440
			};
		var setor = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
		$(".curency").inputmask("decimal",{
            radixPoint:",", 
            groupSeparator: ".", 
            digits: 0,
            autoGroup: true
        });
		
        
	    var otable = $('#user-man').DataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#user-man'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column.respond();
			}
		
	    });
	};

	// load related plugins
	
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
