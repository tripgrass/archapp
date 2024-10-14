<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Http\Resources\Player as PlayerResource;
use App\Http\Resources\PlayerCollection;

class ArtifactController extends Controller
{
    public function index()
    {
        return new ArtifactCollection(Artifact::all());
    }

    public function show($id)
    {
        return new ArtifactResource(Artifact::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $artifact = Artifact::create($request->all());

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
