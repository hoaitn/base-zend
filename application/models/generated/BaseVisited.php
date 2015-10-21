<?php
abstract class BaseVisited extends Doctrine_Record{
	public function setTableDefinition()
    {       
        $this->setTableName('visited');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             )); 
        $this->hasColumn('visited_date', 'datetime', 0, array(
             'type' => 'datetime',
             'length' => '0',
             ));                                                        
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}