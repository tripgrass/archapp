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

    public function delete($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return response()->json(null, 204);
    }
}
