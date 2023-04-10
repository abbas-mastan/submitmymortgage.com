<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    //
    public function test()
    {
        echo Hash::make("smm&3344");
        exit;
        Mail::send("emails.account.student-registration",[],function($m){
            $m->from('no-reply@realestateinstructedu.com', 'Real Estate Instruct Education');

            $m->to('ismail@uswat.edu.pk', ucwords('M-Ismail'))->subject('Email Testing');
        });
    }
}
