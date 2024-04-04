<?php

namespace App\Http\Controllers\Api\Beta\Member;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEventDetail;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct(
        private TaskEventDetail $taskEventDetail
    )
    {
    }

    public function loginSocial(){
        return 11;
    }
}
