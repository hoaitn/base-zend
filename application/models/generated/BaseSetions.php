<?php
abstract class BaseSetions extends Doctrine_Record{
	public function setTableDefinition()
    {
    	$this->setTableName('setions');
    	$this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '125',
             ));                                                                
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}
