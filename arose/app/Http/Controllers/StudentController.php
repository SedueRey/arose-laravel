<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();
        $instructorId = $user->id;
        $data = [
            'user' => $user
        ];
        $studentData = Student::where('user_id', $instructorId)
            ->orderBy('name','asc')
            ->paginate(20);
        $data['studentData'] = $studentData;
        return view('students', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('studentnew');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'level' => 'required',
            'age' => 'integer',
        ]);
        $instructorId = Auth()->user()->id;
        Student::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'age' => $request->age,
            'class' => $request->class,
            'group' => $request->group,
            'level' => $request->level,
            'user_id' => $instructorId,
        ]);
        return redirect()->to('students')->with('message', 'Student created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $student = Student::find($uuid);
        if ($student->user_id !== Auth()->user()->id) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        return view('studentedit', [
            'student' => $student
        ]);
    }

    public function delete($uuid)
    {
        $student = Student::find($uuid);
        if ($student->user_id !== Auth()->user()->id) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        DB::table('rating_student')->where('student_id', '=', $uuid)->delete();
        $student->delete();
        return redirect()->to('students')->with('message', 'Student deleted!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $validated = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'level' => 'required',
            'age' => 'integer',
        ]);
        $instructorId = Auth()->user()->id;
        $student = Student::find($uuid);
        if (
            $student->user_id !== Auth()->user()->id
            || $uuid !== $student->id
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        $student->name = $request->name;
        $student->surname = $request->surname;
        $student->age = $request->age;
        $student->class = $request->class;
        $student->level = $request->level;
        $student->group = $request->group;
        $student->save();
        return redirect()->to('students')->with('message', $student->name.' data modified!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
