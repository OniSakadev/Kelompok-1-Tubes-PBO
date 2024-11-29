<?php

namespace App\Model;

use App\Model\DB;


abstract class User extends DB
{
    abstract function register();
    abstract function find($id);
    abstract function update();
    abstract function delete($id);
}