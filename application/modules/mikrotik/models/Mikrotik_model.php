<?
class Mikrotik_model extends CI_Model {
	protected $API ;
	protected $host,$user,$pass,$port,$id_router,$user_id;
	protected $weekday = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
	protected $month   = array("jan" => "01",
							   "feb" => "02",
							   "mar" => "03",
							   "apr" => "04",
							   "may" => "05",
							   "jun" => "06",
							   "jul" => "07",
							   "aug" => "08",
							   "sep" => "09",
							   "oct" => "10",
							   "nov" => "11",
							   "dec" => "12" );
    function __construct() {
        parent::__construct(); 
        $this->load->library('RouterosAPI');
		$this->API = new RouterosAPI();
		$this->host = ($this->session->userdata('host'))? $this->session->userdata('host') : "";
		$this->user = ($this->session->userdata('user'))? $this->session->userdata('user') : "";
		$this->pass = ($this->session->userdata('pass'))? $this->session->userdata('pass') : "";
		$this->API->port = ($this->session->userdata('port'))? $this->session->userdata('port') : "";
		$this->id_router = ($this->session->userdata("id_router"))?$this->session->userdata("id_router") : NULL;
		$this->user_id = ($this->session->userdata("user_id"))?$this->session->userdata("user_id") : NULL;
		
	}

	function x()
	{
		//$this->API->comm("/tool/user-manager/user/create-and-activate-profile",
		$this->open();
		$this->API->write("/tool/user-manager/user/getall");
		
		$READ = $this->API->read(true);
		return $READ;
	}

	function checkPackage()
	{
		$this->open();
		$this->API->write("/system/package/getall");
		
		$READ = $this->API->read(true);
		return $READ;
	}

	function check_conn($data)
	{
		$this->user = $data['user'];
		$this->host = $data['host'];
		$this->pass = $data['pass'];
		$this->API->port = $data['port'];

		return $this->open();
	}

	function save_router($data)
	{
		$data['user_id'] = $this->session->userdata("user_id");
		$data['hash']	 = encode_url($this->session->userdata("user_id"),'mikrotikkey');

		$this->db->insert('tb_user_router', $data);
		$id = $this->db->insert_id();

		$this->db->where("id", $data['user_id'] );
		$this->db->set("status","ACTIVE");
		$this->db->update('tb_user');

		$this->db->where('id', $id);
		return $this->db->get('tb_user_router');
		
		
		
	}

	function editRouter($data,$id)
	{
		$this->db->where('id', $id);
		return $this->db->update('tb_user_router', $data);
	}

	function getUsermik()
	{
		$this->open();
		$this->API->write("/tool/user-manager/user/getall",false);
		$this->API->write("?username=radigi");
		$READ = $this->API->read(true);
		return $READ;
	}

	//mengambil user hotspot userman
	function getUser()
	{
		$this->open();
		$this->API->write("/tool/user-manager/user/getall");
		$READ = $this->API->read(true);
		return $READ;
	}

	//Menambah User baru *
	function addUser($data, $id)
	{
		if($this->open())
		{
			$data['customer'] 	= $this->session->userdata('user');			
			if($id == NULL)
			{
				$this->API->comm("/tool/user-manager/user/add",$data);
			}
			else
			{
				$data['.id'] = $id[1];
				if($data['password'] == "#passwordsebelumnya#") unset($data['password']);
				$this->API->comm("/tool/user-manager/user/set",$data);
			}
	
			$this->API->write("/tool/user-manager/user/getall",false);
			$this->API->write("?username=$data[username]");
			$READ = $this->API->read(true);
	
			if(count($READ) == 1  && isset($READ[0]['.id']))
			{
				$this->db->trans_begin();
				$row = $READ[0];
				$data = array(	"id"		=> NULL,
								"id_api"=> $row['.id'],
								"customer" 	=> $row['customer'],
								"actual_profile" => (isset($row['actual-profile']))?$row['actual-profile']:"",
								"username" 	=> $row['username'],
								"password" 	=> $row['password'],
								"download"	=> (isset($row['download-used']))?$row['download-used']:"",
								"upload"	=> (isset($row['upload-used']))?$row['upload-used']:"",
								"time_used"	=> (isset($row['uptime-used']))?$row['uptime-used']:"",
								"disabled"	=> $row['disabled'],
								"comment"	=> isset($row['comment'])?	$row['comment'] : "",
								"first_name"=> (isset($row['first-name']))?$row['first-name']:"",
								"last_name"	=> (isset($row['last-name']))?$row['last-name']:"",
								"no_tlp"	=> (isset($row['phone']))?$row['phone']:"",
								"alamat"	=> (isset($row['location']))?$row['location']:"",
								"status"	=> (isset($row['active']))?$row['active']:false,
								"id_router"	=> $this->id_router,
								"email"		=> isset($row['email'])? $row['email'] : ""
	
				);

				if($id != NULL)
				{
					
					//Update data userman
					$this->db->where('id', $id[0]);
					$this->db->update('tb_userman', $data);
					logs("Admin","[Admin]: user berhasil diperbaharui");

				}
				else
				{
					$this->db->insert("tb_userman",$data);
					$id = $this->db->insert_id();
					logs("Admin","[Admin]: user berhasil ditambahkan");
				}
				
				$this->db->trans_commit();
				return true;
	
			}
		}		
		return false;
	}

	//Menambah user profile *
	function userTransaksi($id)
	{
		if(is_array($id))
		{
			$this->db->trans_begin();
			$this->db->where('id_router', $this->id_router);
			$this->db->where('name', $id['profile']);
			$profile = $this->db->get('tb_profile');
			if($profile->num_rows() == 1)
			{
				$profile = $profile->row();
				$this->db->select('id_api, username,first_name,last_name');				
				$this->db->where('id', $id['id']);
				$user = $this->db->get('tb_userman');
				if($user->num_rows() == 1 && $this->open())
				{
					$user = $user->row();
					$this->API->write("/tool/user-manager/user/clear-profiles",false);
					$this->API->write("=.id=".$user->id_api);
					$READ = $this->API->read(true);

					$this->API->comm("/tool/user-manager/user/create-and-activate-profile",
									array(	"customer" => $this->session->userdata('user'),
											"profile"  => $id['profile'],
											"numbers"  => $user->username));
					
					$this->db->set("actual_profile", $id['profile']);
					$this->db->where('id', $id['id']);
					$this->db->update('tb_userman');

					$trans = array(	"id_router"	=> $this->id_router,
									"status"	=> "INACTIVE",
									"profile"	=> $id['profile'],
									"price"		=> $profile->price,
									"user_id"	=> $id['id'],
									"operator_id"=> $this->session->userdata("user_id"),
									"deskripsi"	=> $user->username."#".$user->first_name." ".$user->last_name);
		
					$this->db->insert('tb_transaksi', $trans);
					logs("Admin","[Trans]: pembelian voucher ". $profile->name. " harga #".number_format($profile->price,0,',','.'));
					$this->db->trans_commit();
				}
								
			}
			$this->db->trans_rollback();
			return ;
		}
		$this->db->join('tb_profile p', 'r.profile = p.name');	
		$this->db->where('r.user_id', $id);
		$this->db->where('p.id_router', $this->id_router);			
		$this->db->order_by('r.date', 'desc');
		
		$data = $this->db->get('tb_transaksi r');
		return $data;
		
		
	}

	//Menghapur User *
	function delUser($id)
	{
		$user = $this->db->where('id', $id)
						 ->get('tb_userman')->row();
		
		
		$this->open();
		$this->API->write("/tool/user-manager/user/remove",false);
		$this->API->write("=numbers=".$user->id_api);
		$READ = $this->API->read(true);

		$this->API->write("/tool/user-manager/user/getall",false);
		$this->API->write("?numbers=".$user->id_api);
		$READ = $this->API->read(true);
		if(count($READ) ==  0)
		{
			$this->db->where("id",$id)
					 ->delete("tb_userman");

		}
		return $READ;
	}
	//Mengambil data Profile *
	function getProfile($id = NULL)
	{

		$this->db->select("*");
		($id != NULL) ?  $this->db->where('id', $id) : false;		
		$this->db->where('id_router', $this->id_router);
		return $this->db->get("tb_profile");
		
	}

	//Menambah profile baru *
	function addProfile($data,$id)
	{
		
		$this->db->trans_begin();
		if($id != NULL)
		{
			$id = decode_url($id,'edit');
			$this->db->where('id_router', $this->id_router);
			$this->db->where('id', $id);
			$this->db->update('tb_profile', $data);
			if($this->open())
			{
				$id_api =  $this->db->select("id_api")
									->where("id", $id)
									->where("id_router", $this->id_router)
									->get("tb_profile")
									->row();
				if(count($id_api) == 1)
				{					
					$prof =  array(	".id"					=> $id_api->id_api,
									"name" 					=> $data['name'],
									"name-for-users"		=> $data['nameforusers'],
									"override-shared-users"	=> $data['overridesharedusers'],
									"price"					=> $data['price'],
									"starts-at" 			=> $data['starts_at'],
									"validity"				=> $data['validity'],
									"owner"  				=> $this->session->userdata('user'));

					$this->API->comm("/tool/user-manager/profile/set",$prof);
				}
				
				$this->db->trans_commit();
				return true;
			}
			else
			{
				$this->db->trans_rollback();
				return false;
			}
		}
		else
		{
			$data['id_router'] = $this->id_router;
			$this->db->insert('tb_profile', $data);
			$id = $this->db->insert_id();			
			if($this->open())
			{
				$data =  array(				
								"name" 					=> $data['name'],
								"name-for-users"		=> $data['nameforusers'],
								"override-shared-users"	=> $data['overridesharedusers'],
								"price"					=> $data['price'],
								"starts-at" 			=> $data['starts_at'],
								"validity"				=> $data['validity'],
								"owner"  				=> $this->session->userdata('user')
							);				
				$this->API->comm("/tool/user-manager/profile/add",$data);
				$this->API->write("/tool/user-manager/profile/getall",false);
				$this->API->write("?name=".$data['name']);
				$READ = $this->API->read(true);
				if(count($READ) && isset($READ[0]))
				{
					$READ = $READ[0];
					if(isset($READ['.id']))
					{
						$this->db->set("id_api",$READ['.id']);
						$this->db->where('id', $id);
						
						$this->db->update('tb_profile');					
						$this->db->trans_commit();
						return true;
					}
					else
					{
						$this->db->trans_rollback();
						return false;
					}
					
				}
				
			}
			else
			{
				$this->db->trans_rollback();
				return false;
			}			
		}
	}

	// Menghapus data Profile *
	function delProfile($id)
	{
		$this->db->trans_begin();
		$this->db->where('id_router', $this->id_router);
		$this->db->where('id_api', $id);
		$this->db->delete('tb_profile');
		if($this->open())
		{
			$this->API->write("/tool/user-manager/profile/remove",false);
			$this->API->write("=.id=".$id);
			$READ = $this->API->read(true);
			$this->db->trans_commit();
		}
		else
		{
			$this->db->trans_rollback();
		}
	}
	
	// Mengambil data liitation *
	function getLimitation()
	{
		$this->db->where('id_router', $this->id_router);
		return $this->db->get('tb_limit');
		
		
	}

	// Menambah data limitation *
	function addLimitation($data, $id)
	{

		$new_data = array();
		foreach ($data as $key => $value) 
		{
			if(strlen($value) != 0)
			{
				$value = ($key == "download-limit")? byte($value) : $value;
				$value = ($key == "upload-limit") ? byte($value) : $value;
				$value = ($key == "transfer-limit") ? byte($value) : $value;
				$new_data[$key] = $value;
			}

		}

		if($this->open())
		{

			if($id != NULL)
			{
				$new_data['.id'] = $id;
				$hasil = $this->API->comm("/tool/user-manager/profile/limitation/set",$new_data);
				$this->API->write("/tool/user-manager/profile/limitation/getall",false);
				$this->API->write("?name=".$new_data['name']);
				$READ = $this->API->read(true);
				
				if(count($READ) == 1 && isset($READ[0]))
				{
					$READ = $READ[0];
					$limit = array(	
									'name' 		=> $READ['name'],
									'owner' 	=> $READ['owner'],
									'down_limit'	=>	$READ['download-limit'],
									'up_limit'		=> $READ['upload-limit'],
									'trans_limit'	=> $READ['transfer-limit'],
									'ip_pool'		=> $READ['ip-pool'],
									"add_list"		=> $READ['address-list'],
									"id_api"		=> $READ['.id'],
									"uptime_limit"	=> $READ['uptime-limit'],
									"group_name"	=> $READ['group-name']
					);

					$this->db->where('id_api', $READ['.id']);
					$this->db->where('id_router', $this->id_router);
					$this->db->update('tb_limit', $limit);
				}
				
				return true;

			}

			$new_data['owner'] = $this->session->userdata('user');
			$this->API->comm("/tool/user-manager/profile/limitation/add",$new_data);
			$this->API->write("/tool/user-manager/profile/limitation/getall",false);
			$this->API->write("?name=".$new_data['name']);
			$READ = $this->API->read(true);
			if(count($READ) == 1 && isset($READ[0]))
			{
				$READ = $READ[0];
				$limit = array(	'id' 		=> NULL,
								'name' 		=> $READ['name'],
								'owner' 	=> $READ['owner'],
								'down_limit'	=>	$READ['download-limit'],
								'up_limit'		=> $READ['upload-limit'],
								'trans_limit'	=> $READ['transfer-limit'],
								'ip_pool'		=> $READ['ip-pool'],
								"add_list"		=> $READ['address-list'],
								"id_api"		=> $READ['.id'],
								"uptime_limit"	=> $READ['uptime-limit'],
								"id_router"		=> $this->id_router,
								"group_name"	=> $READ['group-name']
				);
				$this->db->insert('tb_limit', $limit);
				return true;
				
			}
			else
			{
				return false;
			}
			
			
		}
		
	}

	//Hapus Profile Limitation *
	function delProfileLimitation($id)
	{
		$this->db->trans_begin();
		$this->db->where('id_api', $id);
		$this->db->where("id_router",$this->id_router);
		$this->db->delete('tb_limit');

		if($this->open())
		{
			$this->API->write("/tool/user-manager/profile/limitation/remove",false);
			$this->API->write("=numbers=".$id);
			$READ = $this->API->read(true);
			$this->db->trans_commit();
		}
		else
		{
			$this->db->trans_rollback();
		}
		
	}

	function getLimitationid($id)
	{

		$this->db->where('id_api', $id);
		$this->db->where('id_router', $this->id_router);
		return $this->db->get('tb_limit');
	}

	//Menambah Profil Limitation *
	function addProfileLimitation($data,$profile)
	{
		
		if($this->open())
		{
		
			$profLimitation = $this->getProfileLimitationid($profile);
			if(count($profLimitation) != 0)
			{
				foreach ($profLimitation as $row) {
					$this->API->write("/tool/user-manager/profile/profile-limitation/remove",false);
					$this->API->write("=numbers=".$row['.id']);
					$READ = $this->API->read(true);
				}
			}

			if(isset($data['limitation']))
			{
				foreach ($data['limitation'] as $row) {
					$limitations = array("profile"	=> $profile,
										"limitation"	=> $row,
										"from-time"	=> (mdate("%Hh%im%ss",strtotime($data['from_time'])) != "00h00m00s")? mdate("%Hh%im%ss",strtotime($data['from_time'])): "0s",
										"till-time"	=> (mdate("%Hh%im%ss",strtotime($data['till_time'])) != "00h00m00s")? mdate("%Hh%im%ss",strtotime($data['till_time'])): "0s",
										"weekdays"		=> join($data['weekdays'],","));

					$this->API->comm("/tool/user-manager/profile/profile-limitation/add",$limitations);
				}
			}
			else
			{
				$limitations = array(	"profile"	=> $profile,
										"from-time"	=> (mdate("%Hh%im%ss",strtotime($data['from_time'])) != "00h00m00s")? mdate("%Hh%im%ss",strtotime($data['from_time'])): "0s",
										"till-time"	=>(mdate("%Hh%im%ss",strtotime($data['till_time'])) != "00h00m00s")? mdate("%Hh%im%ss",strtotime($data['till_time'])): "0s",
										"weekdays"		=> join($data['weekdays'],","));

				$this->API->comm("/tool/user-manager/profile/profile-limitation/add",$limitations);

			}

			return $limitations;
		}
		
	}


	function getProfileLimitationid($profile = NULL)
	{
		if(!$this->open())
		{
			return array();
		}
		$this->API->write("/tool/user-manager/profile/profile-limitation/getall",false);
		$this->API->write("?profile=".$profile);
		$READ = $this->API->read(true);
		return $READ;
	}
	
	public function getRouter()
	{
		$this->open();
		$this->API->write("/tool/user-manager/router/getall");
		$READ = $this->API->read(true);
		return $READ;
	}

	//Menambahkan dan mengubah radius server **
	function addRadius($data,$id)
	{
		if($this->open())
		{
			$ndata = array(	"customer"	=> $this->session->userdata('user'),
							"name"		=> $data['name'],
							"shared-secret"=> $data['secret'],
							"ip-address"	=> $data['ip']);
			if($id != NULL)
			{
				$id = decode_url($id,'edit');
				$ndata['.id'] = $id;
				$this->API->comm("/tool/user-manager/router/set",$ndata);
				$this->API->write("/tool/user-manager/router/getall",false);
				$this->API->write("?name=".$data['name'],false);
				$this->API->write("?shared-secret=".$data['secret'],false);
				$this->API->write("?ip-address=".$data['ip']);
				$READ = $this->API->read(true);
				if(!empty($READ))
				{
					$READ = $READ[0];
					$this->db->where('id_router', $this->id_router);
					$this->db->where('id_api', $id);
					$data['id_api']		= $READ['.id'];
					$this->db->update('tb_radius_server', $data);
				}
			}
			else
			{
				$this->API->comm("/tool/user-manager/router/add",$ndata);
				$this->API->write("/tool/user-manager/router/getall",false);
				$this->API->write("?name=".$data['name']);
				$READ = $this->API->read(true);
				if(!empty($READ))
				{
					$READ = $READ[0];
					$data['user_id'] 	= $this->session->userdata('user_id');
					$data['id_router'] 	= $this->id_router;
					$data['id_api']		= $READ['.id'];
					$this->db->insert('tb_radius_server', $data);
				}
			}			
		}
	}

	//Hapus Radius Server **
	function delRadius($id)
	{
		$this->db->trans_begin();
		$this->db->where('id_router', $this->id_router);
		$this->db->where('id_api', $id);
		$this->db->delete('tb_radius_server');
		if($this->open())
		{
			$this->API->write("/tool/user-manager/router/remove",false);
			$this->API->write("=.id=".$id);
			$READ = $this->API->read(true);
			$this->API->write("/tool/user-manager/router/getall",false);
			$this->API->write("?.id=".$id);
			$READ = $this->API->read(true);
			if(count($READ) == 0)
			{
				$this->db->trans_commit();
			}
			else
				$this->db->trans_rollback();
		}
		else
			$this->db->trans_rollback();
		
		
		return;
	}

	function genRouter()
	{
		if($this->open())
		{
			$data = array();
			foreach ($this->getRouter() as $row) {
				$data[] = array("id"	=> NULL,
								"id_api"=> $row['.id'],
								"name"	=> $row['name'],
								"ip"	=> $row['ip-address'],
								"secret"=> $row['shared-secret'],
								"user_id"=> $this->session->userdata("user_id"),
								"id_router" => $this->id_router);
			}
			$this->db->where('user_id',$this->session->userdata("user_id"));
			$this->db->where('id_router', $this->id_router);
			$this->db->delete('tb_radius_server');
			
			
			return $this->db->insert_batch("tb_radius_server",$data);
		}
	}

	//Syncronisation
	function syncron($id = NULL)
	{
		if($this->open())
		{
			$this->API->write("/tool/user-manager/profile/getall");
			$READ = $this->API->read(true);
			$profile = array();
			foreach($READ as $row)
			{
				$profile[] = array(	'name' => $row['name'],
									'owner'=> $row['owner'],
									'nameforusers' => $row['name-for-users'],
									'validity'	   => $row['validity'],
									'starts_at'	   => $row['starts-at'],
									'price'		   => $row['price'],
									'overridesharedusers'	=> $row['override-shared-users'],
									'id_router'	   => $id,
									'id_api'	   => $row['.id']);

			}

			$this->db->insert_batch('tb_profile',$profile);

			$this->API->write("/tool/user-manager/profile/limitation/getall");
			$READ = $this->API->read(true);
			$limit = array();
			foreach($READ as $row)
			{
				$limit[] = array(	'id' 			=> NULL,
									'name' 			=> $row['name'],
									'owner' 		=> $row['owner'],
									'down_limit'	=> $row['download-limit'],
									'up_limit'		=> $row['upload-limit'],
									'trans_limit'	=> $row['transfer-limit'],
									'ip_pool'		=> $row['ip-pool'],
									"add_list"		=> $row['address-list'],
									"id_api"		=> $row['.id'],
									"uptime_limit"	=> $row['uptime-limit'],
									"id_router"		=> $id,
									"group_name"	=> $row['group-name']
				);

			}

			$this->db->insert_batch('tb_limit',$limit);
			
			$this->API->write("/tool/user-manager/router/getall");
			$READ = $this->API->read(true);
			$radius = array();
			foreach($READ as $row)
			{
				$READ = $READ[0];
				$radius['name']			= $row['name'];
				$radius['ip']			= $row['ip-address'];
				$radius['secret']		= $row['shared-secret'];
				$radius['id_router'] 	= $id;
				$radius['id_api']		= $row['.id'];
				$this->db->insert('tb_radius_server', $radius);
			}

			$this->API->write("/tool/user-manager/session/getall");
			$READ = $this->API->read(true);
			$this->db->trans_start();
			$sql = array();
			foreach($READ as $row)
			{
				$m = substr($row['from-time'],0,3);
				$from_time = strtotime(str_replace($m,$this->month[$m],$row['from-time']));
				$m = substr($row['till-time'],0,3);
				$till_time = strtotime(str_replace($m,$this->month[$m],$row['till-time']));
				$terminate = (isset($row['terminate-cause'])) ? $row['terminate-cause'] : NULL;
				$data	 = array(	"id"		=> NULL,
									"id_router"	=> $id,
									"customer"	=>	$row['customer'],	//: "admin",
									"user"		=>	$row['user'],	//: "234519876",
									"nas_port"	=>	$row['nas-port'],	//: "2161115737",
									"nas_port_type"	=>	$row['nas-port-type'],	//: "wireless-802.11",
									"nas_port_id"	=>	$row['nas-port-id'],	//: "br-wds",
									"calling_station_id"	=>	$row['calling-station-id'],	//: "F8:32:E4:F6:D3:83",
									"user_ip"	=>	$row['user-ip'],	//: "192.192.192.14",
									"host_ip"	=>	$row['host-ip'],	//: "192.168.4.17",
									"status"	=>	$row['status'],	//: "start,stop,interim",
									"from_time"	=>	$from_time,	//: "sep/20/2017 15:24:18",
									"till_time"	=>	$till_time,	//: "sep/21/2017 12:54:26",
									"terminate_cause"	=>	$terminate,	//: "lost-service",
									"uptime"	=>	$row['uptime'],	//: "21h30m7s",
									"download"	=>	$row['download'],	//: "123988330",
									"upload"	=>	$row['upload'],	//: "59364161",
									"active"	=>	$row['active'],	//: "false"
									"session_id"=>	do_hash($row['user'].$from_time)
	
								);
								
				$sql = "INSERT INTO tb_sessionuser 
						VALUES('".join($data,"','")."',NULL )
						ON DUPLICATE KEY UPDATE ".
						" status='".$data['status']."',download='".$data['download']."',upload='".$data['upload']."',
						till_time='".$data['till_time']."',uptime='".$data['uptime']."'";
				$this->db->query($sql);
	
				
				$this->db->set('last_seen', $till_time);
				$this->db->where('username', $row['user']);
				$this->db->where('id_router', $id);
				$this->db->update('tb_userman');
				
				if(strlen(strpos(strtolower($data['status']),"stop")) || strlen(strpos(strtolower($data['status']),"closed")))
				{
					$this->API->write("/tool/user-manager/session/remove",false);
					$this->API->write("=numbers=".$row['.id']);
				}
				
			}
		}
	}

	

	// public function sessionActive()
	// {
	// 	$this->open();
	// 	$this->API->write("/tool/user-manager/session/remove",false);
	// 	$this->API->write("=numbers=*1");
	// 	$READ = $this->API->read(true);
	// 	// $username = array();
	// 	// foreach($READ as $row)
	// 	// {
	// 	// 	switch ($row['status']) {
	// 	// 		case 'start,interim':
	// 	// 			$this->db->set("status",1);
	// 	// 			$this->db->where('username', $row['user']);
	// 	// 			$this->db->update('tb_userman');
	// 	// 			$username[] = $row['user'];
	// 	// 			break;
				
	// 	// 		default:
	// 	// 			# code...
	// 	// 			break;
	// 	// 	}
	// 	// }
	// 	// $this->db->set("status",0);
	// 	// $this->db->where_not_in('username ', $username);
	// 	// $this->db->update('tb_userman');
	// 	// $username[] = $row['user'];
	// 	return $this->getUser();
	// }


	function profileLimitation()
	{
		if ($this->open())
		{
			$data = array("from-time"	=> "0s",
						  "limitation"  => "enam-ribu",
						  "profile"		=> "ujicoba",
						  "till-time" 	=> "23h59m59s",
						  "weekdays"	=> "sunday,monday,tuesday,wednesday,thursday,friday,saturday"
						);
			$this->API->comm("/tool/user-manager/profile/profile-limitation/add",$data);
		}
	}
	
	public function registrasi_voucher($data)
	{
		$this->db->select('v.id,v.kode_voucher, v.customer,p.profil');
		$this->db->join('tb_profil p', 'p.id = v.id_profil');
		$this->db->where('kode_voucher', $data['kode_voucher']);
		//$this->db->where('use_date',NULL);
		$voucher = $this->db->get('tb_voucher v')->row();
		if(!empty($voucher))
		{
			if ($this->open())
			{
				//Create User
				$user = $this->cek_username();
				$data['username'] = $user;
				$pass = random_string('numeric', 5);
				$this->API->comm("/tool/user-manager/user/add",array("customer" => $voucher->customer,
																	  "username"	=> $user,
																	  "password"=> $pass,
																	  "phone" => $data['phone'],
																	  "comment" => $data['kode_voucher']
																	  ));
				//Active User
				$this->API->comm("/tool/user-manager/user/create-and-activate-profile",
						array("customer" => $voucher->customer,
						"profile"        => $voucher->profil,
						"numbers"        => $user));														  
				$this->API->write("/tool/user-manager/user/getall");
				$READ = $this->API->read(true);
				echo json_encode($READ);
				// $result = $this->where($READ,'username',$user);
				// if(!empty($result) || true)
				// {
				// 	$this->db->where(array('id' => $voucher->id, 'kode_voucher' => $data['kode_voucher'] ));
				// 	$this->db->set('use_date', 'NOW()', FALSE);
				// 	$this->db->update('tb_voucher');
				// 	$msg = array('text' => 'Selamat anda telah berhasil melakukan registrasi',
				// 				 'code' => '222',
				// 				 'result' => $result);
					
				// }
				// else
				// {
				// 	$msg = array('text' => 'Ada gagal melakukan registrasi silahkan ulangi kembali atau hubungi admin',
				// 				 'code' => '101',
				// 				 'result' => $data);

				// }
				
			}
			else
			{
				$msg = array('text' => 'Ada gagal melakukan registrasi silahkan ulangi kembali atau hubungi admin',
							 'code' => '101',
							 'result' => $data);

			}


		}
		else
		{
			$msg = array('text' => 'Kode Voucher Tidak Valid Silahkan masukan 16 digit Kode Voucher',
						 'code' => '100',
						 'result' => $data);
		}
		return $msg;
	}
	public function execute()
	{
	
		if ($this->open())
		{
			//Create User
			$this->API->comm("/tool/user-manager/user/add",array("customer" => "admin",
																  "username"	=> "Cc",
																  "password"=> "",
																  "phone" => "085723028647"
																  ));
			//Active User
			$this->API->comm("/tool/user-manager/user/create-and-activate-profile",array("customer" => "admin",
																  
																  "profile" => "Social Media",
																  "numbers"	=> "Cc"
																  ));														  
			$this->API->write("/tool/user-manager/user/getall");
			$READ = $this->API->read(true);
			echo $this->API->parse($READ);
			
		}
		else
			echo json_encode($ressult = array("status" => "ERROR",
											  "Pesan"  => "Koneksi host gagal silahkan periksa pengaturan!"));
	}
	
	function regUser($id = NULL)
	{
		$data = array();
		$user = $this->getUser();

		$this->db->where('id_router', ($id != NULL) ? $id : $this->id_router);
		$this->db->delete('tb_userman');
		foreach ($user as $row) {
			$m = substr($row['last-seen'],0,3);
			$active = (isset($row['active-sessions']))? $row['active-sessions'] : 0;
			$data[] = array("id"		=> NULL,
							"id_api"=> $row['.id'],
							"customer" 	=> $row['customer'],
							"actual_profile" => (isset($row['actual-profile']))?$row['actual-profile']:"",
							"username" 	=> $row['username'],
							"password" 	=> $row['password'],
							"download"	=> (isset($row['download-used']))?$row['download-used']:0,
							"upload"	=> (isset($row['upload-used']))?$row['upload-used']:0,
							"time_used"	=> (isset($row['uptime-used']))?$row['uptime-used']:"",
							"status" 	=> $active,
							"disabled"	=> $row['disabled'],
							"id_router"	=> ($id != NULL) ? $id : $this->id_router,
							"last_seen" => (isset($row['last-seen']) && $row['last-seen'] != "never") ? strtotime(str_replace($m,$this->month[$m],$row['last-seen'])): NULL
			);
		}
		if(count($data) != 0)
			return $this->db->insert_batch("tb_userman",$data);

	}

	public function sessionUser($user_id = NULL)
	{
		$data = array();
		if($user_id != NULL)
		{
			$user_id = decode_url($user_id,"mikrotikkey");
			$this->session->set_userdata("user_id", $user_id);
			logs("Admin","[Cron Job]: Session updating");
			$this->db->select('*')
					 ->from('tb_user_router')
					 ->where('user_id', $user_id);
			$router = $this->db->get()->row();
			$this->user = $router->user;
			$this->host = $router->host;
			$this->pass = $router->pass;
			$this->API->port = $router->port;

		}
		$this->open();
		$this->API->write("/tool/user-manager/session/getall");
		$READ = $this->API->read(true);
		$this->db->trans_start();
		$sql = array();
		foreach($READ as $row)
		{
			$m = substr($row['from-time'],0,3);
			$from_time = strtotime(str_replace($m,$this->month[$m],$row['from-time']));
			$m = substr($row['till-time'],0,3);
			$till_time = strtotime(str_replace($m,$this->month[$m],$row['till-time']));
			$terminate = (isset($row['terminate-cause'])) ? $row['terminate-cause'] : NULL;
			$data	 = array(	"id"		=> NULL,
								"id_router"	=> (($this->session->userdata("id_router"))) ? $this->session->userdata("id_router") : $user_id,
								"customer"	=>	$row['customer'],	//: "admin",
								"user"		=>	$row['user'],	//: "234519876",
								"nas_port"	=>	$row['nas-port'],	//: "2161115737",
								"nas_port_type"	=>	$row['nas-port-type'],	//: "wireless-802.11",
								"nas_port_id"	=>	$row['nas-port-id'],	//: "br-wds",
								"calling_station_id"	=>	$row['calling-station-id'],	//: "F8:32:E4:F6:D3:83",
								"user_ip"	=>	$row['user-ip'],	//: "192.192.192.14",
								"host_ip"	=>	$row['host-ip'],	//: "192.168.4.17",
								"status"	=>	$row['status'],	//: "start,stop,interim",
								"from_time"	=>	$from_time,	//: "sep/20/2017 15:24:18",
								"till_time"	=>	$till_time,	//: "sep/21/2017 12:54:26",
								"terminate_cause"	=>	$terminate,	//: "lost-service",
								"uptime"	=>	$row['uptime'],	//: "21h30m7s",
								"download"	=>	$row['download'],	//: "123988330",
								"upload"	=>	$row['upload'],	//: "59364161",
								"active"	=>	$row['active'],	//: "false"
								"session_id"=>	do_hash($row['user'].$from_time)

							);
							
			$sql = "INSERT INTO tb_sessionuser 
					VALUES('".join($data,"','")."',NULL )
					ON DUPLICATE KEY UPDATE ".
					" status='".$data['status']."',download='".$data['download']."',upload='".$data['upload']."',
					till_time='".$data['till_time']."',uptime='".$data['uptime']."'";
			$this->db->query($sql);

			
			$this->db->set('last_seen', $till_time);
			$this->db->where('username', $row['user']);
			$this->db->where('id_router', (($this->session->userdata("id_router"))) ? $this->session->userdata("id_router") : $user_id);
			$this->db->update('tb_userman');
			
			if(strlen(strpos(strtolower($data['status']),"stop")) || strlen(strpos(strtolower($data['status']),"closed")))
			{
				$this->API->write("/tool/user-manager/session/remove",false);
				$this->API->write("=numbers=".$row['.id']);
			}
			
		}

		$this->db->trans_complete(); 
		
		return true;
	}

	//Mengubah status User login **
	function setUserStatus($data,$user_id)
	{
		$this->sessionUser($user_id);
		$user_id = decode_url($user_id,'mikrotikkey');
		$this->db->select('*')
				 ->from('tb_user_router')
				 ->where('user_id', $user_id);
		$router = $this->db->get()->row();

		logs("User","[hotspot]: <b>".$data['user']."</b> ". $data['type'] ." Succesfully", $user_id,$data['ip']);
        switch ($data['type']) {
            case 'login':

                $this->db->set("status",1);
                break;
            
            default:
				$this->db->set("status",0);
				
				$this->user = $router->user;
				$this->host = $router->host;
				$this->pass = $router->pass;
				$this->API->port = $router->port;
				$this->open();
				$this->API->write("/tool/user-manager/user/getall",false);
				$this->API->write("?username=".$data['user']);
				$READ = $this->API->read(true);
				$this->db->set("download ","(download + ".$READ[0]['download-used'].")",false);
				$this->db->set("upload","(upload + ".$READ[0]['upload-used'].")",false);
				$this->db->set("time_used",$READ[0]['uptime-used']);
                break;
		}

		$this->db->where("username",$data['user']);
		$this->db->where("id_router",$router->id);
		#####ID_router
        return $this->db->update("tb_userman");
	}

	public function comm()
	{
		if ($this->open())
		{
			$this->API->comm("/tool/user-manager/user/add",array("customer" => "admin",
																  "name"	=> 11,
																  "password"=> 11,
																  "shared-users"=>1,
																  "copy-from" => "1D"));
		}
	}

	function query()
	{
		$this->open();
		$onlogout = preg_replace("~\R~u","\r\n",":local bytesin;

												:local bytesout;
												
												:local uptime;");
		$data = array('.id'	=> '*0',
					  'on-logout' => $onlogout);
		$this->API->comm("/ip/hotspot/user/profile/set",$data);
		$this->API->write("/ip/hotspot/user/profile/getall");
		$READ = $this->API->read(true);
		return $READ;

	}
	private function open($debug = false)
	{
		

		$this->API->debug = $debug;
		
		if($this->API->connect($this->host,$this->user,$this->pass))
			return true;
		else
			return false;
	}

	private function where($data,$field,$val)
	{
		foreach ($data as $row)
		{
			if($row[$field] == $val)
				return $row;
		}
		return array();

	}
	private function cek_username()
	{
		$this->API->write("/tool/user-manager/user/getall");
		$READ = $this->API->read(true);

		for ($i=0; $i < 3; $i++) {
			$user = random_string('alnum', (7 + $i ));
			$result = $this->where($READ,'username',$user);
			if(empty($result))
				return $user;
		}		
	}

}
?>