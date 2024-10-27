<?php
      
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Artifact;
use Illuminate\View\View;
//use App\Http\Controllers\Log;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
    
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('imageUpload');
    }
         
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {

                    Log::debug(print_r($request->all(),true));
        // Validate incoming request data
        $request->validate([
            'images' => 'required|array'
        ]);
  

        // Initialize an array to store image information
        $images = [];
          Log::debug('An informational message.');

        // Process each uploaded image
        foreach($request->file('images') as $image) {
                    Log::debug(print_r($image,true));

            // Generate a unique name for the image
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
              
            // Move the image to the desired location
            $image->move(public_path('images'), $imageName);
  
            // Add image information to the array
            $images[] = ['name' => $imageName];
        }
  
        // Store images in the database using create method
        foreach ($images as $imageData) {
            $image = Image::create($imageData);

            $artifacts  = [1, 2];

            $image->artifacts()->attach($artifacts);            
        }
          
        return back()->with('success', 'Images uploaded successfully!')
                     ->with('images', $images); 
    }
}
