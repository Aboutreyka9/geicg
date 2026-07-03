<?php

namespace App\Models;

use App\Core\Model;

class Personne extends Model
{
    protected string $table = "users";
    public string $id = 'code_user';
}
