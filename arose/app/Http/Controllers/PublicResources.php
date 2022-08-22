<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicResources extends Controller
{
    public function index()
    {
        $file = app_path().'/Http/Controllers/publicResources.csv';
        $publicResources = [];
        if (($gestor = fopen($file, "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                $publicResources[] = $datos;
            }
            fclose($gestor);
        }
        return view('publicResources', compact('publicResources'));
    }
}
