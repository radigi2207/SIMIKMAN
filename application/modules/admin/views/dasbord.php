<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/activity.css">
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span>> My Dashboard</span></h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
		<ul id="sparks" class="">
		<li class="sparks-info">
				<h5> Hari ini <span class="txt-color-green text-right"><?=number_short($pendapatan->hari_ini)?></span></h5>				
			</li>
			<li class="sparks-info">
				<h5> Bulan Sekarang <span class="txt-color-blue text-right"><?=number_short($pendapatan->bulan_ini)?></span></h5>				
			</li>
			
			<li class="sparks-info">
				<h5> Total User <span class="txt-color-greenDark"><i class="fa fa-users"></i>&nbsp;<?=$user->count?></span></h5>			</li>
		</ul>
	</div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
	<div class="row">
		<article class="col-sm-12">
			<div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
				<header>
					<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
					<h2>Live Feeds </h2>

					<ul class="nav nav-tabs pull-right in" id="myTab">
						<li class="active">
							<a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Live Stats</span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#s2"><i class="fa fa-facebook"></i> <span class="hidden-mobile hidden-tablet">Social Network</span></a>
						</li>
					</ul>

				</header>
				<div class="no-padding">
					<div class="jarviswidget-editbox">
						test
					</div>
					<div class="widget-body">
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
								
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
										<div class="widget-body-toolbar bg-color-white">
											<div class="header-search ">
												<span class="select">
													<select class="input-sm" name="interface">
													<?
													foreach ($interface as $row) {
														echo "<option value='".$row['name']."'>".$row['name']."</option>";
													}
													?>
												</select><i></i></span>
											</div>
										</div>
										<div  class="chart-large txt-color-blue" id="graph-interface">
											
										</div>

									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12">
												<h3 class="text-right nmb"><?=$sysinfo['board-name']?> <small><?=$routerboard['current-firmware']?></small></h3>
												<h3 class="text-right nmt"><?=$sysinfo['cpu']?> </h3>
											</div>
										</div>
                                        <?
                                        $up = (isset($paket->upload))?(($paket->upload/536870912000) *100):0;
                                        $down = isset($paket->download)?($paket->download/805306368000) *100:0;
										$notaktif = isset($user->aktif)? round(($user->aktif/$user->count)*100):0;
										?>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Upload <span class="pull-right"><?=byte_format(isset($paket->upload)?$paket->upload:0);?></span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blueDark" style="width:<?=$up;?>%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Download <span class="pull-right"><?=byte_format(isset($paket->download)?$paket->download:0);?></span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blue" style="width:<?=$down;?>%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Transfer <span class="pull-right"><?=byte_format(isset($paket->download) ? $paket->upload + $paket->download:0);?></span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blue" style="width:<?=$down-$up;?>%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> User Aktif <span class="pull-right"><?=$user->aktif?></span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-greenLight" style="width: <?=$notaktif?>%;"></div>
												</div> </div>
										</div>
									</div>
								</div>
								<div class="show-stat-microcharts">
									<?
									$cpu = $sysinfo['cpu-load'];
									$hdd = $sysinfo['total-hdd-space'];
									$free= $sysinfo['free-hdd-space'];
									$hdd = round((($hdd - $free) / $hdd) * 100) ;
									?>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

										<div class="easy-pie-chart txt-color-orangeDark" data-percent="<?=$cpu?>" data-pie-size="50">
											<span class="percent percent-sign"><?=$cpu?></span>
										</div>
										<span class="easy-pie-title"> CPU Load</span>
										<span class="easy-pie-title"><?=$sysinfo['cpu']?></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-greenLight"><i class="fa fa-caret-up"></i> <?=100-$cpu?>%</span>
											</li>
											<li>
												<span class="label bg-color-blueLight"><i class="fa fa-caret-down"></i> <?=$cpu?>%</span>
											</li>
										</ul>
									</div>
									
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-greenLight" data-percent="<?=$hdd?>" data-pie-size="50">
											<span class="percent percent-sign"><?=$hdd?>% </span>
										</div>
										<span class="easy-pie-title"> Disk Space </span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> <?=$hdd?>%</span>
											</li>
											<li>
												<span class="label bg-color-blue"><i class="fa fa-caret-down"></i> <?=100-$hdd?>%</span>
											</li>
										</ul>
									</div>
									<?
									$mem = $sysinfo['total-memory'];
									$free= $sysinfo['free-memory'];
									$mem = round((($mem - $free) / $mem) * 100) ;
									?>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-blue" data-percent="<?=$mem?>" data-pie-size="50">
											<span class="percent percent-sign"><?=$mem?>% </span>
										</div>
										<span class="easy-pie-title"> Memory Space <i class="fa fa-caret-up icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-darken"><i class="fa fa-caret-up"></i><?=$mem?>%</span>
											</li>
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-down"></i> <?=100-$mem?>%</span>
											</li>
										</ul>
										
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<h4 class="pull-left padding-top-10 padding-bottom-10"><?=$sysinfo['uptime']?></h4>
										<h5 class="pull-right padding-bottom-15"><i class="fa fa-clock-o"></i> Uptime</h5>
										
										
									</div>
								</div>

							</div>
							<!-- end s1 tab pane -->

							<div class="tab-pane fade" id="s2">
								<div class="widget-body-toolbar bg-color-white">

									<form class="form-inline" role="form">

										<div class="form-group">
											<label class="sr-only" for="s123">Show From</label>
											<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
										</div>
										<div class="form-group">
											<input type="email" class="form-control input-sm" id="s124" placeholder="To">
										</div>

										<div class="btn-group hidden-phone pull-right">
											<a class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> More <span class="caret"> </span> </a>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:void(0);"><i class="fa fa-file-text-alt"></i> Export to PDF</a>
												</li>
												<li>
													<a href="javascript:void(0);"><i class="fa fa-question-sign"></i> Help</a>
												</li>
											</ul>
										</div>

									</form>

								</div>
								<div class="padding-10">
									<div id="statsChart" class="chart-large has-legend-unique"></div>
								</div>

							</div>
							<!-- end s2 tab pane -->
						</div>

						<!-- end content -->
					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>
	</div>

	<!-- end row -->

	<!-- row -->

	<div class="row">

		<article class="col-sm-12 col-md-12 col-lg-8">

			<!-- new widget -->
			<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-fullscreenbutton="false">


				<header>
					<span class="widget-icon"> <i class=""></i> </span>
					<h2>Log User</h2>					
				</header>

				<!-- widget div-->
				<div>
					<div class="widget-body widget-hide-overflow no-padding">
						<!-- content goes here -->
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Waktu</th>
									<th>Deskripsi</th>
                                    <th>Ip address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $i = 1;
                                foreach ($userlogin as $row) {
                                    echo "<tr>
                                            <td>".$i++."</td>
                                            <td>".$row['date']."</td>
                                            <td>".$row['description']."</td>
                                            <td>".$row['ip']."</td>
                                            </tr>";
                                }
                                ?>
                                
                            </tbody>
                        </table>
						<!-- end content -->
					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>

		<article class="col-sm-12 col-md-12 col-lg-4">

			<!-- new widget -->
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false">

				

				<header>
					<span class="widget-icon"> <i class="icofont icofont-history"></i> </span>
					<h2> Aktivitas Log </h2>
					
				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<div>
							<label>Title:</label>
							<input type="text" />
						</div>
					</div>
					<!-- end widget edit box -->

					<div class="widget-body">
						<!-- content goes here -->
                        <div class=" activities">
                            
                            <ul class="list-unstyled">
                            <?
                            foreach ($logs as $row) {
                                echo '    <li class="primary">
                                <span class="point"></span>
                                <span class="time small text-muted">'.relative_time($row['date']).'</span>
                                <p>'.$row['description'].'</p>
                                </li>';
                            }
                            ?>
                        
                            </ul>
                                
                        </div>
						<!-- end content -->

					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>

	</div>

	<!-- end row -->

</section>
<!-- end widget grid -->

<script src="<?php echo base_url('assets') ?>/js/highcharts.js"></script>
<script type="text/javascript">
	
var chart;
function requestDatta() {
	var interface = $("select[name=interface]").val();

	$.ajax({
		url: "<?=site_url("admin/monitorInterface")?>",
		datatype: "json",
		data : {interface : interface},
		success: function(data) {
			var dt = JSON.parse(data);
			if( dt.length > 0 ) {
				var Tx=parseInt(dt[0].tx);
				var Rx=parseInt(dt[0].rx);
				var x = (new Date()).getTime(); 
				shift=chart.series[0].data.length > 19;
				chart.series[0].addPoint([x, Tx], true, shift);
				chart.series[1].addPoint([x, Rx], true, shift);
				$("graph-byte-tx").html(Tx);
				$("graph-byte-rx").html(Rx);
			}else{
				$("graph-byte-tx").html("-/-");
			}
		}
	});
}	

$(document).ready(function() {
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
	chart = new Highcharts.Chart({
		colors: ["#2196F3","#FF0000"],
		chart: {
			renderTo: 'graph-interface',
			animation: Highcharts.svg,
			type: 'line',
			events: {
				load: function () {
					setInterval(function () {
						requestDatta();
					}, 1000);
				}				
			}
		},
		title: {
			text: ' ' 
		},
		xAxis: {
			type: 'datetime',
			tickPixelInterval: 150,
			maxZoom: 20 * 1000
		},
		yAxis: {
			minPadding: 0,
			maxPadding: 0,
			title: {
				text: '',
				margin: 0
			}
		},
		series: [{
			name: 'TX',
			data: []
		}, {
			name: 'RX',
			data: []
		}]
	});
});

	pageSetUp();
	
	/*
	 * PAGE RELATED SCRIPTS
	 */

	// pagefunction
	
	var pagefunction = function() {
			
		$(".js-status-update a").click(function () {
		    var selText = $(this).text();
		    var $this = $(this);
		    $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
		    $this.parents('.dropdown-menu').find('li').removeClass('active');
		    $this.parent().addClass('active');
		});
		
		/*
		 * TODO: add a way to add more todo's to list
		 */
		
		// initialize sortable
		
	    $("#sortable1, #sortable2").sortable({
	        handle: '.handle',
	        connectWith: ".todo",
	        update: countTasks
	    }).disableSelection();
		
		
		// check and uncheck
		$('.todo .checkbox > input[type="checkbox"]').click(function () {
		    var $this = $(this).parent().parent().parent();
		
		    if ($(this).prop('checked')) {
		        $this.addClass("complete");
		
		        // remove this if you want to undo a check list once checked
		        //$(this).attr("disabled", true);
		        $(this).parent().hide();
		
		        // once clicked - add class, copy to memory then remove and add to sortable3
		        $this.slideUp(500, function () {
		            $this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
		            $this.remove();
		            countTasks();
		        });
		    } else {
		        // insert undo code here...
		    }
		
		})
		// count tasks
		function countTasks() {
		
		    $('.todo-group-title').each(function () {
		        var $this = $(this);
		        $this.find(".num-of-tasks").text($this.next().find("li").size());
		    });
		
		}
		
		/*
		 * RUN PAGE GRAPHS
		 */

		
		

		function renderVectorMap() {
		    $('#vector-map').vectorMap({
		        map: 'world_mill_en',
		        backgroundColor: '#fff',
		        regionStyle: {
		            initial: {
		                fill: '#c4c4c4'
		            },
		            hover: {
		                "fill-opacity": 1
		            }
		        },
		        series: {
		            regions: [{
		                values: data_array,
		                scale: ['#85a8b6', '#4d7686'],
		                normalizeFunction: 'polynomial'
		            }]
		        },
		        onRegionLabelShow: function (e, el, code) {
		            if (typeof data_array[code] == 'undefined') {
		                e.preventDefault();
		            } else {
		                var countrylbl = data_array[code];
		                el.html(el.html() + ': ' + countrylbl + ' visits');
		            }
		        }
		    });
		}
		
		/*
		 * FULL CALENDAR JS
		 */
		
		// Load Calendar dependency then setup calendar
		
		loadScript("assets/js/plugin/moment/moment.min.js", function(){
			loadScript("assets/js/plugin/fullcalendar/jquery.fullcalendar.min.js", setupCalendar);
		});
		
		function setupCalendar() {
		
		    if ($("#calendar").length) {
		        var date = new Date();
		        var d = date.getDate();
		        var m = date.getMonth();
		        var y = date.getFullYear();
		
		        calendar = $('#calendar').fullCalendar({
		
		            editable: true,
		            draggable: true,
		            selectable: false,
		            selectHelper: true,
		            unselectAuto: false,
		            disableResizing: false,
					height: "auto",
					
		            header: {
		                left: 'title', //,today
		                center: 'prev, next, today',
		                right: 'month, agendaWeek, agenDay' //month, agendaDay,
		            },
		
		            select: function (start, end, allDay) {
		                var title = prompt('Event Title:');
		                if (title) {
		                    calendar.fullCalendar('renderEvent', {
		                            title: title,
		                            start: start,
		                            end: end,
		                            allDay: allDay
		                        }, true // make the event "stick"
		                    );
		                }
		                calendar.fullCalendar('unselect');
		            },
		
		            events: [{
		                title: 'All Day Event',
		                start: new Date(y, m, 1),
		                description: 'long description',
		                className: ["event", "bg-color-greenLight"],
		                icon: 'fa-check'
		            }, {
		                title: 'Long Event',
		                start: new Date(y, m, d - 5),
		                end: new Date(y, m, d - 2),
		                className: ["event", "bg-color-red"],
		                icon: 'fa-lock'
		            }, {
		                id: 999,
		                title: 'Repeating Event',
		                start: new Date(y, m, d - 3, 16, 0),
		                allDay: false,
		                className: ["event", "bg-color-blue"],
		                icon: 'fa-clock-o'
		            }, {
		                id: 999,
		                title: 'Repeating Event',
		                start: new Date(y, m, d + 4, 16, 0),
		                allDay: false,
		                className: ["event", "bg-color-blue"],
		                icon: 'fa-clock-o'
		            }, {
		                title: 'Meeting',
		                start: new Date(y, m, d, 10, 30),
		                allDay: false,
		                className: ["event", "bg-color-darken"]
		            }, {
		                title: 'Lunch',
		                start: new Date(y, m, d, 12, 0),
		                end: new Date(y, m, d, 14, 0),
		                allDay: false,
		                className: ["event", "bg-color-darken"]
		            }, {
		                title: 'Birthday Party',
		                start: new Date(y, m, d + 1, 19, 0),
		                end: new Date(y, m, d + 1, 22, 30),
		                allDay: false,
		                className: ["event", "bg-color-darken"]
		            }, {
		                title: 'Smartadmin Open Day',
		                start: new Date(y, m, 28),
		                end: new Date(y, m, 29),
		                className: ["event", "bg-color-darken"]
		            }],
		
		            eventRender: function (event, element, icon) {
		                if (!event.description == "") {
		                    element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description + "</span>");
		                }
		                if (!event.icon == "") {
		                    element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon + " '></i>");
		                }
		            }
		        });
		
		    };
		
		    /* hide default buttons */
		    $('.fc-toolbar .fc-right, .fc-toolbar .fc-center').hide();
		
		}
		
		// calendar prev
		$('#calendar-buttons #btn-prev').click(function () {
		    $('.fc-prev-button').click();
		    return false;
		});
		
		// calendar next
		$('#calendar-buttons #btn-next').click(function () {
		    $('.fc-next-button').click();
		    return false;
		});
		
		// calendar today
		$('#calendar-buttons #btn-today').click(function () {
		    $('.fc-button-today').click();
		    return false;
		});
		
		// calendar month
		$('#mt').click(function () {
		    $('#calendar').fullCalendar('changeView', 'month');
		});
		
		// calendar agenda week
		$('#ag').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaWeek');
		});
		
		// calendar agenda day
		$('#td').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaDay');
		});
		
		/*
		 * CHAT
		 */
		
		var filter_input = $('#filter-chat-list'),
			chat_users_container = $('#chat-container > .chat-list-body'),
			chat_users = $('#chat-users'),
			chat_list_btn = $('#chat-container > .chat-list-open-close'),
			chat_body = $('#chat-body');
		
		/*
		 * LIST FILTER (CHAT)
		 */
		
		// custom css expression for a case-insensitive contains()
		jQuery.expr[':'].Contains = function (a, i, m) {
		    return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
		};
		
		function listFilter(list) { 
			// header is any element, list is an unordered list
		    // create and add the filter form to the header
		
		    filter_input.change(function () {
		        var filter = $(this).val();
		        if (filter) {
		            // this finds all links in a list that contain the input,
		            // and hide the ones not containing the input while showing the ones that do
		            chat_users.find("a:not(:Contains(" + filter + "))").parent().slideUp();
		            chat_users.find("a:Contains(" + filter + ")").parent().slideDown();
		        } else {
		            chat_users.find("li").slideDown();
		        }
		        return false;
		    }).keyup(function () {
		        // fire the above change event after every letter
		        $(this).change();
		
		    });
		
		}
		
		
	
	};
	
	// end pagefunction

	// destroy generated instances 
	// pagedestroy is called automatically before loading a new page
	// only usable in AJAX version!

	var pagedestroy = function(){
		
		// destroy calendar
		calendar.fullCalendar('destroy');
		calendar = null;

		//destroy flots
		flot_updating_chart.shutdown();  
		flot_updating_chart=null;
		flot_statsChart.shutdown(); 
		flot_statsChart = null;

		flot_multigraph.shutdown(); 
		flot_multigraph = null;

		// destroy vector map objects
		$('#vector-map').find('*').addBack().off().remove();

		// destroy todo
		$("#sortable1, #sortable2").sortable("destroy");
		$('.todo .checkbox > input[type="checkbox"]').off();

		// destroy misc events
		$("#rev-toggles").find(':checkbox').off();
		$('#chat-container').find('*').addBack().off().remove();

		// debug msg
		if (debugState){
			root.console.log("✔ Calendar, Flot Charts, Vector map, misc events destroyed");
		} 

	}

	// end destroy
	
	// run pagefunction on load
	pagefunction();
	
	
</script>
