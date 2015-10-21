<?php

class My_Plugin_Libs extends Zend_Controller_Plugin_Abstract {
	
	public static function randomStr($lengthgth = 6, $type = '') {
		$base = '';
		if ($type == 'numeric') {
			$base = '0123456789';
		} elseif ($type == 'string') {
			$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
		} else {
			$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		}
		$max = strlen ( $base ) - 1;
		$str = '';
		mt_srand ( ( double ) microtime () * 1000000 );
		while ( strlen ( $str ) < $lengthgth )
			$str .= $base {mt_rand ( 0, $max )};
		return $str;
	}
	
	function str2array($string = '', $sparator) {
		$array = array ();
		$array = explode ( $sparator, $string );
		return $array;
	}
	
	function array2str($array = '', $sparator) {
		$str = '';
		$str = implode ( $sparator, $array );
		return $str;
	}
	
	public static function utf8_strtolower($str = '') {
		$source = array ("À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ" );
		$target = array ("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ" );
		return str_replace ( $source, $target, $str );
	}
	
	public static function unUnicode($str = '') {
		$marTViet = array ("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ" );
		$marKoDau = array ("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D" );
		return str_replace ( $marTViet, $marKoDau, $str );
	}
	
	public static function trimSpacer($str) {
		return urlencode ( str_replace ( ' ', '-', self::unUnicode ( $str ) ) );
	}
	
	# This function makes any text into a url frienly
	# This script is created by wallpaperama.com
	public static function clean_url($text) {
		$text = strtolower ( $text );
		$code_entities_match = array (' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '.', '/', '*', '+', '~', '`', '=' );
		$code_entities_replace = array ('-', '-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '' );
		$text = str_replace ( $code_entities_match, $code_entities_replace, $text );
		return $text;
	}
	
	public static function text2url($text = '') {
		return self::clean_url ( self::unUnicode ( $text ) );
	}
	public static function setSplash($message, $code = 'success', $timer = 5000) {
		/*
		 * $code=success|error|inf|notice
		 */
        $ss = new Zend_Session_Namespace('Splash');
        $ss->__set('splash',array ('message' => $message, 'code' => $code, 'timer' => $timer ));	
	}
	public static function getSplash() {
        $ss = new Zend_Session_Namespace('Splash');
        $mesage = $ss->__get('splash');
		if ($mesage['message']) {
			$html = ' <div id="splash" class="response-msg ' . $mesage['code'] . ' ui-corner-all" style="width:40%;margin:0 auto;">' .$mesage['message'] . '</div>
                <script>
		        setTimeout(\'$("#splash").fadeOut("slow")\',' . $mesage['timer'] . ');
		        </script>';
		}
		$ss->__set('splash',array());
		return $html;
	}
	public static function appendCsv($file, $data) {
		$fp = fopen ( $file, 'a' );
		fputcsv ( $fp, $data );
		fclose ( $fp );
	}
	public static function readFileCsv($file, $start = 0, $end = 20, $fields = array()) {
		if (($handle = fopen ( $file, "r" )) !== FALSE) {
			$data = array ();
			for($i = 1; $i <= $end; $i ++) {
				$row = fgets ( $handle, $start + $i, "," );
				if ($fields) {
					foreach ( $fields as $key => $field ) {
						$data [$i] [$field] = $row [$key];
					}
				} else
					$data [] = $row;
			}
			fclose ( $handle );
			return $data;
		}
		return false;
	}
	public static function validCreditCard($credit = array()) {
		$error = array ();
		if ($credit ['card_type'] == '')
			$error [] = 'Please select card type';
		if ($credit ['card_holder_name'] == '')
			$error [] = 'Name of card holder cannot be empty';
		if ($credit ['card_cvc_code'] == '')
			$error [] = 'CVC Code cannot be empty';
		$cardValidator = new Zend_Validate_CreditCard ( array ('type' => array (Zend_Validate_CreditCard::VISA, Zend_Validate_CreditCard::AMERICAN_EXPRESS ) ) );
		if (! $cardValidator->isValid ( $credit ['card_number'] )) {
			$error [] = 'Credit card not valid';
		}
		return $error;
	}
	
	public static function Date2Timestamp($date, $format = 'dd/mm/yyyy') {
		if ($date == '')
			return false;
		$format = strtoupper ( $format );
		switch ($format) {
			case 'YYYY/MM/DD' :
			case 'YYYY-MM-DD' :
				list ( $y, $m, $d ) = preg_split ( '/[-\.\/ ]/', $date );
				break;
			
			case 'YYYY/DD/MM' :
			case 'YYYY-DD-MM' :
				list ( $y, $d, $m ) = preg_split ( '/[-\.\/ ]/', $date );
				break;
			
			case 'DD-MM-YYYY' :
			case 'DD/MM/YYYY' :
				list ( $d, $m, $y ) = preg_split ( '/[-\.\/ ]/', $date );
				break;
			
			case 'MM-DD-YYYY' :
			case 'MM/DD/YYYY' :
				list ( $m, $d, $y ) = preg_split ( '/[-\.\/ ]/', $date );
				break;
			
			case 'YYYYMMDD' :
				$y = substr ( $date, 0, 4 );
				$m = substr ( $date, 4, 2 );
				$d = substr ( $date, 6, 2 );
				break;
			
			case 'YYYYDDMM' :
				$y = substr ( $date, 0, 4 );
				$d = substr ( $date, 4, 2 );
				$m = substr ( $date, 6, 2 );
				break;
			
			default :
				throw new Exception ( "Invalid Date Format: $date -  $format" );
		}
		return mktime ( 0, 0, 0, $m, $d, $y );
	}
	function fileDetail($sFilePath) {
		//First, see if the file exists
		if (is_file ( $sFilePath )) {
			//Gather relevent info about file
			$File ['size'] = filesize ( $sFilePath );
			$File ['name'] = basename ( $sFilePath );
			$File ['extension'] = strtolower ( substr ( strrchr ( $File ['name'], "." ), 1 ) );
			$File ['modified'] = date ( "F d Y H:i:s.", filemtime ( $sFilePath ) );
			$File ['accessed'] = date ( "F d Y H:i:s.", fileatime ( $sFilePath ) );
			$File ['path'] = $sFilePath;
			//This will set the Content-Type to the appropriate setting for the file
			switch ($File ['extension']) {
				case "pdf" :
					$ctype = "application/pdf";
					break;
				case "exe" :
					$ctype = "application/octet-stream";
					break;
				case "zip" :
					$ctype = "application/zip";
					break;
				case "doc" :
					$ctype = "application/msword";
					break;
				case "xls" :
					$ctype = "application/vnd.ms-excel";
					break;
				case "ppt" :
					$ctype = "application/vnd.ms-powerpoint";
					break;
				case "gif" :
					$ctype = "image/gif";
					break;
				case "png" :
					$ctype = "image/png";
					break;
				case "x-png" :
					$ctype = "image/x-png";
					break;	
				case "jpeg" :
				case "jpg" :
					$ctype = "image/jpg";
					break;
				case "mp3" :
					$ctype = "audio/mpeg";
					break;
				case "wav" :
					$ctype = "audio/x-wav";
					break;
				case "mpeg" :
				case "mpg" :
				case "mpe" :
					$ctype = "video/mpeg";
					break;
				case "mov" :
					$ctype = "video/quicktime";
					break;
				case "avi" :
					$ctype = "video/x-msvideo";
					break;
				//The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
				case "txt" :
					die ( "<b>Cannot be used for " . $File ['extension'] . " files!</b>" );
					break;
				default :
					$ctype = "application/force-download";
			}
			$File ['type'] = $ctype;
			return $File;
		} else {
			return false;
		}
	}
	
	public static function toSize($size) {
		$i = 0;
		$iec = array ("b", "Kb", "Mb", "Gb", "Tb", "Pb", "Eb", "Zb", "Yb" );
		while ( ($size / 1024) >= 1 ) {
			$size /= 1024;
			$i ++;
		}
		return round ( $size, 1 ) . ' ' . $iec [$i];
	}
	public static function getFileExt($file) {
		return substr ( $file, - 3 );
	}
}
