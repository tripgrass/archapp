<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Persona;
use App\Models\Artifact;
use App\Models\Image;
use App\Models\User;

use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use App\Http\Resources\Person as PersonResource;
use App\Http\Resources\PersonCollection;
use App\Http\Resources\Image as ImageResource;
use App\Http\Resources\ImageCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ApiImageController extends Controller
{
    public function index(Request $request)
    {
        if( isset( $request->constraint ) && "owner" == $request->constraint ){
            $images = Image::all();
        }
        else{
            $images = Image::all();
        }
        return new ImageCollection( $images );

    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        return view('images.create');
    }

    public function show($id, Request $request)
    {
        Log::error($id);
        Log::error('print_r($requestall,true)');
        Log::error($id);
        Log::error(print_r($request->all(),true));
        return new ImageResource(Image::findOrFail($id));
    }

    public function store(Request $request)
    {

        $allRequest = $request->all();
        Log::error('print_r($requestall,true)');
        Log::error(print_r($allRequest,true));

        /* END IMAGE */
        if( isset($allRequest['id']) && $allRequest['id'] ){
            $image = Image::find( $allRequest['id'] );
            foreach( $allRequest as $key => $val){
                $image[$key] = $val;
            } 
            $image->save();
        }
        else{
            $image = Image::create($allRequest);
        }
        return (new ImageResource($person))
                ->response()
                ->setStatusCode(201);
    }

    public function delete(Request $request)
    {
        Log::error('image dlete print_r($requestall,true)');
        Log::error(print_r($request->all(),true));
        if( $request->artifact_id && $request->image_id ){
            $artifact = Artifact::findOrFail($request->artifact_id);
            $artifact->images()->detach($request->image_id);
//        $image = Image::findOrFail($id);
  //      $image->delete();
            return response()->json(null, 204);
        }
        else{

            return response()->json(null, 500);
        }
    }
}
