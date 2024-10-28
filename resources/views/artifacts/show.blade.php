<?php
use App\Models\Artifact;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Enums\Srid;

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Artifacts') }}
        </h2>

        <ul class="">
            <li><a href="{{ URL::to('artifacts') }}">View All artifacts</a></li>
            <li><a href="{{ URL::to('artifacts/create') }}">Create a artifact</a>
        </ul>
    </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-max">

                    <h2><?php echo $artifact->name; ?></h2>
                    <ul>
                        <li></li>
                    </ul>
                    <?php if( $artifact->images ) : ?>
                        <?php foreach( $artifact->images as $image ) : ?>
                            <img src="{{URL::asset('/images/' .  $image->name )}}"  height="auto" width="200">
                        <?php endforeach; ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
