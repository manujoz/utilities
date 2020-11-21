<?php namespace Manujoz\Utilities;

/**
 * CLASE DE CRYPTER
 * 
 * Clase que sirve para encruptar y desencriptar cadenas
 */
class Crypter {
	/**
	 * @method encrypt
	 * 
	 * Encripta una cadena utilizando openssl_encrypt. Los parámetros $key e $iv son cadenas complejas
	 * que sirven para realizar la encriptación. Por ejemplo.:
	 * 
	 * $key = "Esta es la clave de encriptacion larga con caracteres aleatorios 8l_as34)@fT3_)"
	 * $iv = "Esta es la clave IV compleja con caracateres aleatorios aY+aSd*aK_3fr"
	 *
	 * @param   string  $string  Cadena que queremos encryptar
	 * @param   string  $key     Clave de encriptación
	 * @param   string  $iv      IV de encriptación
	 * @return	string
	 */
	public static function encrypt( $string, $key, $iv ) {
		$method = "AES-256-CBC";
		$string = trim( strval( $string ));
		$key = hash('sha256', $key );
		$iv = substr(hash('sha256', $iv ),0,16);

		return openssl_encrypt( $string, $method, $key, true, $iv );
	}

	/**
	 * @method decrypt
	 * 
	 * Desencripta una cadena utilizando openssl_encrypt. Los parámetros $key e $iv son cadenas complejas
	 * que sirven para realizar la encriptación, esta debe ser la misma con la que se encripto. Por ejemplo.:
	 * 
	 * $key = "Esta es la clave de encriptacion larga con caracteres aleatorios 8l_as34)@fT3_)"
	 * $iv = "Esta es la clave IV compleja con caracateres aleatorios aY+aSd*aK_3fr"
	 *
	 * @param   string  $string  Cadena que queremos encryptar
	 * @param   string  $key     Clave de encriptación
	 * @param   string  $iv      IV de encriptación
	 * @return	string
	 */
	public static function decrypt( $string, $key, $iv ) {
		$method = "AES-256-CBC";
		$string = trim( strval( $string ));
		$key = hash('sha256', $key );
		$iv = substr(hash('sha256', $iv ),0,16);

		return openssl_decrypt( $string, $method, $key, true, $iv );
	}
}

?>