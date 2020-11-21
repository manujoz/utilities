<?php namespace Manujoz\Utilities;

/**
* CLASE DE SERVIDOR
*
* Realiza operaciones para relacionadas con el servidor
*
* @author http://www.arismanwebs.es
* @copyright ONLINE MYA DISTRIBUCIONES S.L.
*/
class Server {
	/**
	 * @method	friendly_uri
	 *
	 * Crea una url amigable sobre un string.
	 *
	 * @param 	string 		$url 			URL que queremos convertir en amigable
	 * @return 	string 						La URL amigable transformada
	 * @access 	public
	 */
	public function friendly_uri( $url ){
		$a = array( "_", "?", "¿", "!", "¡", ")", "(", "/", "&", "%", "$", "·", "º", "ª", '\\', "€", "[", "]", "^", "*", "+", "¨", "{", "}", ",", ";", ".", ":", "-", "¬", " ", "-", "~", "©", "¨", "ª", "«", "¬", "®", "¯", "°", "±", "µ", "¶", "·", "»", "¼", "½", "¾", "�" );
		$b = array( "'", '"', "´", "`", "‘", "’", '“', '”' );
		$c = array( "á", "é", "í", "ó" ,"ú", "ñ", "Á", "É", "Í", "Ó", "Ú", "Ñ", "à", "è", "ì", "ò", "ù", "À", "È", "Ì", "Ò", "Ù", "â", "ê", "î", "ô", "û", "Â", "Ê", "Î", "Ô", "Û", 'Ä', 'ä', 'Ë', 'ë', 'Ï', 'ï', 'Ö', 'ö', 'Ü', 'ü', "ç", "Ç" );
		$d = array( "a", "e", "i", "o", "u", "n", "A", "E", "I", "O", "U", "N", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", 'A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', "c", "C" );
		
		$url = str_replace( $a, "-", $url );
		$url = str_replace( $b, "", $url );
		$url = str_replace( $c, $d, $url );
		$url = str_replace( "-------", "-", $url );
		$url = str_replace( "------", "-", $url );
		$url = str_replace( "-----", "-", $url );
		$url = str_replace( "----", "-", $url );
		$url = str_replace( "---", "-", $url );
		$url = str_replace( "--", "-", $url );
		$url = trim( $url, "-" );
		$url = rtrim ($url, "-" );
		$url = strtolower( $url );
		
		return $url;
	}
	
	/**
	 * @method	get_real_IP
	 *
	 * Obtiene el IP del visitante de la web.
	 *
	 * @return 	string 						La IP del usuario que visita la web
	 * @access 	public
	 */
	public static function get_real_IP() {
		if ( !empty( $_SERVER[ 'HTTP_CLIENT_IP' ] )){
			return $_SERVER[ 'HTTP_CLIENT_IP' ];
		} else if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] )){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			return $_SERVER[ 'REMOTE_ADDR' ];
		}
	}
	
	/**
	 * @method	http_error
	 *
	 * Envía la cabecera de un error 301, 404, 504 y muestra la página
	 * del correspondiente error personalizada si existe.
	 * 
	 * Esta función es útil si queremos mostrar páginas de error cuando
	 * estamos trabajando con AJAX
	 *
	 * @param 	string 		$error 			Es el error que corresponde. Posibles ( "301", "404", "504" )
	 * @param 	string 		$url 			Es la url donde queremos redireccionar los errores 301.
	 * @param 	string 		$idioma 		Es el idioma en el que estamos trabajando con la página. 
	 *     Sirve para mostrar páginas de error 404 que 
	 *     se encuentren el a siguiente estructura.
	 *     /paginas/$idioma/error/$error.php
	 * @access 	public
	 */
	public function http_error( $error, $url = "", $idioma = "es" ){
		/* ERROR 301 */
		if( $error == "301" ){
			header( $_SERVER[ "SERVER_PROTOCOL" ] . " 301 Moved Permanently" );
			header( "Location: http://" . $_SERVER[ "SERVER_NAME" ] . "" . $url );
			die();
		}
		
		/* BUSCAMOS EL ARCHIVO DE ERROR PERSNALIZADO */
		$points = "";
		while( !file_exists( $points . "paginas/" . $idioma . "/error/" . $error . ".php" )){
			$points .= '../';
		}
		
		/* ERROR 404 */
		if( $error == "404" ){
			header( $_SERVER[ "SERVER_PROTOCOL" ] . ' 404 Not Found' );
			include( $points . "paginas/" . $idioma . "/error/" . $error . ".php" );
			die();
		}
	}

	/**
	 * @method	remove_dir
	 *
	 * Elimina un directorio completo con todos sus archivos y carpetas
	 *
	 * @param 	string 		$directorio 	Directorio que queremos eliminar
	 * @access 	public
	 */
	public function remove_dir( $directorio ){
		foreach( glob( $directorio . "/*" ) as $archivos_carpeta ){
			if ( is_dir( $archivos_carpeta )){
				$this->remove_dir( $archivos_carpeta );
			} else {
				unlink( $archivos_carpeta );
			}
		}
		return rmdir( $directorio );
	}

	/**
	 * @method	get_uri_base
	 * 
	 * Obtiene la URL base de la página web.
	 */
	public function get_uri_base() {
		$count = 0;
		$uri_base = "";
		while( !file_exists( $uri_base . "package.json" ) && !file_exists( $uri_base . "composer.json" ) && $count < 30 ) {
			$uri_base .= "../";
			$count++;
		}

		if( $count == 30 ) {
			error_log( "[Arisman Webs] Fatal error: No pudo hayarse la URL base\n\t#0: Archivo: '" . $_SERVER[ "SCRIPT_NAME" ] . "'" );
			return false;
		}

		return $uri_base;
	}
	
	/**
	 * @method 	is_bot
	 * 
	 * Determina si nos visita el robot de Google o Bing
	 * 
	 * @return boolean		TRUE si nos está visitando un robot
	 */
	public function is_bot() {
		$bots = array( 'Googlebot', 'bingbot', 'Speed Insights', 'msnbot' );
			
		foreach( $bots as $b ){
			if( stripos( $_SERVER['HTTP_USER_AGENT'], $b ) !== false ) {
				return true;
			}
		}

		return false;
	}
}

?>