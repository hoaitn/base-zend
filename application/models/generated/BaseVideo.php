<?php
abstract class BaseVideo extends Doctrine_Record{
	public function setTableDefinition()
    {       
        $this->setTableName('video');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));             
        $this->hasColumn('name', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             )); 
        $this->hasColumn('link', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));  
        $this->hasColumn('group_id', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));                                             
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}