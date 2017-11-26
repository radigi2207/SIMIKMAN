<?
class Monitor_model extends CI_Model {
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
    function __construct()
    {
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
	
	function getInterface()
    {
        $this->open();
		$this->API->write("/interface/getall");
		$READ = $this->API->read(true);
		return $READ;
	}

    function monitorInterface($interface = NULL)
    {
		if ($interface == NULL) return;
        $this->open();
		$this->API->write('/interface/monitor-traffic',false);
		$this->API->write('=interface='.$interface,false);
		$this->API->write('=once');
		$READ = $this->API->read(true);
		return $READ[0];
	}


	
	function systemInfo()
	{
		$this->open();
		$this->API->write("/system/resource/getall");
		$READ = $this->API->read(true);
		return $READ[0];
	}

	function routerboard()
	{
		$this->open();
		$this->API->write("/system/routerboard/getall");
		$READ = $this->API->read(true);
		return $READ[0];
	}

    private function open($debug = false)
	{
		$this->API->debug = $debug;
		
		if($this->API->connect($this->host,$this->user,$this->pass))
			return true;
		else
			return false;
	}
}
?>