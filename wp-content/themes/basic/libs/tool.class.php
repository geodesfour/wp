<?php 

class tool {

	public static function getRandomProfile() {
		$genders = array('men', 'women');
		$gender = array_rand($genders);
		$id = rand(1,50);
		return 'http://api.randomuser.me/0.2/portraits/'.$genders[$gender].'/'.$id.'.jpg';
	}


	public static function getJson($file) {
		$json = file_get_contents($file);
		$result = json_decode($json, true);
		return $result;
	}

	public static function getAgeFromDate($date){
        $today = new DateTime();
        $diff = $today->diff(new DateTime($date));
		return $diff->y;
	}



    public static function cleanInput($var){
        return stripcslashes(trim($var));
    }

	public static function output($var, $title = false) {
        if($title)
            echo "<h2>$title</h2>";
        
		echo '<hr />';
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}    

    public static function getLatLng($address) {

        $uri = "http://maps.google.com/maps/api/geocode/json?address=".url_encode($address)."&sensor=false&region=UK";
        $url = file_get_contents($uri);
        $response = json_decode($url);
         
        $lat = $response->results[0]->geometry->location->lat;
        $long = $response->results[0]->geometry->location->lng; 

        return array($lat, $lng);
    }	


    public static function geocode($adresse){
                $q = urlencode(trim($adresse))."&sensor=false";
                $geocoder_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$q; //.$string."&sensor=false";
                //$csv = file_get_contents($reqgmaps) or die("url not loading" .$geocoder_url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $geocoder_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = json_decode(curl_exec($ch), true);
                $status = $response['status'];
                $geometry = $response['results'][0]['geometry'];
                $lng = $geometry['location']['lat'];
                $lat = $geometry['location']['lng'];

                return array($lat, $lng);
    }
    
    public static function formatBytes($bytes, $precision = 2) { 
        $units = array('o', 'Ko', 'Mo', 'Go', 'To'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    } 

    
}

?>