<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function getData(){
        $resourceData = Resources::orderBy('filename','asc')->paginate(20);
        return view('resources', compact('resourceData'));
    }

    public function filterByLevel($level){
        $resourceData = Resources::where('level', strtoupper($level))
            ->orderBy('filename','asc')
            ->paginate(20);
        return view('resources', compact('resourceData'));
    }

    public function filterByFormat($format){
        $resourceData = Resources::where('format', $format)
            ->orderBy('filename','asc')
            ->paginate(20);
        return view('resources', compact('resourceData'));
    }

    public function search(Request $request){
        $search = $request->input('search');
        $resourceData = Resources::where('filename', 'LIKE', "%$search%")
            ->orderBy('filename','asc')
            ->paginate(20);
        return view('resources', compact('resourceData'));
    }
}