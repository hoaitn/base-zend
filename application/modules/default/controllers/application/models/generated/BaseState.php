<?php


abstract class BaseState extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('State');
        $this->hasColumn('stateId', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('name', 'string', 3, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '3',
             ));        
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }

}