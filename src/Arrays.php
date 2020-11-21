<?php namespace Manujoz\Utilities;

/**
* CLASE DE ARRAYS
*
* Tratamiento de arrays en PHP
*
* @author http://www.arismanwebs.es
* @copyright ONLINE MYA DISTRIBUCIONES S.L.
*/
class Arrays {	
	/**
	 * @method remove_duplicates
	 * @access public
	 *
	 * Elimina los valores repetidos de un array
	 *
	 * @param array $array Array del que queremos quitar elementos repetidos
	 * @return array Array sin los elementos que se repiten
	 */
	public function remove_duplicates( $array ){
		$new_array = array();
		$A = 0;
		for( $B=0; $array[ $B ] != ""; $B++ ){
			$puesta = "no";
			for( $C=0; $new_array[ $C ] != ""; $C++ ){
				if( $new_array[ $C ] == $array[ $B ] ){
					$puesta = "si";
					break;
				}
			}
			if( $puesta == "no" ){
				$new_array[ $A ] = $array[ $B ];
				$A++;
			}
		}
		return $new_array;
	}
	
	/**
	 * @method repeated
	 * @access public
	 *
	 * Devuelve la cantidad de elementos repetidos de una array
	 *
	 * @param array $array Array del que quermos conocer los repetidos
	 * @param string $sort Orden en el que queremos el retorno de repetidos
	 *     valores posibles ("ASC", "DESC")
	 *
	 * Ej.:
	 *
	 * $arrayCheck = array("rojo","rojo","blanco","blanco","negro","blanco");
	 * $arrayDevuelto = $OBJ_ARRAY->repetidos( $arrayCheck, "DESC" );
	 *
	 * $arrayDevuelto[0]['value'] => blanco
	 * $arrayDevuelto[0]['count'] => 3
	 * $arrayDevuelto[1]['value'] => rojo
	 * $arrayDevuelto[1]['count'] => 2
	 * $arrayDevuelto[2]['value'] => negro
	 * $arrayDevuelto[3]['count'] => 1
	 * 
	 * @return array Array multidimensionales con los elementos y las veces queque se repiten	
	 */
	public function repeated( $array, $sort = "ASC" ){
		if( $sort !== "DESC" && $sort !== "ASC" ) {
			$sort = "ASC";
		}
		
		$repeated = array();
	 
		foreach(( array )$array as $value ){
			$inArray = false;
	 
			foreach( $repeated as $i => $rItem ){
				if( $rItem[ 'value' ] === $value ){
					$inArray = true;
					++$repeated[ $i ][ 'count' ];
				}
			}
	 
			if( false === $inArray ){
				$i = count( $repeated );
				$repeated[ $i ] = array();
				$repeated[ $i ][ 'count' ] = 1;
				$repeated[ $i ][ 'value' ] = $value;
			}
		}
		
		if( $sort == "ASC" ) {
			sort( $repeated );
		} else {
			rsort( $repeated );
		}
		
		return $repeated;
	}

	/**
	 * @method sort
	 * @access public
	 *
	 * Ordena el contenido incluso cuando su contenido tiene tildes
	 *
	 * @param array $array Array que queremos ordenar
	 * @return array Array ordenado de menor a mayor
	 */
	public function sort( $array ){
		// Ordenamos el aray utilizando la función callbackSort como parámetro de uasort
		
		uasort( $array, "self::callbackSort" );
		
		return $array;
	}
	
	/**
	 * CALLBACK SORT
	 *
	 * Función de callback del método uasort para la función ordenar.
	 * esta función no recibe parámetros y solo debe ser llamada desde uaosrt
	 *
	 * @access private
	 */
	private function callbackSort( $name1, $name2 ) {
		$patterns = array(
			'a' => '(á|à|â|ä|Á|À|Â|Ä)',
			'e' => '(é|è|ê|ë|É|È|Ê|Ë)',
			'i' => '(í|ì|î|ï|Í|Ì|Î|Ï)',
			'o' => '(ó|ò|ô|ö|Ó|Ò|Ô|Ö)',
			'u' => '(ú|ù|û|ü|Ú|Ù|Û|Ü)'
		);          
		$name1 = preg_replace( array_values( $patterns ), array_keys( $patterns ), $name1 );
		$name2 = preg_replace( array_values( $patterns ), array_keys( $patterns ), $name2 );          
		return strcasecmp( $name1, $name2 );
	}
}

?>