<?php

namespace App\Http\Controllers;

use App\Models\Elo;
use Illuminate\Http\Request;

class EloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mFactor = 400;
        $maxScore = 4;
        $kFactor = 1;
        $log10 = 0;
        $pointFactor = 1;

        $relationshipOne = Elo::find($request->relationshipOne);
        $relationshipTwo = Elo::find($request->relationshipTwo);
        if( 'signatory' == $request->ratingType ){
            $R1_existing = $relationshipOne->rating_signatory;
            $R2_existing = $relationshipTwo->rating_signatory;
        }
        else{
            $R1_existing = $relationshipOne->rating_demos;
            $R2_existing = $relationshipTwo->rating_demos;
        }

        $Expected_Rating_One = 1 / (1 + pow(10, ( ($R1_existing - $R2_existing) / $mFactor ) ) );
        $Expected_Rating_Two = 1 / (1 + pow(10, ( ($R2_existing - $R1_existing) / $mFactor ) ) );

        if( 5 > $request->comparison ){
            // favors relationshipOne
            $scoreOne = ( 5 - $request->comparison );
            $scoreTwo = 0;
        }
        if( 5 < $request->comparison ){
            // favors relationshipTwo
            $scoreTwo = ( $request->comparison - 5);
            $scoreOne = 0;
        }        
        if( 5 == $request->comparison ){
            $scoreOne = 0;
            $scoreTwo = 0;
        }
        if( abs($scoreOne - $scoreTwo) > 0 ){
            $log10 = log10( abs($scoreOne - $scoreTwo) );
            $pointFactor = 2 + pow( $log10 , 3);
        }
        echo "Expected_Rating_One--->".$Expected_Rating_One."<br>";; 
        echo "Expected_Rating_Two--->".$Expected_Rating_Two."<br>";; 
        echo "scoreOne--->".$scoreOne."<br>"; 
        echo "scoreTwo--->".$scoreTwo."<br>";
        echo "log10--->".$log10."<br>";; 
        echo "pointFactor--->".$pointFactor."<br>";; 


        $New_Rating_One = $R1_existing + $pointFactor * $kFactor * ($scoreOne - $Expected_Rating_One);
        $New_Rating_Two = $R2_existing + $pointFactor * $kFactor * ($scoreTwo - $Expected_Rating_Two);

        echo "--->".$New_Rating_One; 
        echo "--->".$New_Rating_Two; 

        if( 'signatory' == $request->ratingType ){
            $relationshipOne->rating_signatory = $New_Rating_One;
            $relationshipTwo->rating_signatory = $New_Rating_Two;
        }
        $relationshipOne->save();
        $relationshipTwo->save();
        return view('compare');

//        die;
        /*
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $artifact = Artifact::create($request->all());

        return (new ArtifactResource($artifact))
                ->response()
                ->setStatusCode(201);
*/
    }

    /**
     * Display the specified resource.
     */
    public function show(Elo $elo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Elo $elo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Elo $elo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Elo $elo)
    {
        //
    }
}
