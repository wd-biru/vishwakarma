<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\WorkFlowMaster;
use Brexis\LaravelWorkflow\WorkflowRegistry;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getWorkFlow($object, $name)
    {


        $WorkFlow = WorkFlowMaster::where('name',$name)->first();

        if($WorkFlow != null && $WorkFlow->getPlace != null && $WorkFlow->getTransaction != null): 
          foreach ($WorkFlow->getPlace as $key => $value) {
              $place[]=$value->place_name; 
          } 
          foreach ($WorkFlow->getTransaction as $key => $value) { 
              $transitions[$value->trans_name]['from']= $value->getPlaceFrom->place_name;
              $transitions[$value->trans_name]['to']= $value->getPlaceTo->place_name;
          }



          $config  = [ $WorkFlow->name => [
                'type'          => 'workflow', // or 'state_machine'
                'marking_store' => [
                    'type'      => 'single_state',
                    'arguments' => [$WorkFlow->arguments] // currentPlace
                ],
                'supports'      => [$WorkFlow->supports], //"APP\MODELS\NAME"
                'places'        =>  $place ,
                'transitions'   => $transitions,            
            ]
          ];
        else:
          return false;
        endif;



        $workflowRegistry = new WorkflowRegistry($config);



        return $workflowRegistry->get($object, $WorkFlow->name);
    }

    public static function getPoWorkFlow($object, $name)
    {

        $WorkFlow = WorkFlowMaster::where('name',$name)->first();

        if($WorkFlow != null && $WorkFlow->getPlace != null && $WorkFlow->getTransaction != null):
            foreach ($WorkFlow->getPlace as $key => $value) {
                $place[]=$value->place_name;
            }
            foreach ($WorkFlow->getTransaction as $key => $value) {
                $transitions[$value->trans_name]['from']= $value->getPlaceFrom->place_name;
                $transitions[$value->trans_name]['to']= $value->getPlaceTo->place_name;
            }



            $config  = [ $WorkFlow->name => [
                'type'          => 'workflow', // or 'state_machine'
                'marking_store' => [
                    'type'      => 'single_state',
                    'arguments' => [$WorkFlow->arguments] // currentPlace
                ],
                'supports'      => [$WorkFlow->supports], //"APP\MODELS\NAME"
                'places'        =>  $place ,
                'transitions'   => $transitions,
            ]
            ];
        else:
            return false;
        endif;



        $workflowRegistry = new WorkflowRegistry($config);

//        dd($object);

        return $workflowRegistry->get($object, $WorkFlow->name);
    }
}
