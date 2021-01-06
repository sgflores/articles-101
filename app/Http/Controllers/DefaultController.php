<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    /**
     * Return to default page
     *
     * @return  \Illuminate\View\View
     */
    public function index(){
        return view('index');
    }

    /**
     * Throw not found exception
     *
     * @return \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function notFound(){
        abort(404);
    }
}
