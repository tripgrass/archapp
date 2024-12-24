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
//        $collections = ::whereNull('temp')->orWhere('temp', false)->get();
  
        }
//Log::error(print_r($collections, true ));
                    //$collections = Collection::all();

        return new CollectionResourceCollection( $collections );

    }

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        return view('collections.create');
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
            $collection = Collection::create();
            $collection->save();
        }
        else{

            $source = "";
            if( isset($allRequest['images']) && $allRequest['images']){
                $images = $allRequest['images'];
                unset( $allRequest['images'] );
                if( isset($allRequest['source']) ){
                    $source = $allRequest['source'];
                    unset( $allRequest['source'] );
                }
            }
            unset( $allRequest['user_name'] );
            unset( $allRequest['user_email'] );


            /* END IMAGE */
            if( isset($allRequest['id']) && $allRequest['id'] ){
                $collection = Collection::find( $allRequest['id'] );
                foreach( $allRequest as $key => $val){
                    $collection[$key] = $val;
                } 
                $collection->save();
            }
            else{
                $collection = Collection::create($allRequest);
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

                        //$collections  = [1, 2];

                        $newImage->collections()->attach($collection);            
                    }
                    else{
                        $imageName = time() . '_' . uniqid() . '.' . $image->extension();

                        // Move the image to the desired location
                        $image->move(public_path('images'), $imageName);

                        $filepath = public_path('images/'.$imageName);
                        
                        // Add image information to the array
                        $imageData = ['name' => $imageName];
                        $newImage = Image::create($imageData);

                        //$collections  = [1, 2];

                        $newImage->collections()->attach($collection);            
                    }
                    if( $newImage && $imagesMeta && isset($imagesMeta[$i]) ){
                        $testImagesMeta = json_decode($imagesMeta[$i] );

                        $newImage->year = $testImagesMeta->year ? $testImagesMeta->year : null;
                        $newImage->person_id = $testImagesMeta->person_id ? $testImagesMeta->person_id : null;
            Log::error(print_r($newImage,true));
                        $newImage->save();
                    }
                }

            }
        }
        $collectionResource = new CollectionResource($collection);
        /*
        return (new ArtifactResource($collection))
                ->response()
                ->setStatusCode(201);
                */
                return $collectionResource;
//        return response()->json(["collection" => $collectionResource])->setStatusCode(201);                
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
        $collection = Collection::findOrFail($request->id);
        $collection->images()->detach();
        $collection->persons()->detach();
        $collection->users()->detach();
        $deleteResult = $collection->delete();
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
