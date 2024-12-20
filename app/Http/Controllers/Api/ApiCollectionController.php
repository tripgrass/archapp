<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Collection;
use App\Models\Image;
use App\Models\User;

use App\Http\Resources\CollectionResource as CollectionResource;
use App\Http\Resources\CollectionResourceCollection;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class ApiCollectionController extends Controller
{
    public function index(Request $request)
    {
        if( isset($request->user) ){
            $user = User::whereEmail($request->user['email'])->first();
            $role = Role::where('name','writer')->first();
            $permissions = $user->permissions;
            $roles = $user->getRoleNames();
       // Log::error('IN INDEX for apiartofactconttroller print_r($requestall,true)');
        //Log::error(print_r($user, true ));
        //Log::error(print_r($user->roles, true ));
        //Log::error(print_r($permissions, true ));
        //Log::error(print_r($roles, true ));

        }
        if( isset( $request->constraint ) && "owner" == $request->constraint ){
            $collections = Collection::all();
        }
        else{
            $collections = Collection::all();
//        $artifacts = ::whereNull('temp')->orWhere('temp', false)->get();
  
        }
//Log::error(print_r($collections, true ));
                    //$artifacts = Artifact::all();

        return new CollectionResourceCollection( $collections );

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

    public function show($id, Request $request)
    {
       Log::error("in show for collection:" . $id);
        Log::error('print_r($requestall,true)');
        //Log::error($id);
        Log::error(print_r($request->all(),true));
        return new CollectionResource(Collection::findOrFail($id));
    }

    public function store(Request $request)
    {

        $allRequest = $request->all();
        Log::error('print_r($requestall,true)');
        Log::error(print_r($allRequest,true));
        if( isset( $request->idOnly ) ){
            $artifact = Artifact::create();
            $artifact->temp = true;
            $artifact->save();
        }
        else{

            if( isset($allRequest['latitude']) &&  isset($allRequest['longitude']) ){
                $allRequest['location'] = new Point($allRequest['latitude'], $allRequest['longitude']);
                unset( $allRequest['latitude'] );
                unset( $allRequest['longitude'] );
            }

            $source = "";
            if( isset($allRequest['images']) && $allRequest['images']){
                $images = $allRequest['images'];
                unset( $allRequest['images'] );
                if( isset($allRequest['imagesMeta']) && $allRequest['imagesMeta']){
                    $imagesMeta = $allRequest['imagesMeta'];
                    unset( $allRequest['imagesMeta'] );
                }
                if( isset($allRequest['source']) ){
                    $source = $allRequest['source'];
                    unset( $allRequest['source'] );
                }
            }
            unset( $allRequest['user_name'] );
            unset( $allRequest['user_email'] );


            /* END IMAGE */
            if( isset($allRequest['id']) && $allRequest['id'] ){
                $artifact = Artifact::find( $allRequest['id'] );
                foreach( $allRequest as $key => $val){
                    $artifact[$key] = $val;
                } 
                $artifact->temp = false;
                $artifact->save();
            }
            else{
                $artifact = Artifact::create($allRequest);
            }

            /* IMAGE */
            if(isset($images)){
                foreach( $images as $i => $image ){
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
                    if( $newImage && $imagesMeta && isset($imagesMeta[$i]) ){
                        $testImagesMeta = json_decode($imagesMeta[$i] );
            Log::error('print_r($testimagesmets)');
            Log::error(print_r($testImagesMeta,true));
            Log::error($testImagesMeta->year);
    //        Log::error( json_decode($imagesMeta[0]));


                        $newImage->year = $testImagesMeta->year ? $testImagesMeta->year : null;
                        $newImage->person_id = $testImagesMeta->person_id ? $testImagesMeta->person_id : null;
            Log::error(print_r($newImage,true));
                        $newImage->save();
                    }
                }

            }
        }
        $artifactResource = new ArtifactResource($artifact);
        /*
        return (new ArtifactResource($artifact))
                ->response()
                ->setStatusCode(201);
                */
                return $artifactResource;
//        return response()->json(["artifact" => $artifactResource])->setStatusCode(201);                
    }

    public function delete(Request $request)
    {
        if( isset($request->user) ){
            $user = User::whereEmail($request->user['email'])->first();
            $role = Role::where('name','writer')->first();
            $permissions = $user->permissions;
            $roles = $user->getRoleNames();
        Log::error('IN INDEX for apiartofactconttroller print_r($requestall,true)');
//        Log::error(print_r($request->all(), true ));
        }
        $artifact = Artifact::findOrFail($request->id);
        $artifact->images()->detach();
        $artifact->persons()->detach();
        $artifact->users()->detach();
        $deleteResult = $artifact->delete();
        if( $deleteResult > 0 ){
            $message = "Artifact was soft deleted";
            $statusCode = 200;
        }
        else{
            $message = "Artifact was not found";
            $statusCode = 400;
        }
        return response()->json(['message' => $message, "deleteResult" => $deleteResult])->setStatusCode($statusCode);
    }
}
