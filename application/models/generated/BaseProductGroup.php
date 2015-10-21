<?php
abstract class BaseProductGroup extends Doctrine_Record{
	public function setTableDefinition()
    {
    	$this->setTableName('group_product');
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
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',  
             'length' => '11',
             ));                                                          
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}