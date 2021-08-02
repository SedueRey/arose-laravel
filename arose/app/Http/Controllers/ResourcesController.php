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

    public function mine(){
        $resourceData = Resources::where('uploaded_by', Auth()->user()->id)
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

    public function filterByAll($format, $level){
        // dd($format, $level);
        $resourceData = Resources::when($format, function($query, $format){
                if ($format !== 'all') {
                    return $query->where('format', $format);
                }
            })->when($level, function($query, $level){
                if( $level !== 'all' ) {
                    return $query->where('level', strtoupper($level));
                }
            })->orderBy('filename','asc')
            ->paginate(20);

        return view('resources', [
            'resourceData' => $resourceData,
            'format' => $format,
            'level' => $level,
        ]);
    }

    public function filterArose(){
        // dd($format, $level);
        $resourceData = Resources::where('uploaded_by', 1)
            ->orderBy('filename','asc')
            ->paginate(20);

        return view('resources', [
            'resourceData' => $resourceData
        ]);
    }
}
