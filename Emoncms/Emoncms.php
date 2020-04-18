<?php namespace App\SupportedApps\Emoncms;

class Emoncms extends \App\SupportedApps implements \App\EnhancedApps {

    public $config;

    //protected $login_first = true; // Uncomment if api requests need to be authed first
    //protected $method = 'POST';  // Uncomment if requests to the API should be set by POST

    function __construct() {
        //$this->jar = new \GuzzleHttp\Cookie\CookieJar; // Uncomment if cookies need to be set
    }

    public function test()
    {
        $test = parent::appTest($this->url('5'));
        echo $test->status;
    }

    public function livestats()
    {
        $status = 'inactive';
        $power_raw = json_decode(parent::execute($this->url('5'))->getBody());
        $batt_raw = json_decode(parent::execute($this->url('7'))->getBody());		
		
		
		$data = [];
		
        if($power_raw || $batt_raw) {
            $data['power'] = $power_raw.' W';
            $data['batt'] = number_format($batt_raw, 2, '.', '').' V';
        }
		
        return parent::getLiveStats($status, $data);
        
    }
    public function url($id)
    {
        $apikey = $this->config->apikey;
		$api_url = parent::normaliseurl($this->config->url).'feed/value.json?id='.$id.'&apikey='.$apikey;
        return $api_url;
    }
}
