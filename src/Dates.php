<?php namespace Manujoz\Utilities;

/**
* CLASE DE FECHAS
*
* Trtamos las fechas de diferentes formas
*
* @array private $en Array de nombres en inglés
* @array private $es Array de nombres en español
* @array private $ca Array de nombres en catalán
* @array private $fr Array de nombres en francés
*
* @author http://www.arismanwebs.es
* @copyright ONLINE MYA DISTRIBUCIONES S.L.
*/
class Dates {
	private static $en = array( "Monday", "Mon", "Tuesday", "Tue", "Wednesday", "Wed", "Thursday", "Thu", "Friday", "Fri", "Saturday", "Sat", "Sunday", "Sun","January", "Jan", "February", "Feb", "March", "Mar", "April", "Apr", "May", "May", "June", "Jun", "July", "Jul","August", "Aug", "September", "Sep", "October", "Oct", "November", "Nov", "December", "Dec" );
	private static $es = array( "Lunes", "Lun", "Martes", "Mar", "Miércoles", "Mie", "Jueves", "Jue", "Viernes", "Vie", "Sábado", "Sab", "Domingo", "Dom", "Enero", "Ene", "Febrero", "Feb", "Marzo", "Mar", "Abril", "Abr", "Mayo", "May", "Junio", "Jun", "Julio", "Jul", "Agosto", "Ago", "Septiembre", "Sep", "Octubre", "Oct", "Noviembre", "Nov", "Diciembre", "Dic" );
	private static $ca = array( "Dilluns", "dl", "Dimarts", "dm", "Dimecres", "dc", "Dijous", "dj", "Divendres", "dv", "Dissabte", "ds", "Diumenge", "dm", "Gener", "Gen", "Febrer", "Feb", "Març", "Mar", "Abril", "Abr", "Maig","Mai","Juny", "Jun", "Juliol", "Jul", "Agost", "Ago", "Setembre", "Set", "Octubre", "Oct", "Novembre", "Nov", "Desembre", "Des" );
	private static $fr = array( "Lundi", "Lun", "Mardi", "Mar", "Mercredi", "Mer", "Jeudi", "Jeu", "Vendredi", "Ven", "Samedi", "Sam", "Dimanche", "Dim", "Janvier", "Janv", "Février", "Févr", "Mars", "Mars", "Avril", "Avr", "Mai", "Mai", "Juin", "Juin", "Juillet", "Juil", "Août", "Août", "Septembre", "Sept", "Octobre", "Oct", "Novembre", "Nov", "Décembre", "Dec" );
	
	/**
	 * @method age
	 * @access public
	 *
	 * Calcula la edad en una fecha dada
	 *
	 * @param 	string 		$born 		Fecha de nacimiento que calcular edad
	 * @return 	number 		Número con la edad de la fecha
	 */
	public function age( $born ){
		// Validmos la fecha
		
		if (( !$born ) or ( !$this->_validate( $born ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamos objetos de fecha
		
		$date = new \DateTime( date( "Y-m-d" ));
		$born = new \DateTime( $born );
		
		// Si la fecha es mayor a la actual, aún no ha nacido
		
		if( $born > $date ){
			return "Aún no ha nacido";
		}
		
		// Calculamos la edad
		
		$edad = $date->diff( $born );
		return intval( $edad->format('%y'));
	}
	
	/**
	 * @method calculate
	 * @access public
	 *
	 * Hace calculos a las fechas, por ejemplo, sumar un mes a una fecha dada
	 *
	 * @param 	string 		$date 			Fecha en la que queremos hacer le cálculo
	 * @param 	string 		$op 			La operació que vamos a ralizar Valores posibles( "+", "-" )
	 * @param 	integer 	$cant 			La cantidad que vamos a sumar/restar
	 * @param 	string 		$stretch 		Lo que vamos a sumar o restar Valores posibles( "years", "months", "days", "hours", "minutes", "seconds" )
	 * @return 	string 		Fecha calculada
	 */
	public function calculate( $date, $op, $cant, $stretch ){
		// Validmos la fecha
		
		if (( !$date ) or ( !$this->_validate( $date ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamo un objeto de fecha
		
		$objFecha = new \DateTime($date);
		
		// Creamos el string para el cálculo
		
		if ( $stretch == "years" ){
			$str = "P" . $cant . "Y";
		}
		if ( $stretch == "months" ){
			$str = "P" . $cant . "M";
		}
		if ( $stretch == "days" ){
			$str = "P" . $cant . "D";
		}
		if ( $stretch == "hours" ){
			$str = "PT" . $cant . "H";
		}
		if ( $stretch == "minutes" ){
			$str = "PT" . $cant . "M";
		}
		if ( $stretch == "seconds" ){
			$str = "PT" . $cant . "S";
		}
		
		// Realizamos la operación
		
		if( $op == "+" ){
			$objFecha->add( new \DateInterval( $str ));
		}else if($op == "-"){
			$objFecha->sub( new \DateInterval( $str ));
		}
		
		// Damos formato a la fecha
		
		$sf = explode( " ", $date );
		if( !$sf[ 1 ] ){
			$result = $objFecha->format( "Y-m-d" );
		}else{
			$result = $objFecha->format( "Y-m-d H:i:s" );
		}
		
		// Devolvemos el resultado
		
		return $result;
	}
	
	/**
	 * @method month_days
	 * @access public
	 *
	 * Calcular el número de días que tienen un mes en una fecha
	 *
	 * @param 	string 		$date 		Fecha del que queremos saber el número de días del mes
	 * @return 	number 	Número con el número de días del mes dado
	 */
	public function month_days( $date ){
		// Validmos la fecha
		
		if (( !$date ) or ( !$this->_validate( $date ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamos el objeto de la fecha
		
		$date = new \DateTime( $date );
		
		// Devolvemos la candidad de días del mes
		
		return intval( $date->format( 't' ));
	}
	
	/**
	 * @method name
	 * @access public
	 *
	 * Devuelve el nombre del día de la semana o del mes, por ejemplo
	 * Lunes, Martes, Enero, Febrero...
	 *
	 * @param 	string 		$date 		Fecha de la que queremos el nombre de algo
	 * @param 	string 		$type 		Como queremos el nombre devuelto Posibles( "long", "short" ), Por defecto( "long" )
	 * @param 	string 		$stretch 	Lo qu queremos que nos devuelva el nombre Posibles( "month", "day" ), Por defecto( "day" )
	 * @param 	string 		$lang 		Idioma de salida de la fecha si tiene texto Posibles ("es", "ca", "en", "fr" ), Por defecto ("es")
	 * @return 	string con el nombre del día o el mes
	 */
	public function name( $date, $type = "long", $stretch = "day", $lang = "es" ){
		// Validmos la fecha
		
		if (( !$date ) or ( !$this->_validate( $date ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamos objetos de fecha
		
		$date = new \DateTime( $date );
		
		// Damos formato a la fecha
		
		if ( $stretch == "month" ){
			if ( $type == "short" ){
				$date = $date->format( 'M' );
			} else {
				$date = $date->format( 'F' );
			}
		} else if ( $stretch == "day" ){
			if ( $type == "short" ){
				$date = $date->format( 'D' );
			} else {
				$date = $date->format( 'l' );
			}
		}
		
		// Devolvemos el resultado traducido
		
		return  $this->_translate( $date, $lang );
	}
	
	/**
	 * @method sort
	 * @access public
	 *
	 * Devuelve la fecha en un formato específico.
	 *
	 * @param 	string 		$date 			Fecha que queremos ordenar
	 * @param 	string 		$type 			Como queremos la salida. Posibles ("num", "short", "long"), Por defecto ("num")
	 * @param 	boolean 	$putDay 		Determina si muestra el día de la semana. Por defecto (false)
	 * @param 	boolean 	$putHour 		Determina si muestra la hora de la fecha. Por defecto (false)
	 * @param 	string 		$lang 			Idioma de salida de la fecha si tiene texto. Posibles ("es", "ca", "en", "fr" ), Por defecto ("es")
	 * @return 	string 		Cadena con la fecha ordenada
	 */
	public function sort( $date, $type = "num", $putDay = false, $putHour = false, $lang = "es" ) {
		// Validmos la fecha
		
		if (( !$date ) or ( !$this->_validate( $date ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamo un objeto de fecha
		
		$date = new \DateTime( $date );
		
		// Tipo de la fecha
		
		if( $type == "long" ){
			$format = 'j F Y';
		} else if ( $type == "short" ){
			$format = 'j M Y';
		} else if ( $type == "num" ){
			$format = 'j/n/Y';
		}
		
		// Ponemos el día de la semana
		
		if ( $putDay  && $type !== "num" ){
			if( $type == "long" ){
				$dia = 'l ';
			}else if( $type == "short" ){
				$dia = 'D ';
			}
		}
		
		// Poner hora
		
		if( $putHour ){
			$hora = ' \&\e\n\s\p\; G:i';
		}
		
		// Damos formato a la fecha
		
		$date = $date->format( $dia . '' . $format . '' . $hora );
		
		// Devolvemos la fecha traducida
		
		return $this->_translate( $date, $lang );
	}
	
	/**
	 * @method week_day
	 * @access public
	 *
	 * Saber el número de día de la semana de una fecha dada
	 *
	 * @param 	string 		$date 		Fecha de la que queremos sabe el número de de día de la semana
	 * @return 	number 	Número con el número del día de la semana, 1 para el lunes, 7 para el domingo
	 */
	public function week_day( $date ){
		// Validmos la fecha
		
		if (( !$date ) or ( !$this->_validate( $date ))) {
			return "No has pasado una fecha válida como argumento";
		}
		
		// Creamos el objeto de la fecha
		
		$date = new \DateTime( $date );
		
		// Sacamos el día de la semana y cambiamos el cero, por el siete que corresponde al domingo.
		
		$result = $date->format( 'w' );
		
		if( $result == 0 ){
			$result = 7;
		}
		
		return intval( $result );
	}
	
	/**
	 * @method translate
	 * @access private
	 *
	 * Traduce una fecha a uno de los idiomas para los que está configurada la clase. Se pueden añadir tantos idiomas como se quieran
	 *
	 * @param 	string 		$date 		Fecha que queremos traducir
	 * @param 	string 		$lang 		Idioma al que queremos traducir la fecha Posibles ( "es", "en", "ca", "fr" ), Por defecto ( "es" )
	 * @return 	string con la fecha traducida a un idioma
	 */
	private function _translate( $date, $lang = "es" ){
		if( $lang == "es" ){
			return str_replace( self::$en, self::$es, $date );
		}else if( $lang == "ca" ){
			return str_replace( self::$en, self::$ca, $date );
		}else if( $lang == "fr" ){
			return str_replace( self::$en, self::$fr, $date );
		}else if( $lang == "en" ){
			return $date;
		}
	}
	
	/**
	 * @method validate
	 * @access private
	 *
	 * Valida que una fecha dada sea válida
	 *
	 * @param 	string 		$date 		Fecha que queremos validar
	 * @return 	boolean	true si la fecha pasada es válida
	 */
	private function _validate( $date ) {
		$sh = explode( " ", $date );
		$sf = explode( "-", $sh [ 0 ] );
		
		return checkdate( $sf[ 1 ], $sf[ 2 ], $sf[ 0 ] );
	}
}

?>