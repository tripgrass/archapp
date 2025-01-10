<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Elo;
use App\Models\User;

use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use App\Http\Resources\Elo as EloResource;
use App\Http\Resources\EloCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiEloController extends Controller
{
    public function index(Request $request)
    {
        Log::error('in ELO print_r($requestall,true)');
        Log::error(print_r($request->all(),true));

//        $persons = Person::all();
      //  Log::error(print_r($persona,true));
        //Log::error(print_r($persons,true));

  //      return new PersonCollection( $persons );

    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        return view('persons.create');
    }

    public function show($id, Request $request)
    {
       // Log::error($id);
        //Log::error('print_r($requestall,true)');
        //Log::error($id);
        //Log::error(print_r($request->all(),true));
        return new EloResource(Elo::findOrFail($id));
    }

    public function store(Request $request)
    {

        $allRequest = $request->all();
        Log::error('print_r($requestall,true)');
        Log::error(print_r($allRequest,true));

        /* END IMAGE */
        if( isset($allRequest['id']) && $allRequest['id'] ){
            $elo = Elo::find( $allRequest['id'] );
            foreach( $allRequest as $key => $val){
                $elo[$key] = $val;
            } 
            $elo->save();
        }
        else{
            $elo = Elo::create($allRequest);
        }
        return (new EloResource($elo))
                ->response()
                ->setStatusCode(201);
    }

    public function storeCompare(Request $request)
    {

        $allRequest = $request->all();
        Log::error('print_r($requestall,true)');
        Log::error(print_r($allRequest,true));
        $category = $request->category ? $request->category : 'general';
        /* END IMAGE */
        //'secondary_artifact_one_id'
        //'rating_signatory_one'
        //'rating_demos_one'
        //'secondary_artifact_two_id'
        //'rating_signatory_two'
        //'rating_demos_two'

    $relationshipOne = Elo::firstOrCreate(
        [
            'primary_artifact_id' => $request->primary_artifact_id,
            'secondary_artifact_id' => $request->secondary_artifact_one_id,
            'category' => $category,
        ],
        [
            'rating_signatory' => 0,
            'rating_demos' => 0
        ]
    );
    $relationshipTwo = Elo::firstOrCreate(
        [
            'primary_artifact_id' => $request->primary_artifact_id,
            'secondary_artifact_id' => $request->secondary_artifact_two_id,
            'category' => $category,
        ],
        [
            'rating_signatory' => 0,
            'rating_demos' => 0
        ]
    );    
        
$mFactor = 400;
        $maxScore = 4;
        $kFactor = 1;
        $log10 = 0;
        $pointFactor = 1;


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

        if( 4 > $request->comparison ){
            // favors relationshipOne
            $scoreOne = ( 4 - $request->comparison );
            $scoreTwo = 0;
        }
        if( 4 < $request->comparison ){
            // favors relationshipTwo
            $scoreTwo = ( $request->comparison - 4);
            $scoreOne = 0;
        }        
        if( 4 == $request->comparison ){
            $scoreOne = 0;
            $scoreTwo = 0;
        }
        if( abs($scoreOne - $scoreTwo) > 0 ){
            $log10 = log10( abs($scoreOne - $scoreTwo) );
            $pointFactor = 2 + pow( $log10 , 3);
        }
         Log::error( "Expected_Rating_One--->".$Expected_Rating_One."<br>"); 
         Log::error( "Expected_Rating_Two--->".$Expected_Rating_Two."<br>"); 
         Log::error("scoreOne--->".$scoreOne."<br>"); 
         Log::error("scoreTwo--->".$scoreTwo."<br>");
         Log::error("log10--->".$log10."<br>"); 
         Log::error("pointFactor--->".$pointFactor."<br>"); 


        $New_Rating_One = $R1_existing + $pointFactor * $kFactor * ($scoreOne - $Expected_Rating_One);
        $New_Rating_Two = $R2_existing + $pointFactor * $kFactor * ($scoreTwo - $Expected_Rating_Two);

         Log::error( "--->".$New_Rating_One); 
         Log::error( "--->".$New_Rating_Two); 

        if( 'signatory' == $request->ratingType ){
            $relationshipOne->rating_signatory = $New_Rating_One;
            $relationshipTwo->rating_signatory = $New_Rating_Two;
        }
        $relationshipOne->save();
        $relationshipTwo->save();        
        return (new EloCollection([$relationshipOne, $relationshipTwo]))
                ->response()
                ->setStatusCode(201);
    }    

    public function delete($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return response()->json(null, 204);
    }
}
