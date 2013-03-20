<?php
if (!class_exists('ip2location_lite')) {
	
	final class ip2location_lite{
		protected $errors = array();
		protected $service = 'api.ipinfodb.com';
		protected $version = 'v3';
		protected $apiKey = '';
	
		public function __construct(){}
	
		public function __destruct(){}
	
		public function setKey($key){
			if(!empty($key)) $this->apiKey = $key;
		}
	
		public function getError(){
			return implode("\n", $this->errors);
		}
	
		public function getCountry($host){
			return $this->getResult($host, 'ip-country');
		}
	
		public function getCity($host){
			return $this->getResult($host, 'ip-city');
		}
	
		private function getResult($host, $name){
			$ip = @gethostbyname($host);
	
			if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)){
				$xml = @file_get_contents('http://' . $this->service . '/' . $this->version . '/' . $name . '/?key=' . $this->apiKey . '&ip=' . $ip . '&format=xml');
	
				try{
					$response = @new SimpleXMLElement($xml);
	
					foreach($response as $field=>$value){
						$result[(string)$field] = (string)$value;
					}
	
					return $result;
				}
				catch(Exception $e){
					$this->errors[] = $e->getMessage();
					return;
				}
			}
	
			$this->errors[] = '"' . $host . '" is not a valid IP address or hostname.';
			return;
		}
	}
}

if (!function_exists('fraudQuery')) {
	
	function fraudQuery($ip, $country_code, $district, $city, $area_code, $mail_domain, $apikey){
		 
		$d = file_get_contents("http://api.ipinfodb.com/v2/fraud_query.php?key=".$apikey."&ip=$ip&country_code=$country_code&district=$district&city=$city&area_code=$area_code&mail_domain=$mail_domain");
		//Use backup server if cannot make a connection
		if (!$d){
			$backup = file_get_contents("http://backup.ipinfodb.com/fraud_query.php?key=".$apikey."&ip=$ip&country_code=$country_code&district=$district&city=$city&area_code=$area_code&mail_domain=$mail_domain&enable_hostname=1");
			$backup = utf8_encode($d);
			if (function_exists('mb_detect_encoding'))
				$enc = mb_detect_encoding($backup);
			if (function_exists('mb_convert_encoding'))
				$backup = mb_convert_encoding($d, 'UTF-8', $enc);
			try {
				$answer = new SimpleXMLElement($backup);
			}
			catch(Exception $e){
				return array( 'fraud_ipdb_errors'  => $e->getMessage());	
			}
			if (!$backup) return false; // Failed to open connection
		}else{
			$d = utf8_encode($d);
			if (function_exists('mb_detect_encoding'))
				$enc = mb_detect_encoding($d);
			if (function_exists('mb_convert_encoding'))
				$d = mb_convert_encoding($d, 'UTF-8', $enc);
			try {
				$answer = new SimpleXMLElement($d);
			}
			catch(Exception $e){
				return array( 'fraud_ipdb_errors'  => substr($e->getMessage(),0,999));	
			}
		}
		  
		return array('fraud_ipdb_errors' => $answer->Errors, 'fraud_ipdb_warnings' => $answer->Warnings, 'fraud_ipdb_messages' => $answer->Messages, 
					'fraud_ipdb_districtcity' => $answer->DistrictCity, 'fraud_ipdb_ipcountrycode' => $answer->IpCountryCode, 'fraud_ipdb_ipcountry' => $answer->IpCountry, 
					'fraud_ipdb_ipregioncode' => $answer->IpRegionCode, 'fraud_ipdb_ipregion' => $answer->IpRegion, 'fraud_ipdb_ipcity' => $answer->IpCity, 
					'IpHostName' => $answer->IpHostName, 'fraud_ipdb_score' => $answer->Score, 'fraud_ipdb_accuracyscore' => $answer->AccuracyScore, 
					'fraud_ipdb_scoredetails' => $answer->ScoreDetails);
	}
}
?>