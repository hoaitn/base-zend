<?php
require_once '../library/ZendModelCreator/ZendModelCreator.php';

/**
 * Settings
 */
// Create types
$SETTINGS['types']['create_dto'] = true;
$SETTINGS['types']['create_dao'] = true;
$SETTINGS['types']['create_entity'] = true;
$SETTINGS['types']['create_service'] = true;
$SETTINGS['types']['create_interface'] = true;
$SETTINGS['types']['create_errorconstants'] = true;
$SETTINGS['types']['create_exception'] = true;
$SETTINGS['types']['create_genericfiles'] = true;

// MySQL settings
$SETTINGS['mysql_host'] = "localhost";
$SETTINGS['mysql_user'] = "root";
$SETTINGS['mysql_password'] = "";
$SETTINGS['mysql_db'] = "zhn_db";

// Setup the model creator service with our specified settings
$ZendModelCreator = new ZendModelCreator($SETTINGS);
// Get the generated PHP code from our services
$ZendModelCreator->getDataFromServices();

/**
 * Setup the directory structure you want to use,
 * these settings also affect the "require_once" statements
 * throughout the code, therefore you need to specify these
 * settings, even if you are not using the function
 * $ZendModelCreator->writePHPCreatedModelData();
 */
$ZendModelCreator->setDirectoryStructure(
	array(
		"ContainerDir" => "model",
		"DS" => dirname( __FILE__ ) ,
		"DirectoryStructure" => array(
					'DTO' => 'api',
					'DAO' => 'dao',
					'ENT' => 'persistence',
					'SRV' => 'service',
					'INT' => 'api',
					'EXC' => 'service',
					'GEN' => 'db',
					'CON' => 'constants'
		),
		"FileNames" => array(
					'DTO' => '[tbl]DTO.php',
					'DAO' => '[tbl]DAO.php',
					'ENT' => '[tbl]Entity.php',
					'SRV' => '[tbl]Service.php',
					'INT' => 'I[tbl]Service.php',
					'EXC' => '[tbl]ServiceException.php'
		)
	)
);


/**
 * Either runt getPHPCreatedModelData to get the
 * data for each file outputted in an HTML <textarea> element.
 */
//$ZendModelCreator->getPHPCreatedModelData();

/**
 * Or run writePHPCreatedModelData to write all php-files
 * to the specified directorys set with setDirectoryStructure.
 */
$ZendModelCreator->writePHPCreatedModelData();

?>