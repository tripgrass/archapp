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
        if(isset($request->images)){
            foreach( $request->images as $i => $image ){
                if( 'web' == $request->source ){ 

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
        else{        
            // this is only for meta - how to distinguish?
            $modelProps = [
                "title",
                "alttext",
                "year",
                "person_id"
            ];

            /* END IMAGE */
            if( isset($allRequest['id']) && $allRequest['id'] ){
                if( isset($allRequest['id']) && $allRequest['id'] ){
                    $newImage = Image::find( $allRequest['id'] );
                    foreach( $allRequest as $key => $val){
                        if( in_array($key, $modelProps) ){
                            $newImage[$key] = $val;
                        }
                    } 
                    $newImage->save();
                }
                else{
                    $newImage = Image::create($allRequest);
                }
            }
        }
        if( isset($request->artifact_id) && isset( $request->isPrimary ) && $request->isPrimary ){
            Log::error('has artifact');
            $artifact = Artifact::findOrFail($request->artifact_id);
            $artifact->primary_image_id = $newImage->id;
            $artifact->save();
        }
        return new ImageResource($newImage);
    }

    public function delete(Request $request)
    {
        Log::error('image dlete print_r($requestall,true)');
        if( $request->artifact_id && $request->image_id ){
        Log::error('($request)', $request->all());
            $artifact = Artifact::findOrFail($request->artifact_id);
            $artifact->images()->detach($request->image_id);
            return response()->json(null, 204);
        }
        else{

            return response()->json(null, 500);
        }
    }
}
