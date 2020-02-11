<br>
{{--{{dd(Auth::user()->user_type=='portal')}}--}}

<?php
use App\Models\ProjectMapping;if (Auth::user()->user_type == 'portal') {
    $portal_id = Auth::user()->getPortal->id;
} else {
    $portal_id = Auth::user()->getEmp->getUserPortal->id;
    $emp_id = Auth::user()->getPortal->id;
    $allowCheck = ProjectMapping::join('vishwa_designation_master', 'vishwa_employee_project_mapping.role_id', 'vishwa_designation_master.id')
        ->where('vishwa_employee_project_mapping.portal_id', $portal_id)
        ->where('vishwa_employee_project_mapping.employee_id', $emp_id)
        ->where('vishwa_employee_project_mapping.project_id', $project->id)
        ->where('vishwa_designation_master.designation', "PROJECT MANAGER")
        ->where('vishwa_employee_project_mapping.is_active', "1")
        ->first();

}
$store_id=\App\Models\VishwaProjectStore::where('project_id',$project->id)->first();
$store=$store_id->id;
?>

<ul class="nav nav-tabs">

    <li class="{{ Request::segment(3) == 'storeInventory' ? 'active' : '' }}">
        {!! link_to_route('storeInventory', 'Store Intial Stock',[$project->id,base64_encode($store)]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'storeInword' ? 'active' : '' }}">
        {!! link_to_route('storeInword', 'Store Inward', [$project->id,base64_encode($store)]) !!}
    </li>

    @if((Auth::user()->user_type=='portal')||($allowCheck !=null))
        <li class="{{ Request::segment(3) == 'getstoreitemlistinvalter' ? 'active' : '' }}">
            {!! link_to_route('getstoreitemlistinvalter', 'View & Alter Inward', [$project->id,base64_encode($store)]) !!}
        </li>
    @endif

    <li class="{{ Request::segment(3) == 'storeoutward' ? 'active' : '' }}">
        {!! link_to_route('storeoutward', 'Store outward', [$project->id,base64_encode($store)]) !!}
    </li>

    @if((Auth::user()->user_type=='portal')||($allowCheck !=null))
        <li class="{{ Request::segment(3) == 'viewandalteroutward' ? 'active' : '' }}">
            {!! link_to_route('viewandalteroutward', 'View and Alter outward', [$project->id,base64_encode($store)]) !!}
        </li>
    @endif

    <li class="{{ Request::segment(3) == 'storetostore' ? 'active' : '' }}">
        {!! link_to_route('storetostore', 'Store To Store Transfer', [$project->id,base64_encode($store)]) !!}
    </li>
    @if((Auth::user()->user_type=='portal')||($allowCheck !=null))
        <li class="{{ Request::segment(3) == 'viewamdalterstoretransfer' ? 'active' : '' }}">
            {!! link_to_route('viewamdalterstoretransfer', 'View And Alter Store Transfer', [$project->id,base64_encode($store)]) !!}
        </li>
    @endif
    <li class="{{ Request::segment(3) == 'currentItemStock' ? 'active' : '' }}">
        {!! link_to_route('currentItemStock', 'Current Store Stock', [$project->id,base64_encode($store)]) !!}
    </li>


</ul>
<br>