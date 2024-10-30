<?php
    use App\Models\Artifact;
    use App\Models\Elo;

    if( isset($artifact_id) ){
        $main_artifact = Artifact::find($artifact_id);
    }
    else{
        $main_artifact = Artifact::select()
        ->inRandomOrder()
        ->limit(1)
        ->first(); 
    }
    $category = 'general';

    $comparison_artifacts = Artifact::select()
        ->where('id', '!=' , $main_artifact->id)
        ->inRandomOrder()
        ->limit(2)
        ->get(); 
    $comparison_one_artifact = $comparison_artifacts[0];
    if( $comparison_one_artifact->id < $main_artifact->id ){
        $comparison_one_primary_artifact_id = $comparison_one_artifact->id;
        $comparison_one_secondary_artifact_id = $main_artifact->id;
    }
    else{
        $comparison_one_primary_artifact_id = $main_artifact->id;
        $comparison_one_secondary_artifact_id = $comparison_one_artifact->id;
    }
    $relationshipOne = Elo::firstOrCreate(
        [
            'primary_artifact_id' => $comparison_one_primary_artifact_id,
            'secondary_artifact_id' => $comparison_one_secondary_artifact_id,
            'category' => $category,
        ],
        [
            'rating_signatory' => 0,
            'rating_demos' => 0
        ]
    );

    $comparison_two_artifact = $comparison_artifacts[1];
    if( $comparison_two_artifact->id < $main_artifact->id ){
        $comparison_two_primary_artifact_id = $comparison_two_artifact->id;
        $comparison_two_secondary_artifact_id = $main_artifact->id;
    }
    else{
        $comparison_two_primary_artifact_id = $main_artifact->id;
        $comparison_two_secondary_artifact_id = $comparison_two_artifact->id;
    }
    $relationshipTwo = Elo::firstOrCreate(
        [
            'primary_artifact_id' => $comparison_two_primary_artifact_id,
            'secondary_artifact_id' => $comparison_two_secondary_artifact_id,
            'category' => $category,
        ],
        [
            'rating_signatory' => 0,
            'rating_demos' => 0
        ]
    );
//    print_r($relationshipTwo);
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compare') . ": " . $category }}
        </h2>
    </x-slot>
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{$main_artifact->name}}
                            <img src="{{URL::asset('/images/' .  $main_artifact->images[0]->name )}}"  height="auto" width="200">
                        </div>
                    </div>
                </div>
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{$comparison_one_artifact->name}}
                            <img src="{{URL::asset('/images/' .  $comparison_one_artifact->images[0]->name )}}"  height="auto" width="200">
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{$comparison_two_artifact->name}}
                            <img src="{{URL::asset('/images/' .  $comparison_two_artifact->images[0]->name )}}"  height="auto" width="200">
                        </div>
                    </div>            
                </div>       
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                    <form method="POST" action="{{ route('elo.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="relationshipOne" value={{$relationshipOne->id}}>
                        <input type="hidden" name="relationshipTwo" value={{$relationshipTwo->id}}>
                        <input type="hidden" name="ratingType" value="signatory">
                    
                        <div class="" style="width:100%; display:flex; justify-content:space-between;">
                            <input type="radio" id="1" name="comparison" value="1" />
                            <input type="radio" id="2" name="comparison" value="2" />
                            <input type="radio" id="3" name="comparison" value="3" />
                            <input type="radio" id="4" name="comparison" value="4" />
                            <input type="radio" id="5" name="comparison" value="5" />
                            <input type="radio" id="6" name="comparison" value="6" />
                            <input type="radio" id="7" name="comparison" value="7" />
                            <input type="radio" id="8" name="comparison" value="8" />
                            <input type="radio" id="9" name="comparison" value="9" />
                        </div>
                   
                       
                   
                        <div class="mb-3">
                            <button class="btn btn-success btn-submit"><i class="fa fa-save"></i> Submit</button>
                        </div>
                    </form>
                </div>    
            </main>
        </div>
    </div>
</x-app-layout>
