<?php

namespace App\Http\Controllers;

use App\Contracts\NotifyInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // case1: register all Class => __construct
    // private $notify;

    // public function __construct(NotifyInterface $notify)
    // {
    //     $this->notify = $notify;
    // }

    // case2: just register specific function

    public function index()
    {
        return view('home.index');
    }

    // case 1:
    // public function testOne()
    // {
    //     return $this->notify->send();
    //     dd("testOne");
    // }

    // case 2:
    public function testOne(NotifyInterface $notify)
    {
        return $notify->send();
        dd("testOne");
    }
}
