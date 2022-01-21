<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Student;
use App\Models\StudentRaw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Reader;
use App\Rules\ExcelRule;

class ImportStudentsController extends Controller
{
    public function firstStep(){
        return view('students.index');
    }

    public function showListUploaded(Request $request){
        // dd($request, $request->all(), $request->file());
        $validated = $request->validate([
            // 'studentsfile' => 'required|mimes:csv'
            'studentsfile' => [
                'required',
                new ExcelRule($request->file('studentsfile'))
            ]
        ]);
        $studentRawList = [];
        if ($request->file()) {
            $filepath = $request->file()['studentsfile']->getPathname();
            // dd($request->file()['studentsfile']->getPathname());
            $open = fopen($filepath, "r");
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE)
            {
                $dataThreated = explode(';', $data[0]);
                // dd($dataThreated);
                if( $dataThreated[0] !== 'Family Name') {
                    $status = 'light';
                    $age = $dataThreated[2];
                    $level = strtoupper($dataThreated[4]);
                    if (!in_array($level, ['A1','A2','B1','B2','C1','C2'])) {
                        $status = 'warning';
                        $dataThreated[4] = 'Unknown';
                    }
                    if (!is_numeric($age)) {
                        $status = 'danger';
                        $dataThreated[2] = 0;
                    } else {
                        $dataThreated[2] = intval($age, 10);
                    }
                    $dataThreated[6] = $status;
                    $userRaw = new StudentRaw(
                        $dataThreated[0],
                        $dataThreated[1],
                        $dataThreated[2],
                        $dataThreated[4],
                        $dataThreated[3],
                        $dataThreated[5],
                        $status,
                    );
                    $studentRawList[] = $userRaw;
                }
            }
            // dd($studentRawList);
            fclose($open);
        }
        // return response()->json($studentRawList);
        return view('students.uploadedlist', compact('studentRawList'));
    }
}
