<?php


abstract class BaseSeo extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('seo');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('seo_title', 'string', 125, array(
             'type' => 'string',             
             'length' => '3',
             ));    
        $this->hasColumn('seo_description', 'string', 255, array(
             'type' => 'string',             
             'length' => '3',
             ));
        $this->hasColumn('seo_keyword', 'string', 255, array(
             'type' => 'string',             
             'length' => '3',
             ));     
        $this->hasColumn('seo_meta', 'string', 255, array(
             'type' => 'string',             
             'length' => '3',
             ));                     
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }

}