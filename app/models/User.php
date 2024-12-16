<?php 

require_once dirname(__FILE__) . '/../core/Model.php';

class User extends Model
{
    protected $table = 'tbl_user';
    protected $fields = array('id', 'nama');
}
