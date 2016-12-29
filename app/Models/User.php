<?php

namespace App\Models;

use JumpGate\Users\Models\User as BaseUser;
use JumpGate\Users\Traits\HasSocials;

class User extends BaseUser
{
    use HasSocials;
}
