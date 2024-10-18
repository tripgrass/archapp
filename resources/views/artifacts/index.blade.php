<?php
use App\Models\Artifact;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Enums\Srid;

    $x = 1;
if( $x ){
$n6th = Artifact::create([
    'name' => '100 n 6th ave',
    'location' => new Point(32.223420, -110.968570),
]);
$wcong = Artifact::create([
    'name' => 'w congress',
    'location' => new Point(32.221830, -110.972360),
]);
$s4 = Artifact::create([
    'name' => 's fourth',
    'location' => new Point(32.208080, -110.965510),
]);

}
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


                    <table class=" w-full table-auto bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">ID</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Name</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Email</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">artifact Level</td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($artifacts as $key => $value)
                        <?php print_r($value);
                        echo $value->location->latitude; 
                         ?>
                            <tr class="bg-gray-100 border-b">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $value->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $value->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $value->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $value->artifact_level }}</td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td class="px-6 py-4 whitespace-nowrap">

                                    <!-- delete the artifact (uses the destroy method DESTROY /artifacts/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the artifact (uses the show method found at GET /artifacts/{id} -->
                                    <a class="btn btn-small btn-success" href="{{ URL::to('artifacts/' . $value->id) }}">Show</a>

                                    <!-- edit this artifact (uses the edit method found at GET /artifacts/{id}/edit -->
                                    <a class="btn btn-small btn-info" href="{{ URL::to('artifacts/' . $value->id . '/edit') }}">Edit</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
