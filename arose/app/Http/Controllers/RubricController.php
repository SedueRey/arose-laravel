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

        $myRubricsData = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', $user_id)
            ->orderBy('title','asc')
            ->paginate(20);

        $otherRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', 1)->count();

        $sharedRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where([
                ['public', '=', 1],
                ['user_id', '!=' , Auth()->user()->id],
                ['user_id', '!=' , 1]
            ])
            ->orderBy('title','asc')
            ->paginate(20);

        $data = [
            'myrubrics' => $myRubricsData,
            'otherrubrics' => $otherRubrics,
            'sharedrubrics' => $sharedRubrics,
        ];

        return view('rubrics.index', $data );
    }

    public function arose()
    {

        $myRubricsData = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', 1)
            ->orderBy('title','asc')
            ->paginate(20);

        $otherRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', Auth()->user()->id)->count();

        $sharedRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where([
                ['public', '=', 1],
                ['user_id', '!=' , Auth()->user()->id],
                ['user_id', '!=' , 1]
            ])
            ->orderBy('title','asc')
            ->paginate(20);

        $data = [
            'myrubrics' => $myRubricsData,
            'otherrubrics' => $otherRubrics,
            'sharedrubrics' => $sharedRubrics,
        ];

        return view('rubrics.arose', $data );
    }

    public function sharedrubrics()
    {

        $myRubricsData = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', 1)
            ->orderBy('title','asc')
            ->paginate(20);

        $otherRubrics = Rubric::with('criteria.ratings', 'usedrubrics')
            ->where('user_id', Auth()->user()->id)->count();

        $sharedRubrics = Rubric::with('criteria.ratings', 'usedrubrics', 'user')
            ->where([
                ['public', '=', 1],
                ['user_id', '!=' , Auth()->user()->id],
                ['user_id', '!=' , 1]
            ])
            ->orderBy('title','asc')
            ->paginate(20);

        // dd($sharedRubrics);

        $data = [
            'myrubrics' => $myRubricsData,
            'otherrubrics' => $otherRubrics,
            'sharedrubrics' => $sharedRubrics,
        ];

        return view('rubrics.shared', $data );
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
            'maxpoints' => 'numeric',
            'passpoints' => 'numeric',
        ]);
        $rubric = new Rubric;
        $rubric->title = $request->rubricTitle;
        $rubric->points = $request->rubricPoints;
        // 2022-01-14
        $rubric->public = isset($request->isPublic);
        $rubric->maxpoints = $request->maxpoints;
        $rubric->passpoints = $request->passpoints;
        // --
        $rubric->user_id = Auth()->user()->id;
        $rubric->save();

        if (isset($request->criteriatitle)) {
            $criteriaKeys = array_keys($request->criteriatitle);
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
                if (isset($request->ratingtitle[$key])) {
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
        /*
        if (
            ($rubric->user_id !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        */
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
    public function edit($id)
    {
        $rubric = Rubric::with('criteria.ratings')->findOrFail($id);
        if (
            ($rubric->user_id !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        $rubricFormData = [
            'id' => $rubric->id,
            'rubricTitle' => $rubric->title,
            'rubricPoints' => $rubric->points,
            'isPublic' => $rubric->public,
            'maxpoints' => $rubric->maxpoints,
            'passpoints' => $rubric->passpoints,
            'criteriatitle' => [],
            'criteriadescription' => [],
            'ratingtitle' => [],
            'ratingpoints' => [],
            'ratingdescription' => [],
        ];
        foreach ($rubric->criteria as $criterion) {
            $rubricFormData['criteriatitle'][$criterion->id] = $criterion->title;
            $rubricFormData['criteriadescription'][$criterion->id] = $criterion->description;
            if (count($criterion->ratings)) {
                $rubricFormData['ratingtitle'][$criterion->id] = [];
                $rubricFormData['ratingpoints'][$criterion->id] = [];
                $rubricFormData['ratingdescription'][$criterion->id] = [];
                foreach ($criterion->ratings as $rating) {
                    $rubricFormData['ratingtitle'][$criterion->id][$rating->id] = $rating->title;
                    $rubricFormData['ratingpoints'][$criterion->id][$rating->id] = $rating->points;
                    $rubricFormData['ratingdescription'][$criterion->id][$rating->id] = $rating->description;
                }
            }
        }
        // dd($rubric, $rubricFormData);
        return view('rubrics.edit', [
            'rubric' => $rubricFormData
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rubric = Rubric::with('criteria.ratings', 'usedrubrics')->findOrFail($id);
        if (
            ($rubric->user_id !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        if (count($rubric->usedrubrics) > 0) {
            abort(403, "You can't modify an in use rubric");
        }
        $validated = $request->validate([
            'rubricTitle' => 'required',
        ]);

        $rubric->title = $request->rubricTitle;
        $rubric->points = $request->rubricPoints;
        // 2022-01-14
        $rubric->public = isset($request->isPublic);
        $rubric->maxpoints = $request->maxpoints;
        $rubric->passpoints = $request->passpoints;
        // --

        foreach ($rubric->criteria as $criterion) {
            $criterion->ratings->each->delete();
        }
        $rubric->criteria->each->delete();

        $rubric->save();
        if (isset($request->criteriatitle)) {
            $criteriaKeys = array_keys($request->criteriatitle);

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

                if (isset($request->ratingtitle[$key])) {
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
            }
        }

        return redirect()->route('editRubric', ['id' => $rubric->id])->with('message', 'Rubric edited!');
    }

    public function duplicate($id) {
        $fromrubric = Rubric::with('criteria.ratings')->findOrFail($id);
        $rubric = new Rubric;
        $rubric->title = 'Copy of '.$fromrubric->title;
        $rubric->points = $fromrubric->points;
        // 2022-01-14
        $rubric->public = $fromrubric->public;
        $rubric->maxpoints = $fromrubric->maxpoints;
        $rubric->passpoints = $fromrubric->passpoints;
        // --
        $rubric->user_id = Auth()->user()->id;
        $rubric->save();

        foreach ($fromrubric->criteria as $criterion) {
            $newcriterion = new Criterion;
            $newcriterion->title = $criterion->title;
            $newcriterion->description = $criterion->description;
            $newcriterion->rubric_id = $rubric->id;
            $newcriterion->save();
            foreach ($criterion->ratings as $rating) {
                $newrating = new Rating;
                $newrating->title = $rating->title;
                $newrating->points = $rating->points;
                $newrating->description = $rating->description;
                $newrating->criterion_id = $newcriterion->id;
                $newrating->save();
            }
        }
        return redirect()->to('rubrics')->with('message', 'Rubric duplicated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rubric = Rubric::with('criteria.ratings', 'usedrubrics')->findOrFail($id);
        if (
            ($rubric->user_id !== Auth()->user()->id) &&
            Auth()->user()->isadmin == false
        ) {
            abort(403, 'PERMISSION DENIED… YOU DIDN’T SAY THE MAGIC WORD!');
        }
        if (count($rubric->usedrubrics) > 0) {
            abort(403, "You can't delete a rubric used in a gradebook");
        }
        foreach ($rubric->criteria as $criterion) {
            $criterion->ratings->each->delete();
        }
        $rubric->criteria->each->delete();
        $rubric->delete();
        return redirect()->to('rubrics')->with('message', 'Rubric deleted!');
    }
}
