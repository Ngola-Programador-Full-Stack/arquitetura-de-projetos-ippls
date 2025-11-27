<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return Inertia::render('Welcome');
    }

    public function About(){
        return Inertia::render('Sobre/Index');
    }

    public function feature(){
        return Inertia::render('Recursos/Index');
    }
    public function architecture(){
        return Inertia::render('Arquitetura/Index');
    }
}
