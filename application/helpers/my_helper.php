<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('my_crypt'))
{
    function my_crypt($string, $action = 'e' )
    {
        $secret_key = strtolower(str_replace(" ", '_', APP_NAME)).'_key';
	    $secret_iv = strtolower(str_replace(" ", '_', APP_NAME)).'_iv';

	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

	    if( $action == 'e' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'd' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }

	    return $output;
    }   
}

if ( ! function_exists('re'))
{
    function re($array='')
    {
        echo "<pre>";
        print_r($array);
        exit;
    }
}

if ( ! function_exists('e_id'))
{
    function e_id($id)
    {
        return $id * 44545;
    }
}

if ( ! function_exists('d_id'))
{
    function d_id($id)
    {
        return $id / 44545;
    }
}

if ( ! function_exists('admin'))
{
    function admin($url='')
    {
        return ADMIN.'/'.$url;
    }
}

if ( ! function_exists('b_asset'))
{
    function b_asset($url='')
    {
        return base_url('assets/back/'.$url);
    }
}

if ( ! function_exists('flashMsg'))
{
    function flashMsg($success, $succmsg, $failmsg, $redirect)
    {
        $CI =& get_instance();
        
        if ($success)
            $CI->session->set_flashdata(['title' => 'Success | ','notify' => 'success', 'message' => $succmsg]);
        else
            $CI->session->set_flashdata(['title' => 'Error ! ', 'notify' => 'danger', 'message' => $failmsg]);
        
        return redirect($redirect);
    }
}

if ( ! function_exists('auth'))
{
    function auth()
    {
        $CI =& get_instance();
        
        return (object) $CI->user;
    }
}

if ( ! function_exists('check_ajax'))
{
    function check_ajax()
    {
        $CI =& get_instance();
        if (!$CI->input->is_ajax_request())
            die;
    }
}

if ( ! function_exists('convert_webp'))
{
    function convert_webp($path, $image, $name) {
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagewebp($image, "$path$name.webp", 100);
        imagedestroy($image);
    }
}

if ( ! function_exists('send_notification'))
{
    function send_notification($body, $token)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
		$serverKey = 'AAAARoSRS8M:APA91bHUfY6wT9MmDimXBBNCSbPwoEhziNPhdPSZOfnmCp85ml6arGAZqUnIvEZmNRoZduxzyV5e9MjiOztC7387Og2cBMXg91cNxuG1t_jDcSUqGCvC1TtiQx9MFYkS7lcx0Srps4Ot';
		
		$notification = ['title' => APP_NAME , 'body' => $body, 'sound' => 'default', 'badge' => '1', 'image' => base_url('assets/images/favicon.png')];
		$arrayToSend = ['to' => $token, 'notification' => $notification,'priority'=>'high'];

		$json = json_encode($arrayToSend);
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_exec($ch);
		curl_close($ch);
		return;
    }
}