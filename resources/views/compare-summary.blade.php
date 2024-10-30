<?php
    use App\Models\Artifact;
    use App\Models\Elo;
$elos = Elo::orderBy('rating_signatory', 'ASC')->get();
?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compare')  }}
        </h2>
    </x-slot>
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
@foreach ($elos as $elo)
<?php $primary_artifact = Artifact::find($elo->primary_artifact_id); 
?>
<?php $secondary_artifact = Artifact::find($elo->secondary_artifact_id); ?>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{$primary_artifact->name}}
                            <img src="{{URL::asset('/images/' .  $primary_artifact->images[0]->name )}}"  height="auto" width="50">
                            <h3>{{$elo->rating_signatory}}</h3>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{$secondary_artifact->name}}
                            <img src="{{URL::asset('/images/' .  $secondary_artifact->images[0]->name )}}"  height="auto" width="50">
                        </div>
                    </div>            
@endforeach                    
                </div>       
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                   
                </div>    
            </main>
        </div>
    </div>
</x-app-layout>
