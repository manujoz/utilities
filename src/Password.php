<?php namespace Manujoz\Utilities;

/**
* CLASE DE PASSWORD
*
* Clase que trata contraseñas de diferentes formas
*
* @author http://www.arismanwebs.es
* @copyright ONLINE MYA DISTRIBUCIONES S.L.
*/
class Password {
	/**
	 * @method generate
	 * @access public
	 *
	 * Genera una contraseña con una seguridad dada
	 *
	 * @param string $seguridad Nivel de seguradad que queremos. Posibles( "baja", "media", "alta", "maxima" ), Defecto ("media")
	 * @param integer $longitud Longitud de la que queremos la contraseña Defecto( 6 )
	 * @return string con la contraseña generada
	 */
	public function generate( $seguridad = "media", $longitud = 6 ){
		// Ajustamos longitud
		
		if(( !$longitud ) or ( $longitud < 6 )){
			$longitud = 6;
		}
		
		// Ajustamos seguridad de la contraseña
		
		if (( !$seguridad ) or ( $seguridad == "baja" )){
			$cadena = "1234567890";
		} else if ( $seguridad == "media" ){
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		} else if ( $seguridad == "alta" ){
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
			if( $longitud < 8 ){
				$longitud = 8;
			}
		} else if ( $seguridad == "maxima" ){
			$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890@$*&#+-_";
			if ( $longitud < 8 ){
				$longitud = 8;
			}
		}
		
		// Creamos la contraseña
		
		$pass = "";
		$longitudCadena = strlen( $cadena );
		if( $seguridad == "maxima" ){
			while( $this->check_security( $pass ) != "OK" ){
				$pass = "";
				for( $i=1; $i <= $longitud; $i++ ){
					$pos = rand( 0, $longitudCadena-1 );
					$pass .= substr( $cadena, $pos, 1 );
				}
			}
		}else{
			for( $i=1; $i <= $longitud; $i++ ){
				$pos = rand( 0, $longitudCadena-1 );
				$pass .= substr( $cadena, $pos, 1 );
			}
		}
		
		return $pass;
	}
	
	/**
	 * @method check_security
	 * @access private
	 *
	 * Determina si una contraseña tiene una seguridad óptima
	 *
	 * @param string $pass La contraseña que queremos validar
	 * @return string "OK" si es segura, de lo contrario el error de seguridad que tiene
	 */
	public function check_security( $pass ){
		$valida = "OK";
		if(!preg_match('`[\@\$\*\&\#\-\_\+]`',$pass)){
		  $valida = "La contraseña debe tener al menos uno de estos síbolos @$*&#+-_";
		}
		if(!preg_match('`[0-9]`',$pass)){
		  $valida = "La contraseña debe tener al menos un caracter numérico";
		}
		if(!preg_match('`[A-Z]`',$pass)){
		  $valida = "La contraseña debe tener al menos una letra mayúscula";
		}
		if(!preg_match('`[a-z]`',$pass)){
		  $valida = "La contraseña debe tener al menos una letra minúscula";
		}
		if(strlen($pass) < 8){
		  $valida = "La contraseña debe tener al menos 8 caracteres";
		}
		return $valida;
	}
}

?>