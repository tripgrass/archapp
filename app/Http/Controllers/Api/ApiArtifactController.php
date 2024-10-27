<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Image;

use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Support\Facades\Log;


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
if( isset($allRequest['latitude']) &&  isset($allRequest['longitude']) ){
    $allRequest['location'] = new Point($allRequest['latitude'], $allRequest['longitude']);

}
Log::debug('api artifact controller');
Log::debug(print_r($request->all(),true));
/* IMAGE */

        if(isset($allRequest['images'])){
            $image = $allRequest['images'];
            $imageName = time() . '_' . uniqid() . '.' . pathinfo($image, PATHINFO_EXTENSION);
            Log::debug('imagename.' . $imageName);  
            Log::debug(print_r($image,true));
            // Move the image to the desired location
            $image->move(public_path('images'), $imageName);
  
            // Add image information to the array
            $imageData = ['name' => $imageName];
            $image = Image::create($imageData);

            //$artifacts  = [1, 2];

            //$image->artifacts()->attach($artifacts);            
        }

/* END IMAGE */

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
