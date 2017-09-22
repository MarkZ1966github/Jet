<?php
$api_user_id   = "your user id";
$api_secret    = "your secret id";
$merchant_id   = "your merchant id";
$api_prefix 	= 'https://merchant-api.jet.com/api/';

		$ch = curl_init($api_prefix.'/Token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//If necessary add your ssl pem: curl_setopt($ch, CURLOPT_CAINFO,'/ssl/cacert.pem');
		$request = json_encode(array(
			"user" => $api_user_id,
			"pass" => $api_secret
		));                                              
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($request))                                                                       
		);       
		$data = curl_exec($ch);
		curl_close($ch);
		if($data = json_decode($data)){
			if($token = $data->id_token){
				$file = '/var/www/domains/sportsmanssupplyinc.com/jetpartner/htdocs/token.prod.txt';
				fopen($file, w); 
				file_put_contents($file, $token);
				return true;
			}
		}
		return false;

?>