<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\Criterion;
use App\Models\Rating;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class GradebookController extends Controller
{
    public function index() {
        return view('gradebook.grading');
    }

    public function config() {
        return view('gradebook.config');
    }

    public function myself(){
        $user_id = Auth()->user()->id;
        $user = User::findOrFail($user_id);
        return response()->json($user);
    }


    public function aroserubrics(){
        $aroseRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', 1)->get();
        return response()->json($aroseRubrics);
    }

    public function myrubrics(){
        $user_id = Auth()->user()->id;

        $myRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', $user_id)->get();

        return response()->json($myRubrics);
    }

    public function mystudents(){
        $user_id = Auth()->user()->id;

        $myStudents = Student::where('user_id', $user_id)->get();

        return response()->json($myStudents);
    }

    public function setuserusedrubric(Request $request){
        dd($request);
    }

    public function setuserstudentusedrrating(Request $request){
        dd($request);
    }
}
