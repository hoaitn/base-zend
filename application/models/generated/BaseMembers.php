<?php

/**
 * BaseMembers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property timestamp $created_date
 * @property timestamp $last_login
 * @property integer $status
 * @property string $tel
 * @property string $mobile
 * @property integer $member_type
 * @property string $address
 * @property string $passport_no
 * @property string $passport_date
 * @property string $passport_address
 * @property string $dept
 * @property Doctrine_Collection $MembersGroup
 */
abstract class BaseMembers extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('members');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('username', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('password', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('email', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));
        $this->hasColumn('created_date', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('last_login', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('status', 'integer', 1, array(
             'type' => 'integer',
             'length' => '1',
             ));
        $this->hasColumn('tel', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('mobile', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('member_type', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '1',
             ));
        $this->hasColumn('address', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));
        $this->hasColumn('passport_no', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('passport_date', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));
        $this->hasColumn('passport_address', 'string', 125, array(
             'type' => 'string',
             'length' => '125',
             ));
        $this->hasColumn('dept', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));

        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('MembersGroup', array(
             'local' => 'id',
             'foreign' => 'members_id'));
    }
}