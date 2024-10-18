<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ApiArtifactController extends Controller
{
    public function index()
    {
        return new ArtifactCollection(Artifact::all());

    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        return view('artifacts.create');
    }

    public function show($id)
    {
        return new ArtifactResource(Artifact::findOrFail($id));
    }

    public function store(Request $request)
    {

$allRequest = $request->all();
if( $allRequest->latitude &&  $allRequest->longitude ){
            $allRequest->location = new Point($allRequest->latitude, $allRequest->longitude);

}
        $artifact = Artifact::create($allRequest);

        return (new ArtifactResource($artifact))
                ->response()
                ->setStatusCode(201);
    }

    public function delete($id)
    {
        $artifact = Artifact::findOrFail($id);
        $artifact->delete();

        return response()->json(null, 204);
    }
}
