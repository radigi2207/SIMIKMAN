<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'/third_party/autoload.php';

use Mike42\Escpos\Printer;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
class Printer_epos
{


    public function __construct()
    {

        
        // $printer -> initialize();

        // /* Text */
        // $printer -> text("Hello world\n");
        // $printer -> cut();
    }

    function prints($printer)
    {
        $connector = new WindowsPrintConnector($printer);
        //$connector = new NetworkPrintConnector("192.168.192.168","9100");
        $print = new Printer($connector);
        $CI =& get_instance();
        $CI->print = $print;
    }
    function th($left,$right)
    {
        $rightCols = 16;
        $leftCols = 17;
        $left = str_pad($left, $leftCols) ;
        $right = str_pad($right, $rightCols, ' ', STR_PAD_LEFT);
        return $left.$right."\n";
    }
    function item($item,$qty,$harga)
    {
        $item = strtoupper(substr($item,0,33));

        $rightCols = 12;
        $centercols = 7;
        $hargacols = 7;
        $center = str_pad($qty,$centercols,' ',STR_PAD_LEFT);
        $harga = str_pad($harga,$hargacols,' ', STR_PAD_LEFT);
        $total = str_pad(number_format($harga * $qty,0,',','.'), $rightCols, ' ', STR_PAD_LEFT);
        return $item."\n".$center." x @Rp.".$harga.$total."\n";
    }
    function diskon($diskon)
    {
        $rightCols = 12;
        $leftCols = 21;
        $left = str_pad('D I S K O N :', $leftCols,' ',STR_PAD_LEFT) ;
        $right = str_pad("(".number_format($diskon,0,',','.').")", $rightCols, ' ', STR_PAD_LEFT);
        return $left.$right."\n";
    }
    function total($data)
    {
        $rightCols = 12;
        $leftCols = 21;
        $center = 6;
        $left = str_pad($data['item'].' Item', $leftCols) ;
        $center = str_pad();
        $right = str_pad("(".number_format($diskon,0,',','.').")", $rightCols, ' ', STR_PAD_LEFT);
        return $left.$right."\n";

    }

    

}

/* End of file LibraryName.php */
?>