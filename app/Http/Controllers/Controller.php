<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\dispatchesjobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use dispatchesjobs, ValidatesRequests;
}
