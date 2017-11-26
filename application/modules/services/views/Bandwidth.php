<div class="jarviswidget jarviswidget-color-darken" id="wid-id-7" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
				
    <header>
        <h2>Bandwidth</h2>
        <div class="widget-toolbar" role="menu">
        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="<?=site_url("services/addBandwidth")?>" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span> Bandwidth</a>
        </div>
    </header>
    <div class="">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding">
            <table class="table table-bordered table-striped table-hovered table-inverse table-responsive" width="100%" id="bandwidth">
                <thead >
                    <tr>
                        <th data-class="expand">Nama Bandwidth</th>
                        <th>Rate Download</th>
                        <th>Rate Upload</th>
                        <th data-hide="phone">Shared User</th>
                        <th data-hide="phone">Option</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach($bandwidth->result_array() as $row)
                        {
                            echo "  <tr>
                                        <td scope='row'>$row[name]</td>
                                        <td>".byte_format($row['rate_down'])."</td>
                                        <td>".byte_format($row['rate_upload'])."</td>
                                        <td>$row[shared_users]</td>
                                        <td class='text-center'>
                                        <a class='btn btn-primary btn-xs' class=' m-l-10 btn btn-sm btn-primary waves-effect md-trigger' href='".site_url("services/addBandwidth/".encode_url($row['id'],'edit'))."' data-toggle='modal' data-target='#modal'><span class='zmdi zmdi-edit'></span></a>
                                        <a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url('services/delBandwidth/'.encode_url($row['id_api'],'del'))."\")'><i class='zmdi zmdi-delete'></i></a>
                                        </td>
                                    </tr>";
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="remoteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">        
            
            
            
        </div>
    </div>
</div>
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
		
        
	    var otable = $('#bandwidth').DataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#bandwidth'), breakpointDefinition);
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