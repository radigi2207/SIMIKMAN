<?
if ( ! function_exists('encode_url'))
{
	function encode_url($string, $key="", $url_safe=TRUE)
	{
        if($key == null || $key == "")
        {
            $key = "cyberpos";
        }
        $CI =& get_instance();
        $ret = $CI->encrypt->encode($string,$key);
        if($url_safe)
        {
            $ret = strtr($ret,array('+' => '.',
                                    '=' => '_',
                                    '/' => '`'));
        }
        return $ret;
		
	}
}
if ( ! function_exists('decode_url'))
{
	function decode_url($string, $key="")
	{
        if($key == null || $key == "")
        {
            $key = "cyberpos";
        }
        $CI =& get_instance();
        $ret = strtr(urldecode($string),array('.' => '+',
                                    '_' => '=',
                                    '`' => '/'));
        return $CI->encrypt->decode($ret,$key);
		
	}
}
?>