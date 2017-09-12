<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    const IMAGE_EXTENSION = ['jpg', 'jpeg', 'bmp', 'gif'];
    const CSTEACHING_HOME_URL = 'csteaching/public/';
    const LOGIN_URL = 'manual/public/login';
    const CSTEACHING_LOGIN_URL = 'csteaching/public/login';
    const MODULE_ID = 17;
    const ADMIN_ID = 2;
}
