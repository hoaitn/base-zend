<?php
/**
 * Code generator for DAO objects
 *
 * @author Henrik Hussfelt
 * @since 2008-09-16
 *
 */

class DAOCreatorService {

    public static $STRING = 'string';
    public static $INTEGER = 'integer';
    public static $DATETIME = 'datetime';
	public static $ARRAY = 'array';
	public $primary_key = '';

    private $_data = '';

	/**
	 * Generates a DAO class
	 *
	 * @return string formatted code ready to use
	 *
	 */
	public function createDAO($className, $parameterArray) {
		$this->_setPrimaryKey($parameterArray['primary_key']);
		$this->_generateClassHeader($className);
		$this->_generateFetchAll($className,$parameterArray['fields']);
		$this->_generateFetch($className,$parameterArray['fields']);
		$this->_generateInsert($className,$parameterArray['fields']);
		$this->_generateUpdate($className,$parameterArray['fields']);
		$this->_generateDelete($className);
		$this->_generateClassFooter();
		return $this->_data;
	}

	private function _setPrimaryKey($primary_key) {
		$this->primary_key = $primary_key;
	}

	private function _generateClassHeader($className) {
		$className = $className;
		$folderName = strtolower($className);
		$this->_data .= "<?php
/**
 * Data access object for $className
 *
 * @author ZendModelCreator ".ZendModelCreator::getVersion()."
 * @licence GNU/GPL V 1.0
 * @contact ".ZendModelCreator::getContact()."
 * @since " . date("Y-m-d") . "
 *
 */

require_once('$folderName/".ZendModelCreator::$directoryStructure['DirectoryStructure']['DTO']."/".str_replace("[tbl]",$className,ZendModelCreator::$directoryStructure['FileNames']['DTO'])."');
require_once('$folderName/".ZendModelCreator::$directoryStructure['DirectoryStructure']['ENT']."/".str_replace("[tbl]",$className,ZendModelCreator::$directoryStructure['FileNames']['ENT'])."');
require_once('db/GenericDAO.php');
require_once('db/GenericDateTime.php');

class ".$className."DAO extends GenericDAO {

";
	}

	private function _generateFetchAll($className,$params) {
		// Set fetchAll function headers
		$this->_data.="\tpublic static function fetchAll".'($where = null, $order = null, $count = null, $offset = null) {'."\n";
		$this->_data.="\t\t$".$className."Entity = new ".$className."Entity();\n";
		$this->_data.="\t\t".'$rowset = $'.$className.'Entity->fetchAll($where, $order, $count, $offset);'."\n";
		$this->_data.="\t\t".'if ($rowset->count() == 0) {'."\n";
		$this->_data.="\t\t\treturn null;\n";
		$this->_data.="\t\t}\n";
		$this->_data.="\t\t$".strtolower($className).'DTOs = array();'."\n";
		$this->_data.="\t\t".'foreach ($rowset as $row) {'."\n";
		$this->_data.="\t\t\t$".strtolower($className).'DTO = new '.ucfirst(strtolower($className)).'();'."\n";

		// Set DTO params with getters and setters
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				if($type == self::$DATETIME) {
					$this->_data.="\t\t\t$".strtolower($className).'DTO->set'.ucfirst($name).'(new GenericDateTime($row->'.$name."));\n";
				} else {
					$this->_data.="\t\t\t$".strtolower($className).'DTO->set'.ucfirst($name).'($row->'.$name.");\n";
				}
				// annoying zendstudio alert.
				if($type){
					$type = '';
				}
			}
		}

		// Finish up fetchAll function
		$this->_data.="\t\t\t$".strtolower($className).'DTOs[] = $'.strtolower($className)."DTO;\n\n";
		$this->_data.="\t\t}\n";
		$this->_data.="\t\treturn $".strtolower($className)."DTOs;\n";
		$this->_data.="\t}\n\n";
	}

	private function _generateFetch($className,$params) {
		// Set fetch function headers
		$className = ucfirst(strtolower($className));
		$this->_data.="\tpublic static function fetch(\$$this->primary_key) {\n";
		$this->_data.="\t\t$".$className."Entity = new ".$className."Entity();\n";
		$this->_data.="\t\t".'$row = $'.$className.'Entity->fetchRow($'.$className."Entity->select()->where('".$this->primary_key." = ?', \$$this->primary_key));\n";
		$this->_data.="\t\t".'if ($row == null) {'."\n";
		$this->_data.="\t\t\treturn null;\n";
		$this->_data.="\t\t}\n";
		$this->_data.="\t\t$".strtolower($className).'DTO = new '.ucfirst(strtolower($className)).'();'."\n";

		// Set DTO params with getters and setters
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				if($type == self::$DATETIME) {
					$this->_data.="\t\t\t$".strtolower($className).'DTO->set'.ucfirst($name).'(new GenericDateTime($row->'.$name."));\n";
				} else {
					$this->_data.="\t\t\t$".strtolower($className).'DTO->set'.ucfirst($name).'($row->'.$name.");\n";
				}
				// annoying zendstudio bug.
				if($type){
					$type = '';
				}
			}
		}

		// Finish up fetch function
		$this->_data.="\t\treturn $".strtolower($className)."DTO;\n";
		$this->_data.="\t}\n\n";
	}

	private function _generateInsert($className,$params) {
		// Set fetch function headers
		$className = ucfirst(strtolower($className));
		$this->_data.="\tpublic static function create($className \$".strtolower($className).") {\n";
		$this->_data.="\t\t$".$className."Entity = new ".$className."Entity();\n";
		$this->_data.="\t\t\$data = array(\n";

		// Remove primary
		$params = array_reverse($params);
		array_pop($params);
		$params = array_reverse($params);
		// Make getters
		$tmpdata = '';
		foreach ($params as $param) {
			$param = array_reverse($param);
			foreach ($param as $name => $type) {
				if($type == self::$DATETIME) {
					$extra = "->getFormattedDateTime()";
				} else {
					$extra = "";
				}
				$tmpdata.="\t\t\t'$name'\t\t\t => $".strtolower($className).'->get'.ucfirst($name)."()$extra,\n";
				// annoying zendstudio bug.
				if($type){
					$type = '';
				}
			}
		}
		$this->_data.= substr($tmpdata,0,-2);
		$this->_data.="\n\t\t);\n";
		$this->_data.="\t\treturn $".$className."Entity->insert(\$data);\n";
		$this->_data.="\t}\n\n";
	}

	private function _generateUpdate($className,$params) {
		// Set fetch function headers
		$className = ucfirst(strtolower($className));
		$this->_data.="\tpublic static function update($className \$".strtolower($className).") {\n";
		$this->_data.="\t\t$".$className."Entity = new ".$className."Entity();\n";
		$this->_data.="\t\t\$data = array(\n";

		// Remove primary
		$params = array_reverse($params);
		array_pop($params);
		$params = array_reverse($params);
		// Make getters
		$tmpdata = '';
		foreach ($params as $param) {
			foreach ($param as $name => $type) {
				if($type == self::$DATETIME) {
					$extra = "->getFormattedDateTime()";
				} else {
					$extra = "";
				}
				$tmpdata.="\t\t\t'$name'\t\t\t => $".strtolower($className).'->get'.ucfirst($name)."()$extra,\n";
				// annoying zendstudio bug.
				if($type){
					$type = '';
				}
			}
		}
		$this->_data.= substr($tmpdata,0,-2);
		$this->_data.="\n\t\t);\n";
		$this->_data.="\t\treturn $".$className."Entity->update(\$data, '$this->primary_key = '.\$".strtolower($className).'->get'.ucfirst($this->primary_key)."());\n";
		//$bookingEntity->update($data, 'booking_id = '.$booking->getBooking_id());
		$this->_data.="\t}\n\n";
	}

	private function _generateDelete($className) {
		// Set fetch function headers
		$className = ucfirst(strtolower($className));
		$this->_data.="\tpublic static function delete(\$$this->primary_key) {\n";
		$this->_data.="\t\t$".$className."Entity = new ".$className."Entity();\n";
		$this->_data.="\t\treturn $".$className."Entity->delete('$this->primary_key = '.\$$this->primary_key);\n";
		$this->_data.="\t}\n";
	}

	private function _generateClassFooter() {
		$this->_data .= "
}
?>";
	}
}
?>