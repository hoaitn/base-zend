<?php


abstract class BaseTrainer extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('TrainersList');
        $this->hasColumn('trainersListId', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('firstName', 'string', 24, array(
             'type' => 'string',
             'length' => '24',
             ));
        $this->hasColumn('lastName', 'string', 24, array(
             'type' => 'string',
             'length' => '24',
             ));  
        $this->hasColumn('phone', 'string', 16, array(
             'type' => 'string',
             'length' => '16',
             ));  
        $this->hasColumn('email', 'string', 128, array(
             'type' => 'string',
             'length' => '128',
             )); 
        $this->hasColumn('website', 'string', 128, array(
             'type' => 'string',
             'length' => '128',
             ));

       	$this->hasColumn('city', 'string', 24, array(
             'type' => 'string',
             'length' => '24',
             ));
        $this->hasColumn('postCode', 'string', 4, array(
             'type' => 'string',
             'length' => '4',
             ));     
        $this->hasColumn('lat', 'string', 125, array(
             'type' => 'string',
             'length' => '255',
             ));  
       $this->hasColumn('lon', 'string', 125, array(
             'type' => 'string',
             'length' => '255',
             ));
       $this->hasColumn('type', 'string', 30, array(
             'type' => 'string',
             'length' => '30',
             ));      
       $this->hasColumn('websiteNo', 'integer', 11, array(
             'type' => 'string',
             'length' => '11',
             )); 
       $this->hasColumn('website_descript', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));       
       $this->hasColumn('stateNo', 'integer', 4, array(
             'type' => 'integer',             
             'length' => '4',
             ));                               
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }
}