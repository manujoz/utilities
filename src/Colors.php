<?php namespace Manujoz\Utilities;

/**
* CLASE DE COLORES
*
* Tratamiento de colores
*
* @author http://www.arismanwebs.es
* @copyright ONLINE MYA DISTRIBUCIONES S.L.
*/
class Colores {
	/**
	 * @method convert
	 * @access public
	 *
	 * Convierte un color de RGB a Hexadecimal o a la inversa.
	 *
	 * @param 	string 		$color 			Color que queremos convertir
	 * @return 	string 	Color convertido
	 */
	public function convert( $color ){
		// Detectamos el tipo de color
		
		if( strpos( $color, "#") !== false ){
			$tipo = "hexToRgb";
		} else if ( strpos( $color, "rgb" ) !== false ){
			$tipo = "rgbToHex";
		} else {
			return false;
		}
		
		// Convertimos de hexadecimoa a RGB
		
		if( $tipo == "hexToRgb" ){
			$color = str_replace( "#", "", $color );
			if ( strlen( $color ) == 3 ){
				$r = hexdec( substr( $color, 0, 1).substr( $color, 0, 1 ));
				$g = hexdec( substr( $color, 1, 1).substr( $color, 1, 1 ));
				$b = hexdec( substr( $color, 2, 1).substr( $color, 2, 1 ));
			} else {
				$r = hexdec( substr( $color, 0, 2 ));
				$g = hexdec( substr( $color, 2, 2 ));
				$b = hexdec( substr( $color, 4, 2 ));
			}
			
			return "rgb(".$r.",".$g.",".$b.")";
		}
		
		// Convertimos de RGB a Hexadecimal
		
		if( $tipo == "rgbToHex" ){
			$color = str_replace( " ", "", $color );
			$sc = explode( "(", $color );
			$sc = explode( ")", $sc[ 1 ] );
			$rgb = explode( ",", $sc[ 0 ] );
			
			$hex = "#";
			$hex .= str_pad( dechex( $rgb[ 0 ] ), 2, "0", STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgb[ 1 ] ), 2, "0", STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgb[ 2 ] ), 2, "0", STR_PAD_LEFT );

			return $hex;
		}
	}
	
	/**
	 * @method contrast
	 * @access public
	 *
	 * Nos devuelve el contraste de un color (light, dark).
	 *
	 * @param 	string 		$color 			Color del que queremos el contraste
	 * @return 	string 	(light, dark) en función que sea claro u oscuro
	 */
	public function contrast( $color ){
		if(strpos($color, "#") !== false){
			$color = $this->convert( $color );
		}
		
		if( !$color ) {
			return false;
		}
		
		$color = str_replace(" ", "", $color);
		$sc = explode("(", $color);
		$sc = explode(")", $sc[1]);
		$rgb = explode(",", $sc[0]);
		
		$r = $rgb[0];
		$g = $rgb[1];
		$b = $rgb[2];
		
		$brillo = (($r * 299)+($g * 587)+($b * 114)) / 1000;
		
		if($brillo > 125){
			return "light";
		}else{
			return "dark";
		}
	}
}

?>