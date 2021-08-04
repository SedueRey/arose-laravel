<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\Criterion;
use App\Models\Rating;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth()->user()->id;

        $myRubricsData = Rubric::with('criteria')
            ->where('user_id', $user_id)
            ->orderBy('title','asc')
            ->paginate(20);

        $data = [
            'myrubrics' => $myRubricsData,
        ];

        return view('rubrics.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rubrics.create');
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
            'rubricTitle' => 'required',
        ]);
        $criteriaKeys = array_keys($request->criteriatitle);

        $rubric = new Rubric;
        $rubric->title = $request->rubricTitle;
        $rubric->points = $request->rubricPoints;
        $rubric->user_id = Auth()->user()->id;
        $rubric->save();

        for ($i = 0; $i < count($criteriaKeys); $i++) {
            $key = $criteriaKeys[$i];

            $criterion = new Criterion;
            $criterion->title = $request->criteriatitle[$key];
            if ( isset( $request->criteriadescription[$key]) ) {
                $criterion->description = $request->criteriadescription[$key];
            } else {
                $criterion->description = '';
            }
            $criterion->rubric_id = $rubric->id;
            $criterion->save();

            $ratingKeys = array_keys($request->ratingtitle[$key]);
            for ($j = 0; $j < count($ratingKeys); $j++) {
                $rkey = $ratingKeys[$j];
                $rating = new Rating;
                $rating->title = $request->ratingtitle[$key][$rkey];
                $rating->points = $request->ratingpoints[$key][$rkey];
                if( isset( $request->ratingdescription[$key][$rkey] ) ) {
                    $rating->description = $request->ratingdescription[$key][$rkey];
                } else {
                    $rating->description = '';
                }
                $rating->criterion_id = $criterion->id;
                $rating->save();
            }
        }
        // dd(array_values($request->criteriatitle), array_keys($request->criteriatitle), $request);
        return redirect()->to('home')->with('message', 'Rubric created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rubric = Rubric::with('criteria.ratings')->findOrFail($id);
        if (
            ($rubric->user_id !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        return view('rubrics.show', [
            'rubric' => $rubric
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubric $rubric)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rubric $rubric)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubric $rubric)
    {
        //
    }
}
