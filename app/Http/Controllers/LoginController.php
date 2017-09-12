<?php

namespace App\Http\Controllers;

use App\System;
use Illuminate\Http\Request;
use Sklcc\Csteaching;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $result = Csteaching::checklogin($request, Csteaching::URL.System::LOGIN_URL, System::MODULE_ID);

        $url = Csteaching::URL.System::CSTEACHING_LOGIN_URL."?url=".Csteaching::URL.System::LOGIN_URL."&id=".System::MODULE_ID;

        if($request->has('target'))
            $url .= ('&target='.$request->get('target'));

        if(!$result['status'])
            return redirect($url);

        $user = \App\User::where('user_account', $request->get('userid'))->first();

        if(!$user)
            return redirect(Csteaching::URL.System::CSTEACHING_HOME_URL."?message=您没有权限访问此模块&type=error&from=用户手册");

        session()->put('mn_userid', $user->id);
        session()->put('mn_useraccount', $user->user_account);
        session()->put('mn_username', $user->user_name);
        session()->put('mn_userrole', $user->user_role_id);
        session()->put('mn_adminid', System::ADMIN_ID);

        $log_data = [
            '_SERVER' => $_SERVER,
            'session' => session()->all()
        ];
        Csteaching::log(session('mn_userid'), System::MODULE_ID, Csteaching::LOGIN, '用户登录', json_encode($log_data));

        if($request->has('target'))
            return ManualController::to($request->get('target'));

        return redirect('/');
    }

    public function logout()
    {
        return redirect(Csteaching::URL.System::CSTEACHING_HOME_URL);
    }
}
