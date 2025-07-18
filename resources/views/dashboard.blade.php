<?php
use App\Models\Post;
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<?php
//$posts = Post::published()->get();
//$posts = Post::status('publish')->get();
$posts = Post::published()->hasMetaLike('artifact', '%964%')->first();
print_r($posts);
?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Yeeeou're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
