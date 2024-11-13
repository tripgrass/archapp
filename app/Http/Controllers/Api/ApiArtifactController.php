<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Image;
use App\Models\User;

use App\Http\Resources\Artifact as ArtifactResource;
use App\Http\Resources\ArtifactCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ApiArtifactController extends Controller
{
    public function index(Request $request)
    {
        if( isset($request->user) ){

            $user = User::whereEmail($request->user['email'])->first();
        Log::error('IN INDEX for apiartofactconttroller print_r($requestall,true)');
        Log::error($request->user['email']);
        Log::error($request->user['password']);
        Log::error(print_r($user, true ));

        }
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
        Log::error('print_r($requestall,true)');
        Log::error(print_r($allRequest,true));

        if( isset($allRequest['latitude']) &&  isset($allRequest['longitude']) ){
            $allRequest['location'] = new Point($allRequest['latitude'], $allRequest['longitude']);
            unset( $allRequest['latitude'] );
            unset( $allRequest['longitude'] );
        }

        $source = "";
        if( isset($allRequest['images']) && $allRequest['images']){
            $images = $allRequest['images'];
            unset( $allRequest['images'] );
            if( isset($allRequest['source']) ){
                $source = $allRequest['source'];
            }
        }


        /* END IMAGE */
        if( isset($allRequest['id']) && $allRequest['id'] ){
            $artifact = Artifact::find( $allRequest['id'] );
            foreach( $allRequest as $key => $val){
                $artifact[$key] = $val;
            } 
            $artifact->save();
        }
        else{
            $artifact = Artifact::create($allRequest);
        }

        /* IMAGE */
        if(isset($images)){
        Log::error('print_r($images,true)');
        Log::error(print_r($images,true));
            foreach( $images as $image ){
                if( 'web' == $source ){ 

                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName);
                    $filepath = public_path('images/'.$imageName);

                    $imageData = ['name' => $imageName];
                    $newImage = Image::create($imageData);

                    //$artifacts  = [1, 2];

                    $newImage->artifacts()->attach($artifact);            
                }
                else{
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

                    //$artifacts  = [1, 2];

                    $newImage->artifacts()->attach($artifact);            
                }
            }

        }

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
