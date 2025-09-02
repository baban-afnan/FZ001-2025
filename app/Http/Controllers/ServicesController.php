<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class ServicesController extends Controller
{
   public function bvnServices()
{
    return view('bvn.index');
}


   public function ninServices()
{
    return view('nin.index');
}


   public function migrationServices()
{
    return view('migration-services');
}


 public function verificationServices()
    {
        return view('verification.index');
    }

     public function supportServices()
    {
        return view('support-services');
    }


     public function SettingServices()
    {
        return view('profile.profile-settings');
    }


    public function transactionPin()
    {
        return view('profile.transactionpin');
    }


  public function vipservices()
    {
    $user = auth()->user();

    if ($user->role === 'agent') {
        return view('vip.index');
    }

    if ($user->role === 'user') {
        return view('vip.migration');
    }
    
    return view('vip.error');
}

}
