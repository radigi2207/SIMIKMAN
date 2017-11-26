<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index($step = 'first')
	{
		$post = $this->input->post();
		if($post)
		{
			
			$conn = mysqli_connect($post['host'],$post['user'],$post['password']);
			if($conn)
			{
				$config = array();
				$config['hostname'] = $post['host'];
				$config['username'] = $post['user'];
				$config['password'] = $post['password'];
				$config['database'] = 'information_schema';
				$config['dbdriver'] = 'mysqli';
				$config['dbprefix'] = '';
				$config['pconnect'] = FALSE;
				$config['db_debug'] = FALSE;
				$config['cache_on'] = FALSE;
				$config['cachedir'] = '';
				$config['char_set'] = 'utf8';
				$config['dbcollat'] = 'utf8_general_ci';
				$this->load->database($config);

				$this->db->where('SCHEMA_NAME', $post['database']);
				$db_list = $this->db->get('SCHEMATA');
				if($db_list->num_rows() == 0)
				{
					$this->load->dbforge();
					$this->dbforge->create_database($post['database']);
					
				}
				$this->db->db_select($post['database']);
				$string = rtrim($this->encrypt->decode(read_file("database.file")),'\n;');
				$query = explode(";\n", $string);
				$erro = 0;
				$success = 0;
				$error_msg = array();
				$this->db->trans_start();
				for ($i = 0; $i < count($query); $i++)
				{
					$value = explode("#\n",$query[$i]);
					if(strlen(trim(end($value))) != 0)
					{
						$ex = $this->db->query(end($value));
						if($ex)
						{
							$success++;
						}
						else
						{
							$msg = $this->db->error();
							$msg['query'] = $this->db->last_query();
							$erro++;
						}
					}        			
				}
				$this->db->trans_complete();
				$data = array('success' => $success,
							  'error'	=> $erro,
							  'error_msg' => $error_msg);
				if($erro == 0)
				{
					$file_name = "./installation/config/database.php";
					$database = read_file($file_name);
		
					$string = strtr($database,array('##host##' 		=> $post['host'],
													'##user##' 		=> $post['user'],
													'##pass##' 		=> $post['password'],
													'##database##' 	=> $post['database']));
					write_file("./application/config/database.php", $string);					
					redirect('finish','refresh');
					
					
					
				}
				else
				{
					$this->session->set_flashdata("failed","Import basis data Gagal. <br>Tidak bisa terhubung ke basis data!");
				}
				
			}
			else
			{
				$this->session->set_flashdata("failed","Tidak bisa terhubung ke basis data!");
			}
			
			
		}
		$data['post'] = $post;

		$this->load->view('headerlogin', [], FALSE);
		$this->load->view($step, $data, FALSE);
		
	}
}

// $this->load->dbutil();


// $prefs = array(
// 		'ignore'        => array(),                     // List of tables to omit from the backup
// 		'format'        => 'txt',
// 		'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
// 		'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
// 		'newline'       => "\n"                         // Newline character used in backup file
// );
// $file_name ='database.file';

// // Backup your entire database and assign it to a variable		
// // Load the file helper and write the file to your server


// $backup = $this->dbutil->backup($prefs);
// write_file('./'.$file_name, $this->encrypt->encode($backup));

// // Load the download helper and send the file to your desktop
// // $this->load->helper('download');	
// // force_download($file_name, $this->encrypt->encode($backup));

