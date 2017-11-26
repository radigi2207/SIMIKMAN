<div class="jarviswidget jarviswidget-color-darken" id="wid-id-7" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
				
    <header>
        <h2>Profile</h2>
        <div class="widget-toolbar" role="menu">
        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="<?=site_url("profile/addProfile")?>" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span> Profile</a>
        </div>
    </header>
    <div class="">
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body no-padding  ">

        <table id="profilesTable" class="table table-striped table-bordered nowrap table-hover" width="100%">
        <thead>
            <tr>
                <th data-class="expand">Profile Name</th>
                <th data-hide="phone,tablet">Owner</th>
                <th data-hide="phone,tablet">Name For Users</th>
                <th>Validity</th>
                <th data-hide="phone,tablet">Shared Users</th>
                <th data-hide="phone,tablet">Start</th>
                <th data-hide="phone">Price</th>                                
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($profiles->result_array() as $row)
            {
                echo "<tr>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['owner']."</td>";
                echo "<td>".($row['nameforusers'])."</td>";
                echo "<td>".($row['validity'])."</td>";
                echo "<td>".($row['overridesharedusers'])."</td>";
                echo "<td>".$row['starts_at']."</td>";
                echo "<td class='text-right'>".number_format($row['price'],0,',','.')."</td>";
                echo "<td class='text-center'>
                          <a class='btn btn-xs text-center btn-success  icon-btn'  href='".site_url("profile/limit/".encode_url($row['name'],'limit'))."' data-toggle='modal' data-target='#modal'><i class='zmdi zmdi-eye'></i></a>
                          <a class='btn btn-primary btn-xs' class=' m-l-10 btn btn-sm btn-primary waves-effect md-trigger' href='".site_url("profile/addProfile/".$row['id'])."' data-toggle='modal' data-target='#modal'><span class='zmdi zmdi-edit'></span></a>
                          <a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url('profile/delProfile/'.encode_url($row['id_api'],'delprofile'))."\")'><i class='zmdi zmdi-delete'></i></a>
                      </td>";
                echo "</tr>";
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
				phone : 480,
                desktop:1440
			};
        var table = $('#profilesTable').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_fixed_column) {
					responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#profilesTable'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_fixed_column.respond();
			},
            // "data"  : dataprofile,
            "order": [
                [1, "asc"]
            ],
            
        });

        
        
    }
loadScript("<?=base_url('assets')?>/js/plugin/datatables/jquery.dataTables.min.js", function(){
    loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.colVis.min.js", function(){
        loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.tableTools.min.js", function(){
            loadScript("<?=base_url('assets')?>/js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                loadScript("<?=base_url('assets')?>/js/plugin/datatable-responsive/datatables.responsive.min.js", function(){
                    loadScript("<?=site_url()?>assets/js/plugin/jquery-form/jquery-form.min.js", pagefunction)
                })
            });
        });
    });
});
function setLimitationProfile(url,profile)
{
    // var cday = $(".cday").attr("checked", false);
    var climit = $(".climit").attr("checked", false);
    $.ajax({
        type: "get",
        url: "<?=site_url("profile/getProfileLimitation")?>",
        data: {profile : profile},
        dataType: "json",
        success: function (response) {
            //var obj = JSON.parse(response);
            for(var i = 0 ; i < response.length ; i++)
            {
                // if(response[i])
                for(var x = 0 ; x < response[i].weekdays.length; x++)
                {
                    $("input:checkbox[value='"+response[i].weekdays[x]+"']").attr("checked", true);
                }

                $(".climit[value='12h']").attr("checked", true);
                $("input:text[name=from-time]").val(response[i].from_time);
                $("input:text[name=till-time]").val(response[i].till_time);
                // console.log(response[i].limitation);
            }
            
            
        }
        
    });
    
    $("form#formProfileLimitation").attr("action",url + "?profile="+ profile);
}
</script>