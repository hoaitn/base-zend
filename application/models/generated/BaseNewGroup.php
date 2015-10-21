<?php
abstract class BaseNewGroup extends Doctrine_Record{
public function setTableDefinition()
    {
        $this->setTableName('group_news');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));  
        $this->hasColumn('setions_id', 'integer', 11, array(
             'type' => 'integer',            
             'length' => '11',
             ));           
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',            
             'length' => '4',
             ));                                              
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}
