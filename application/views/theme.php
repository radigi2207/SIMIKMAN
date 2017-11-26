<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$page_nav = $this->smartadmin->nav($this->session->userdata('user_id'));

$header['page_title'] = "";
$header['no_main_header'] = false; //set true for lock.php and login.php
$header['page_body_prop'] = array(""); //optional properties for <body>
$header['page_html_prop'] = array(); //optional properties for <html>
$header['router']         = $this->smartadmin->router();
?>
<?$this->load->view('header',$header);?>
<aside id="left-panel">
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as is -->

			<a href="javascript:void(0);" id="show-shortcut" >
				<!-- <img src="<?=base_url('assets/img/avatars/sunny.png')?>" alt="me" class="online" /> -->
				<span>
					<?=$this->session->userdata('username')?>
				</span>
				<i class="fa fa-angle-down"></i>
			</a>

		</span>
	</div>	
	<nav>
	<?
	(!empty($page_nav))? $this->smartadmin->create_nav($page_nav)->print_html():false;
	?>
	</nav>
	<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

</aside>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?=$this->smartadmin->ribbon();?>

	<!-- MAIN CONTENT -->
	<div id="content">
    <?=isset($html) ? $html : ""?>
	</div>
	<!-- END MAIN CONTENT -->
	
</div>
<!-- END MAIN PANEL -->

<!-- FOOTER -->
	<?php
		$this->load->view('footer');
	?>
<!-- END FOOTER -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	$this->load->view('script');
	//include("inc/scripts.php"); 
	//include footer
	//include("inc/google-analytics.php"); 
?>
<script>
$(document).ready(function(){

  

  var index = $('#router-selected').prop('selectedIndex'); 
  var select = $('#router-selected');
  select.change(function(e)
  {
    var text = $(this).find("option:selected").text();
    var id_router = this.value;
    $.SmartMessageBox({
      title : "<i class='zmdi zmdi-router'> Default Router</i>",
      content : "Apakah anda yakin akan mengganti default Router",
      buttons : '[Tidak][Ya]'
    }, function(ButtonPressed) {
      if (ButtonPressed === "Ya") {
        $.ajax({
          url : "<?=site_url("routerSet")?>",
          data:{id_router : id_router},
          type:"get",
          datatype:"json",
          success:function(data){
            var dt = JSON.parse(data);
            $.smallBox({
                title : "Router Default",
                content : "<i>"+dt.msg+"</i>",
                color : dt.color,
                iconSmall : "zmdi zmdi-router bounce animated",
                timeout : 5000
            });
            if(dt['status'] ==  200)
            {
              index= $('#router-selected').prop('selectedIndex');
              setTimeout(function() {
                location.reload();
              },3000);
            }
            else
            {
              $('#router-selected').prop('selectedIndex',index);
            }
            
          },
          error:function(error,hadling)
          {
            $.smallBox({
                title : "Router",
                content : "<i>Maaf tidak bisa terhubung ke perangkat, silahkan cek jaringan atau konfigurasi router anda!</i>",
                color : "#b93b3b",
                iconSmall : "zmdi zmdi-router",
                timeout : 7000
            });
          }
        });
      }
      if(ButtonPressed === "Tidak")
      {
        $('#router-selected').prop('selectedIndex',index);
      }
    });
  });
  
	shortcut.add("F11",function() {
		return false
	});
	shortcut.add("F5",function() {
		var url = location.href.split('#').splice(1).join('#');
		//console.log(url);
		loadURL('<?=base_url()?>/'+ url,$('#content'));
	});
	$("span[data-action=refreshContent],a[data-action=refreshContent]").click(function(){
		var url = location.href.split('#').splice(1).join('#');
		//console.log(url);
		loadURL('<?=base_url()?>/'+ url,$('#content'));
	});
	// var session = setInterval(function(){
	// 		$.ajax({
	// 			url: '<?=site_url('auth/cek_session')?>',
	// 			type: 'POST',
	// 			dataType:'json',
	// 			success:function(data){
	// 				if(!data)
	// 				{
	// 					location.reload();
	// 				}
	// 			}
	// 		});
	// 	}, 1000);

});


if ('addEventListener' in document) {
    document.addEventListener('DOMContentLoaded', function() {
        FastClick.attach(document.body);
    }, false);
}
function terbilang(bilangan) {
 if(bilangan == 0 || bilangan == null)
 {
	 return "0 Rupiah";
 }
 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
 
 var panjang_bilangan = bilangan.length;
 
 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }
 
 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }
 
 i = 1;
 j = 0;
 kaLimat = "";
 
 
 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {
 
   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";
 
   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }
 
   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }
 
   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }
 
   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }
 
   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;
 
 }
 
 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }
 
 return (kaLimat + "Rupiah");
}
function hapus(e,url)
{
  e.preventDefault();
  $.SmartMessageBox({
    title : "<i class='fa fa-trash-o'> Apakah anda yakin akan menghapus data ini?</i>",
    content : "",
    buttons : '[No][Yes]'
  }, function(ButtonPressed) {
    if (ButtonPressed === "Yes") {
      $.ajax({
        url : url,
        success:function(data){
          var dt = JSON.parse(data);
          $("#content").html(dt.html);
        }
      });
    }
    if (ButtonPressed === "No") {
    }

    

  });
  
  
}
</script>

