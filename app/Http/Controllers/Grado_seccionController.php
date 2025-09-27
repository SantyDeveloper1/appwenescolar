<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Grado_seccionController extends Controller
{
    public function actionInsert()
	{
        return view('grado_seccion/insertGrado_seccion');
	}
}
