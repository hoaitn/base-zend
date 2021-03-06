<?php
/**
 * Code generator for DTO objects
 *
 * @author Fredrik Hellstr�m
 * @since 2008-04-21
 *
 */

class DTOCreatorService {

    public static $STRING = 'string';
    public static $INTEGER = 'integer';
    public static $DATETIME = 'datetime';
	public static $ARRAY = 'array';

    private $_data = '';

	/**
	 * Generates a DTO class
	 *
	 * @return string formatted code ready to use
	 *
	 */
	public function createDTO($className, $parameterArray) {
		$this->_generateClassHeader($className);
		$this->_generateClassConstructor($className);
		$this->_generateClassDeclarations($parameterArray['fields']);
		$this->_generateClassGettersSetters($parameterArray['fields']);
		$this->_generateClassToArrayMethod($parameterArray['fields']);
		$this->_generateClassToXmlMethod($parameterArray['fields'], $className);
		$this->_generateClassBindMethod($parameterArray['fields'], $className);
		$this->_generateClassDiffMethod($parameterArray['fields'], $className);
		$this->_generateClassFooter();
		return $this->_data;
	}

	private function _generateClassHeader($className) {
		$this->_data .= "<?php
/**
 * $className Data Transfer Object
 *
 * @author ZendModelCreator ".ZendModelCreator::getVersion().", Fredrik Hellström - Jersey Consulting AB
 * @licence GNU/GPL V 1.0
 * @contact ".ZendModelCreator::getContact()."
 * @since " . date("Y-m-d") . "
 *
 */

require_once('db/GenericDTO.php');

class $className extends GenericDTO {

";
	}

	private function _generateClassConstructor($className) {
		$this->_data .= "\t/**
	 * Constructor
 	 */\n";
		$this->_data .= "\tpublic function $className() {\n";
		$this->_data .= "\t}\n\n";
	}

	private function _generateClassDeclarations($params) {
		$this->_data .= "\t/**
	 * Class declarations
 	 */\n";
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				switch ($type) {
					case self::$STRING:
						$this->_data .= "\tprivate \$_".$name." = '';\n";
						break;
					case self::$INTEGER:
						$this->_data .= "\tprivate \$_".$name." = 0;\n";
						break;
					case self::$DATETIME:
						$this->_data .= "\tprivate \$_".$name." = null;\n";
						break;
					case self::$ARRAY:
						$this->_data .= "\tprivate \$_".$name." = array();\n";
						break;
					default:
						break;
				}
			}
		}
		$this->_data .= "\tprivate \$diff = array();\n";
		$this->_data .= "\n";
	}

	private function _getGetComment($type, $name) {
		if ($type == self::$DATETIME) {
			$type = 'GenericDateTime';
		}
		$data = "\t/**
	 * Gets the $name property
	 * @return $type the $name
	 */\n";
		return $data;
	}

	private function _getSetComment($type, $name) {
		if ($type == self::$DATETIME) {
			$type = 'GenericDateTime';
		}
		$data = "\t/**
	 * Sets the $name property
	 * @param $type the $name to set
	 * @return void
	 */\n";
		return $data;
	}

	private function _generateClassGettersSetters($params) {
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				switch ($type) {
					case self::$STRING:
						$this->_data .= $this->_getGetComment($type, $name);
						$this->_data .= "\tpublic function get".ucfirst($name)."() {\n";
						$this->_data .= "\t\treturn \$this->_$name;";
						$this->_data .= "\n\t}\n\n";

						$this->_data .= $this->_getSetComment($type, $name);
						$this->_data .= "\tpublic function set".ucfirst($name)."($$name) {\n";
						$this->_data .= "\t\t\$this->_$name = $$name;";
						$this->_data .= "\n\t}\n\n";
						break;

					case self::$INTEGER:
						$this->_data .= $this->_getGetComment($type, $name);
						$this->_data .= "\tpublic function get".ucfirst($name)."() {\n";
						$this->_data .= "\t\treturn \$this->_$name;";
						$this->_data .= "\n\t}\n\n";

						$this->_data .= $this->_getSetComment($type, $name);
						$this->_data .= "\tpublic function set".ucfirst($name)."($$name) {\n";
						$this->_data .= "\t\t\$this->_$name = $$name;";
						$this->_data .= "\n\t}\n\n";
						break;

					case self::$DATETIME:
						$this->_data .= $this->_getGetComment($type, $name);
						$this->_data .= "\tpublic function get".ucfirst($name)."() {\n";
						$this->_data .= "\t\treturn \$this->_$name;";
						$this->_data .= "\n\t}\n\n";

						$this->_data .= $this->_getSetComment($type, $name);
						$this->_data .= "\tpublic function set".ucfirst($name)."(GenericDateTime $$name) {\n";
						$this->_data .= "\t\t\$this->_$name = $$name;";
						$this->_data .= "\n\t}\n\n";
						break;

					case self::$ARRAY:
						$this->_data .= $this->_getGetComment($type, $name);
						$this->_data .= "\tpublic function get".ucfirst($name)."() {\n";
						$this->_data .= "\t\treturn \$this->_$name;";
						$this->_data .= "\n\t}\n\n";

						$this->_data .= $this->_getSetComment($type, $name);
						$this->_data .= "\tpublic function set".ucfirst($name)."(array $$name) {\n";
						$this->_data .= "\t\t\$this->_$name = $$name;";
						$this->_data .= "\n\t}\n\n";
						break;

				}
			}
		}
	}

	private function _generateClassToArrayMethod($params) {
		$this->_data .= "\t/**
	 * Generates an array dump of this objects properties
	 * @return array an array of strings
 	 */\n";
		$this->_data .= "\tpublic function toArray() {\n";
		$this->_data .= "\t\t\$aOutput = array();\n";
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				$this->_data .= "\t\t\$aOutput['$name'] = \$this->_$name;\n";
			}
		}
		$this->_data .= "\t\treturn \$aOutput;\n";
		$this->_data .= "\t}\n\n";
	}

	private function _generateClassToXmlMethod($params, $className) {
		$this->_data .= "\t/**
	 * Generates an XML array dump of this objects properties
	 * @return string xml format
 	 */\n";
		$this->_data .= "\tpublic function toXML() {\n";
		$this->_data .= "\t\t\$aOutput = '<$className>';\n";
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				$this->_data .= "\t\t\$aOutput .= '<$name>' . \$this->_$name . '</$name>';\n";
			}
		}
		$this->_data .= "\t\t\$aOutput .= '</$className>';\n";
		$this->_data .= "\t\treturn \$aOutput;\n";
		$this->_data .= "\t}\n\n";
	}

	private function _generateClassBindMethod($params) {
		$this->_data .= "\t/**
	 * Binds input array to object with getters and setters
	 * @return bool true
 	 */\n";
		$this->_data .= "\tpublic function bind(\$aData) {\n";
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				$this->_data .= "\t\tif(isset(\$aData['$name'])) {\n";
				switch ($type) {
					case self::$STRING:
						$this->_data .= "\t\t\t\$this->set".ucfirst($name)."(\$aData['$name']);\n";
						break;
					case self::$INTEGER:
						$this->_data .= "\t\t\t\$this->set".ucfirst($name)."(\$aData['$name']);\n";
						break;
					case self::$DATETIME:
						$this->_data .= "\t\t\t\$this->set".ucfirst($name)."(new GenericDateTime(\$aData['$name']));\n";
						break;
					case self::$ARRAY:
						$this->_data .= "\t\t\t\$this->set".ucfirst($name)."(\$aData['$name']);\n";
						break;
				}
				$this->_data .= "\t\t}\n";
			}
		}
		$this->_data .= "\t\treturn true;\n";
		$this->_data .= "\t}\n\n";
	}

	private function _generateClassDiffMethod($params) {
		$this->_data .= "\t/**
	 * Checks the current object values and compares them to the given array,
	 * returns array with changes
	 * @return array an array of difference
 	 */\n";
		$this->_data .= "\tpublic function diff(\$aCompare) {\n";
		$this->_data .= "\t\t\$aDiff = array();\n";
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				switch ($type) {
					case self::$STRING:
						$this->_data .= "\t\tif(\$this->get".ucfirst($name)."() !== \$aCompare['$name']) {\n\t\t\t\$aDiff['$name'] = array('old' => \$this->get".ucfirst($name)."(), 'new' => \$aCompare['$name']);\n\t\t}\n";
						break;
					case self::$INTEGER:
						$this->_data .= "\t\tif(\$this->get".ucfirst($name)."() !== \$aCompare['$name']) {\n\t\t\t\$aDiff['$name'] = array('old' => \$this->get".ucfirst($name)."(), 'new' => \$aCompare['$name']);\n\t\t}\n";
						break;
					case self::$DATETIME:
						$this->_data .= "\t\tif(\$this->get".ucfirst($name)."()->getTimestamp() !== strtotime(\$aCompare['$name'])) {\n\t\t\t\$aDiff['$name'] = array('old' => \$this->get".ucfirst($name)."(), 'new' => new GenericDateTime(\$aCompare['$name']));\n\t\t}\n";
						break;
					case self::$ARRAY:
						$this->_data .= "\t\tif(\$this->get".ucfirst($name)."() !== \$aCompare['$name']) {\n\t\t\t\$aDiff['$name'] = array('old' => \$this->get".ucfirst($name)."(), 'new' => \$aCompare['$name']);\n\t\t}\n";
						break;
				}
			}
		}
		$this->_data .= "\t\t\$this->diff = \$aDiff;\n";
		$this->_data .= "\t\treturn \$aDiff;\n";
		$this->_data .= "\t}\n";
	}

	private function _generateClassFooter() {
		$this->_data .= "
}
?>";
	}
}
?>