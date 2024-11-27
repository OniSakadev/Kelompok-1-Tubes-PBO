<?php

namespace App\Model\Akun;

use App\Model\Model;

abstract class User extends Model
{
    abstract public function register();
    abstract public function find($id);
    abstract public function update();
}
