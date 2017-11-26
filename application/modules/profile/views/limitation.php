<!-- widget grid -->
<section id="widget-grid" class="">
	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-7" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false">
                <header>
                    <h2> Limitations</h2>
                    <div class="widget-toolbar" role="menu">
                    <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="<?=site_url("profile/addLimitation")?>" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span> Limitations</a>
                        <!-- <a class="btn btn-danger btn-xs " type="reset-aplikasi" title="Atur ulang aplikasi" content="Aplikasi akan di atur ulang semua data transaksi akan terhapus. <br>Masukan password aplikasi jika anda yakin akan meng-atur ulang aplikasi !" target="_#" href="setting/resetaplikasi/<?=encode_url($this->session->userdata('id'),'reset')?>"><span class="glyphicon glyphicon-repeat">&nbsp; </span>Reset Aplikasi</a> -->
                        <!-- <a class="btn btn-danger btn-xs" href="javascript:void(0);"><span class="glyphicon glyphicon-repeat "></span> Reset Aplikasi</a> -->
                    </div>
                </header>
                <div class="">
                    <div class="widget-body no-padding">

                        <table class="table table-striped table-bordered nowrap" id="limitationsTable" width="100%">
                            <thead>
                                <tr>
                                    <th data-class="expand">Name</th>
                                    <th data-hide="phone">Owner</th>
                                    <th data-hide="phone">Download</th>
                                    <th data-hide="phone">Upload</th>
                                    <th data-hide="phone">Transfer</th>
                                    <th >Uptime</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($limitations->result_array() as $row)
                                {
                                    echo "<tr>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['owner']."</td>";
                                    echo "<td>".byte_format($row['down_limit'])."</td>";
                                    echo "<td>".byte_format($row['up_limit'])."</td>";
                                    echo "<td>".byte_format($row['trans_limit'])."</td>";
                                    echo "<td>".$row['uptime_limit']."</td>";
                                    echo "<td class='text-center'>
                                        <a class='btn btn-xs text-center btn-primary  icon-btn' href=".site_url("profile/addLimitation/".encode_url($row['id_api'],'limit'))." data-toggle='modal' data-target='#modal'><span class='zmdi zmdi-edit'></a>
                                        <a class='btn btn-xs text-center btn-danger  icon-btn' href='#' onClick='hapus(event,\"".site_url("profile/delLimitation/".encode_url($row["id_api"],'delete'))."\")'><i class='zmdi zmdi-delete'></i></a>
                                    </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                            
                        </table>

                    </div>
                </div>
            </div>
           
		</article>
		<!-- WIDGET END -->

	</div>
</section>
<!-- end widget grid -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="remoteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">        
            
            
            
        </div>
    </div>
</div>

<script type="text/javascript">
	pageSetUp();

    $("#smart-mod-eg1").click(function(e) {
		$.SmartMessageBox({
			title : "Smart Alert!",
			content : "This is a confirmation box. Can be programmed for button callback",
			buttons : '[No][Yes]'
		}, function(ButtonPressed) {
			if (ButtonPressed === "Yes") {

				$.smallBox({
					title : "Callback function",
					content : "<i class='fa fa-clock-o'></i> <i>You pressed Yes...</i>",
					color : "#659265",
					iconSmall : "fa fa-check fa-2x fadeInRight animated",
					timeout : 4000
				});
			}
			if (ButtonPressed === "No") {
				$.smallBox({
					title : "Callback function",
					content : "<i class='fa fa-clock-o'></i> <i>You pressed No...</i>",
					color : "#C46A69",
					iconSmall : "fa fa-times fa-2x fadeInRight animated",
					timeout : 4000
				});
			}

		});
		e.preventDefault();
	})
	
	var pagefunction = function() {
		var responsiveHelper_datatable_fixed_column = undefined;
        var breakpointDefinition = {
				tablet : 1024,
				phone : 480,
                desktop:1440
			};
		var setor = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
        };
        
        var formLimitation = $("#formLimitation").validate({

			// Rules for form validation
			rules : {
				name : {
					required : true
				},
			},            
			// Do not change code below
			errorElement : 'div',
            errorClass:'note note-error',
            // Do not change code below
            errorPlacement : function(error, element) {
                 error.insertAfter(element.parent());
                element.parent().addClass("input-group-danger");
            },
            // Ajax form submition
            // submitHandler : function(form) {
            //     $(form).ajaxSubmit({
            //         success : function(data) {
            //             $.smallBox({
            //                 title : "User",
            //                 content : "<i>Registrasi user berhasil</i>",
            //                 color : "#739E73",
            //                 iconSmall : "fa fa-cubes bounce animated",
            //                 timeout : 3000
            //             });
            //             // $(form).resetForm();
            //             var url = location.href.split('#').splice(1).join('#');
            //             //console.log(url);
            //             loadURL('<?=base_url()?>/'+ url,$('#content'));
            //         }
            //     });
            // },
		});
		
        
	    var otable = $('#limitationsTable').DataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'f>>r>"+
					"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"columnDefs":[{"targets" : 2,
                           "orderable":false}],
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!setor) {
					setor = new ResponsiveDatatablesHelper($('#limitationsTable'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				setor.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				setor.respond();
			}		
		
	    });

	    // Apply the filter
	    $("#limitationsTable thead th input[type=text]").on( 'keyup change', function () {
			console.log(this.value);
	        otable
	            .column( $(this).parent().parent().index()+':visible' )
	            .search( this.value )
	            .draw();
	            
	    } );
	    /* END COLUMN FILTER */   

	};
	// load related plugins
	
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


    function edit(id = null)
    {
        var action = "<?=site_url('profile/addLimitation')?>";
        $("#formLimitation").attr("action",action+"?id="+id);
        $.ajax({
            type: "get",
            url: "<?=site_url("profile/getLimitationid")?>",
            data: {id : id},
            dataType: "json",
            success: function (response) {

                if(response.owner.length >= 1)
                {
                    $("input[name=name]").val(response.name);
                    $("input[name=owner]").val(response.owner);
                    $("input[name=upload-limit]").val(response.upload_limit);
                    $("input[name=download-limit]").val(response.download_limit);
                    $("input[name=transfer-limit]").val(response.transfer_limit);
                    $("input[name=uptime-limit]").val(response.uptime_limit);
                    $("input[name=ip-pool]").val(response.ip_pool);
                    $("input[name=address-list]").val(response.address_list);
                    $("input[name=group-name]").val(response.group_name);
                }
            },
            error : function() {
                $("#formLimitation").attr("action",action);
                $("#formLimitation").resetForm();
            }
        });
    }
</script>