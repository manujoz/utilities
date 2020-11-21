<?php namespace Manujoz\Utilities;

class Geoloc {

	//the geoPlugin server
	public $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}';

	//the default base currency
	public $currency = 'EUR';

	//initiate the geoPlugin vars
	public $ip = null;
	public $city = null;
	public $region = null;
	public $areaCode = null;
	public $dmaCode = null;
	public $countryCode = null;
	public $countryName = null;
	public $continentCode = null;
	public $latitude = null;
	public $longitude = null;
	public $currencyCode = null;
	public $currencySymbol = null;
	public $currencyConverter = null;

	/**
	 * @method convert
	 * 
	 * Convierte una cantidad en un cantidad con símbolo monetario
	 *
	 * @param   number 	$amount  	Cantidad que queremos obtener
	 * @param   number 	$float   	Cantidad de decimales
	 * @param   boolean	$symbol  	Si queremos el símbolo o no
	 * @return  string
	 */
	function convert( $amount, $float=2, $symbol=true ) {
		if(!is_numeric($this->currencyConverter)||$this->currencyConverter == 0){
			trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
			return $amount;
		}
		if(!is_numeric($amount)){
			trigger_error ('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
			return $amount;
		}
		if($symbol === true){
			return $this->currencySymbol . round( ($amount * $this->currencyConverter), $float );
		}else{
			return round(($amount * $this->currencyConverter),$float);
		}
	}

	/**
	 * @method locate
	 * 
	 * Obtiene una localización a través de un IP dado
	 *
	 * @param   string 		$ip  IP de la que queremos saber la localizacion
	 */
	function locate( $ip ) {
		global $_SERVER;

		if(is_null($ip)){
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$host = str_replace('{IP}',$ip, $this->host);
		$host = str_replace('{CURRENCY}', $this->currency, $host);

		$data = array();

		$response = $this->_fetch( $host );

		$data = unserialize($response);

		$this->ip = $ip;
		$this->city = $data['geoplugin_city'];
		$this->region = $data['geoplugin_region'];
		$this->areaCode = $data['geoplugin_areaCode'];
		$this->dmaCode = $data['geoplugin_dmaCode'];
		$this->countryCode = $data['geoplugin_countryCode'];
		$this->countryName = $data['geoplugin_countryName'];
		$this->continentCode = $data['geoplugin_continentCode'];
		$this->latitude = $data['geoplugin_latitude'];
		$this->longitude = $data['geoplugin_longitude'];
		$this->currencyCode = $data['geoplugin_currencyCode'];
		$this->currencySymbol = $data['geoplugin_currencySymbol'];
		$this->currencyConverter = $data['geoplugin_currencyConverter'];
	}

	/**
	 * @method nearby
	 * 
	 * Devulve localizaciones por proximidad en un radio dado
	 *
	 * @param   string 	$radius  Radio en km
	 * @param   string 	$limit   Límite de localizacions
	 * @return 	array	Array con todas las localizaciones
	 */
	function nearby( $radius=10, $limit=null ) {
		if(!is_numeric($this->latitude)||!is_numeric($this->longitude)){
			trigger_error ('geoPlugin class Warning: Incorrect latitude or longitude values.', E_USER_NOTICE);
			return array( array() );
		}

		$host = "http://www.geoplugin.net/extras/nearby.gp?lat=" . $this->latitude . "&long=" . $this->longitude . "&radius={$radius}";

		if(is_numeric($limit)){
			$host .= "&limit={$limit}";
			return unserialize($this->_fetch($host));
		}
	}

	/**
	 * @method _fetch
	 * 
	 * Obtiene los datos del servicio que los ofrece
	 *
	 * @param   string  $host  Host del que queremos los datos
	 * @return 	string		Datos de respuesta del servicio
	 */
	private function _fetch( $host ) {
		if(function_exists('curl_init')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $host);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.0');
			$response = curl_exec($ch);
			curl_close ($ch);

		}else if(ini_get('allow_url_fopen')){
			$response = file_get_contents($host,'r');

		}else{
			trigger_error ('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
			return;
		}
		return $response;
	}
}

?>
