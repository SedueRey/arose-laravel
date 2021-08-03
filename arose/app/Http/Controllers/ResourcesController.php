<?php

namespace App\Http\Controllers;

use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function create() {
        return view('resources.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'level' => 'required',
            'format' => 'required',
            'filepath' => 'required|mimes:png,jpg,txt,pdf,mp3,mp4,avi,mov|max:3072'
        ]);
        $instructorId = Auth()->user()->id;
        $resource = new Resources;
        $folder = 'resources/'.$instructorId.'/'.date('Y').'/'.date('m');

        if($request->file()) {
            $name = time().'_'.$request->filepath->getClientOriginalName();
            $filePath = $request->file('filepath')->storeAs($folder, $name, 'public');

            $resource->filename = $request->name;
            $resource->filepath = '/storage/' . $filePath;
            $resource->desc = $request->description;
            $resource->level = $request->level;
            $resource->format = $request->format;
            $resource->uploaded_by = $instructorId;

            $resource->save();

            return redirect()->to('resources')
            ->with('message','Resource has been uploaded.');
        }
    }

    public function edit($id)
    {
        $resource = Resources::findOrFail($id);
        if (
            ($resource->uploaded_by !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        return view('resources.edit', [
            'resource' => $resource
        ]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required',
            'level' => 'required',
            'format' => 'required'
        ]);
        $resource = Resources::findOrFail($id);
        if (
            ($resource->uploaded_by !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        $resource->filename = $request->name;
        $resource->desc = $request->description;
        $resource->level = $request->level;
        $resource->format = $request->format;
        $resource->save();

        return back()->with('message','Resource has been updated.');
    }

    public function destroy($id)
    {
        $resource = Resources::findOrFail($id);
        if (
            ($resource->uploaded_by !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }

        $filePath = str_replace('/storage', '', $resource->filepath);

        if(Storage::exists($resource->filepath)){
            Storage::disk('public')->delete($filePath);
        }
        $resource->delete();
        return redirect()->to('resources')->with('message', 'Resource deleted from server');
    }

}
