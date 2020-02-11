 <!-- Nav tabs -->
@if(Auth::user()->user_type != 'employee')
<br>
<ul class="nav nav-tabs">      
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'allocation' ? 'active' : '' }}">
        {!! link_to_route('allocation.index', trans('project.allocation').' ('.$project->resources->count().')', [$project->id]) !!}
    </li>
    <?php
    $store_id=\App\Models\VishwaProjectStore::where('project_id',$project->id)->first();

    ?>
    <li class="{{ Request::segment(3) == 'store' ? 'active' : '' }}">
        {!! link_to_route('storeInventory', 'Store', [$project->id,$store_id->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'indentResorurce' ? 'active' : '' }}">
        {!! link_to_route('indentResorurce.index','Indent('.$project->indents->count().')',[$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }}">
        {!! link_to_route('projects.jobs.index', trans('project.jobs').' ('.$project->jobs->count().')', [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'Tower' ? 'active' : '' }}">

        {!! link_to_route('Tower.Index','Tower('.$project->towers->count().')',[$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'Quality Check' ? 'active' : '' }}">

        {!! link_to_route('qualityCheck.index',trans('project.qc'),[$project->id]) !!}
    
    <li class="{{ Request::segment(3) == 'agreement' ? 'active' : '' }}">
        {!! link_to_route('projects.agreement.index','Agreement',[$project->id]) !!}
    </li>
        {{--'('.$project->towers->count().')'--}}
    </li>
</ul>
@else
<br>
<ul class="nav nav-tabs">      
    <li class="{{ Request::segment(3) == 'allocation' ? 'active' : '' }}">
        {!! link_to_route('allocation.index', trans('project.allocation'), [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'store' ? 'active' : '' }}">
        {!! link_to_route('store.index', 'Store', [$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'indentResorurce' ? 'active' : '' }}">
        {!! link_to_route('indentResorurce.index','Indent('.$project->indents->count().')',[$project->id]) !!}
    </li>

</ul>
@endif

