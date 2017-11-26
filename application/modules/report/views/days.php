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
                    <h2>Laporan Harian : Tanggal <?=mdate("%d-%m-%Y", now())?></h2>
                    <div class="widget-toolbar" role="menu">
                        <a class="btn btn-success btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="icofont icofont-file-excel"></span> Excel</a>
                        <a class="btn btn-danger btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="icofont icofont-file-pdf"></span> Pdf</a>
                        <a class="btn btn-primary btn-xs " class=" m-l-10 btn btn-sm btn-primary waves-effect md-trigger" href="#user/add"><span class="icofont icofont-printer"></span> Cetak</a>                        
                    </div>
				</header>
				<div>
					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">
                        <table class="table table-striped table-bordered table-hover table-inverse table-responsive">
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
                                    <?
                                    $i = 1;
                                    $total = 0;
                                    foreach($days->result_array() as $row)
                                    {
                                        $total += $row['price'];
                                        $name = explode("#",$row['deskripsi']);
                                        echo "<tr>
                                                <td>".$i++."</td>
                                                <td>[<b>$name[0]</b>] $name[1]</td>
                                                <td>$row[profile]</td>
                                                <td>$row[date]</td>
                                                <td class='text-right'>".number_format($row['price'],0,',','.')."</td>
                                                <td>$row[first_name] $row[last_name]</td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan='4' class="text-center"><strong> Jumlah</strong></td>
                                        <td class='text-right'><strong><?=number_format($total,0,',','.')?></strong></td>
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