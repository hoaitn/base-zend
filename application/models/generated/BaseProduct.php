<?php

abstract class BaseProduct extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('product');
        $this->hasColumn('id', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('product_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('product_description', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));
        $this->hasColumn('product_option', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));
        $this->hasColumn('product_engine', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             ));          
        $this->hasColumn('product_details', 'clob', 16777215, array(
             'type' => 'string',
             'length' => '16777215',
             )); 
        $this->hasColumn('product_price', 'float', 11, array(
             'type' => 'float',  
             'length' => '11',
             )); 
        $this->hasColumn('new_status', 'integer', 4, array(
             'type' => 'integer',  
             'length' => '4',
             ));
        $this->hasColumn('view', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));              
        $this->hasColumn('manufacturer', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));           
        $this->hasColumn('warranty', 'integer', 4, array(
             'type' => 'integer',  
             'length' => '4',
             ));
        $this->hasColumn('product_images', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('product_cylinder', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             )); 
        $this->hasColumn('type_of_car', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));  
        $this->hasColumn('transmission', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));   
        $this->hasColumn('number_of_seats', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));              
        $this->hasColumn('id_group_product', 'integer', 11, array(
             'type' => 'integer',  
             'length' => '11',
             ));   
        $this->hasColumn('sold_out', 'integer', 4, array(
             'type' => 'integer',  
             'length' => '4',
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
