<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));		
		$this->load->model('report/Report_model','report');
		
    }
    

    public function index()
    {
        
    }

    function periode($start, $finish,$agen = NULL)
    {

        $objReader = IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load("assets/formatperiode.xlsx");

        $hrf = array('A','B','C','D','E','F');
        $hrfagen = array('A','B','C','D','E');
		
		$data = array('startdate' => $start , 'finishdate' => $finish );
		($agen != NULL ) ? $data['agen'] = $agen : NULL;
		$report = $this->report->periode($data);
		$i = 1;
		$jml = 0;
		foreach ($report->result_array() as $row) {
			$user = explode("#",$row['deskripsi']);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.($i+5),$i)
						->setCellValue('B'.($i+5),'['.$user[0].'] '. $user[1])
						->setCellValue('C'.($i+5),$row['profile'])
						->setCellValue('D'.($i+5),$row['date'])
						->setCellValue('E'.($i+5),ucfirst($row['first_name']." ". $row['last_name']))
						->setCellValue('F'.($i+5),$row['price']);
			$i++;
			$jml += $row['price'];
		}
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('F4',$jml)
					->setCellValue('B4', $start.' s/d '.$finish );
		
		ob_end_clean();
        // Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Lap. Pendapatan '.$start.'s/d'.$finish.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		ob_end_clean();
		exit;
		

    }

	function agen()
	{

	}
}

/* End of file Export.php */
?>