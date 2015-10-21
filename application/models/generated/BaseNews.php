<?php

abstract class BaseNews extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('news');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));
        $this->hasColumn('content', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             )); 
        $this->hasColumn('created_date', 'datetime', 0, array(
             'type' => 'datetime',
             'length' => '0',
             )); 
        $this->hasColumn('viewed', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             )); 
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',  
             'length' => '4',
             ));
        $this->hasColumn('members_id', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));
        $this->hasColumn('images', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             )); 
        $this->hasColumn('group_id', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));
        $this->hasColumn('video_id', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));                                   
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}
