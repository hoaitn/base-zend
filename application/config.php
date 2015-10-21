<?php
ini_set( "memory_limit", "64M" );
ini_set( "display_errors", 1 );
error_reporting( E_ALL & ~ E_NOTICE );
define( 'DOMAIN', 'http://' . $_SERVER ['SERVER_NAME'] );
date_default_timezone_set( 'Asia/Ho_Chi_Minh' );
defined( 'APPLICATION_PATH' ) || define( 'APPLICATION_PATH', dirname( __FILE__ ) . '/' );
defined( 'APPLICATION_ENV' ) || define( 'APPLICATION_ENV', (getenv( 'APPLICATION_ENV' ) ? getenv( 'APPLICATION_ENV' ) : 'development') );
define( 'ROOT_DIR', realpath( APPLICATION_PATH . '/../public/' ) );
define( 'DATA_DIR', '/uploads/' );
set_include_path( implode( PATH_SEPARATOR, array (realpath( APPLICATION_PATH . '../library' ), realpath( APPLICATION_PATH . '../library/ZendFramework' ), realpath( APPLICATION_PATH . '../library/Doctrine' ), get_include_path() ) ) );

define( 'DOCTRINE_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Doctrine' );
define( 'DATA_FIXTURES_PATH', DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'fixtures' );
define( 'MODELS_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'models' );
define( 'MIGRATIONS_PATH', DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'migrations' );
define( 'SQL_PATH', DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'sql' );
define( 'YAML_SCHEMA_PATH', DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'schema' );
//die ( get_include_path () );
require_once ('Doctrine.php');
spl_autoload_register( array ('Doctrine', 'autoload' ) );
spl_autoload_register( array ('Doctrine', 'modelsAutoload' ) );
spl_autoload_register( array ('Doctrine', 'extensionsAutoload' ) );

Doctrine_Manager::getInstance()->setAttribute( 'model_loading', 'conservative' );

if (class_exists( 'PDO' )) {
	try {
		$pdo = new PDO( 'mysql:host=localhost;dbname=bmw', 'root', '' );
		$pdo->exec( "SET NAMES 'utf8'" );
		$conn = Doctrine_Manager::connection( $pdo );
	} catch ( PDOException $e ) {
		echo 'Connection failed: ' . $e->getMessage();
	}
} else {
	$conn = Doctrine_Manager::connection( 'mysql://root:123456@localhost/zhn_db' );
}

$conn->setAttribute( Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_PEAR );
Doctrine_Core::loadModels( array (MODELS_PATH . '/generated', MODELS_PATH ) );