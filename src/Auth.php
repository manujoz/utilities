<?php namespace Manujoz\Utilities;

class Auth {
    /**
	 * @method generateToken
	 * @access public
	 *
	 * Genera un token aleatorio de auteticación
	 *
	 * @param array $len Longitud del token
	 */
    public static function generateToken($len = 64) {
        return bin2hex(openssl_random_pseudo_bytes($len));
    }
}

?>
