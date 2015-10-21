<?php
abstract class BaseBanner extends Doctrine_Record{
	public function setTableDefinition()
    {       
        $this->setTableName('banner');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('link', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));        
        $this->hasColumn('image', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             )); 
        $this->hasColumn('description', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));
        $this->hasColumn('name', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));                                                        
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}