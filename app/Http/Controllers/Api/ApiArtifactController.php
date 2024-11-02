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
        /* IMAGE */
        if(isset($allRequest['images'])){
            foreach( $allRequest['images'] as $image ){
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();

                // Move the image to the desired location
                $image->move(public_path('images'), $imageName);

                $filepath = public_path('images/'.$imageName);
                /*
                try {
                    \Tinify\setKey(env("TINIFY_API_KEY"));
                    $source = \Tinify\fromFile($filepath);
                    $source->toFile($filepath);
                } catch(\Tinify\AccountException $e) {
                    // Verify your API key and account limit.
                    return redirect('upload')->with('error', $e->getMessage());
                } catch(\Tinify\ClientException $e) {
                    // Check your source image and request options.
                    return redirect('upload')->with('error', $e->getMessage());
                } catch(\Tinify\ServerException $e) {
                    // Temporary issue with the Tinify API.
                    return redirect('upload')->with('error', $e->getMessage());
                } catch(\Tinify\ConnectionException $e) {
                    // A network connection error occurred.
                    return redirect('upload')->with('error', $e->getMessage());
                } catch(Exception $e) {
                    // Something else went wrong, unrelated to the Tinify API.
                    return redirect('upload')->with('error', $e->getMessage());
                }            
                */
                // Add image information to the array
                $imageData = ['name' => $imageName];
                $newImage = Image::create($imageData);

                $artifacts  = [1, 2];

                $newImage->artifacts()->attach($artifacts);            
            }
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
