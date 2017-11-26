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
                        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="<?=site_url("setting/addRouter")?>" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus">&nbsp; </span>Router</a>
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
                                    <th data-class="expand">Router Name</th>
                                    <th>username</th>
                                    <th data-hide="phone">Address Router</th>
                                    <th data-hide="phone">Password</th>
                                    <th data-hide="phone">port</th>
                                    <th data-hide="phone,tablet,desktop">ID router</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            foreach ($routers->result_array() as $row) {
                                $def = ($row['status'] == 1)? "<sup class='text-info'> default</sup>" : "";
                                echo "<tr>
                                        <td>$row[name]$def</td>
                                        <td>$row[user]</td>
                                        <td>$row[host]</td>
                                        <td>$row[pass]</td>
                                        <td>$row[port]</td>
                                        <td><input value='".$row['hash']."' disable readonly style='width:75%'></td>
                                        <td class='text-center'>
                                            <a class='btn btn-primary btn-xs' class=' m-l-10 btn btn-sm btn-primary waves-effect md-trigger' href='".site_url("setting/addRouter/".encode_url($row['id'],'edit'))."' data-toggle='modal' data-target='#modal'><span class='zmdi zmdi-edit'></span></a> ";
                                echo ($row['status'] != 1) ? "<a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url('setting/delRouter/'.encode_url($row['id'],'delrouter'))."\")'><i class='zmdi zmdi-delete'></i></a>":"";
                                echo "
                                            
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
        var responsiveHelper_datatable_fixed_column = undefined;
        var breakpointDefinition = {
				tablet : 1024,
				phone : 480,
                desktop:1440
			};

        var itable = $('#routers').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
            "preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#routers'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column.respond();
			}
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