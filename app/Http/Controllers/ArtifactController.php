<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use Illuminate\View\View;


class ArtifactController extends Controller
{
    public function index()
    {
        //return new ArtifactCollection(Artifact::all());
        $artifacts = artifact::all();
        return view('artifacts.index', ['artifacts' => $artifacts]);

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
