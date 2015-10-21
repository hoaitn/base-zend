<?php
abstract class BaseColor extends Doctrine_Record{
	public function setTableDefinition()
    {       
        $this->setTableName('car_color');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('car_paint_color', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));        
        $this->hasColumn('image', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));                                              
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}