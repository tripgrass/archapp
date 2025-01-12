<?php
    use App\Models\Artifact;
    use App\Models\Elo;
$elos = Elo::orderBy('rating_signatory', 'ASC')->get();

?>
<script>
    var dataVoid = {
  "nodes": [
    {
      "id": "Myriel",
      "group": 1
    },
    {
      "id": "Bob",
      "group": 2
    }    
   ],
  "links": [
    {
      "source": "Bob",
      "target": "Myriel",
      "value": 31
    }
    ]
};
</script>
<?php 
    $nodeExcludes = [];
    $nodes = [];
    $links = [];
    foreach ($elos as $elo){
//        print_r($elo->toArray());
        if( !in_array( $elo->primary_artifact_id, $nodeExcludes ) ){
            $thisNode = new StdClass();
            $thisNode->id = $elo->primary_artifact_id;
            $primary_artifact = Artifact::find($elo->primary_artifact_id); 

            $thisNode->group = $primary_artifact->eloGroup;
            $nodes[] = $thisNode;
            $nodeExcludes[] = $elo->primary_artifact_id;
        }
        if( !in_array( $elo->secondary_artifact_id, $nodeExcludes ) ){
            $thisNode = new StdClass();
            $thisNode->id = $elo->secondary_artifact_id;
            $secondary_artifact = Artifact::find($elo->secondary_artifact_id); 
            if( $secondary_artifact ){
            
                $thisNode->group = $secondary_artifact->eloGroup;
                $nodes[] = $thisNode;
                $nodeExcludes[] = $elo->secondary_artifact_id;
            }
        }
        //if( $primary_artifact && $secondary_artifact ){
            $thisLink = new StdClass();
            $thisLink->source = $elo->primary_artifact_id;
            $thisLink->target = $elo->secondary_artifact_id;
            if( $elo->rating_signatory < 0 ){
                $rating = 0;
            }
            else{
                $rating = $elo->rating_signatory ;
            }
            $thisLink->value = $rating;
            $links[] = $thisLink;

//        $primary_artifact = Artifact::find($elo->primary_artifact_id); 
  //      $secondary_artifact = Artifact::find($elo->secondary_artifact_id);
    }
    //print_r($nodes );
?>
<script>
    var data = {
        "nodes" : <?php echo json_encode( $nodes ); ?>,
        "links" : <?php echo json_encode( $links ); ?>,
    };
    console.log('data',data);
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compare Visual')  }}
        </h2>
    </x-slot>
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

            <main class="mt-6">
                    <div id="d3Target"></div>
            </main>
        </div>
    </div>
</x-app-layout>
