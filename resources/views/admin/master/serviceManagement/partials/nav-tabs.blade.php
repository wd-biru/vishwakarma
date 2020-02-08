<!-- Nav tabs -->
<br>
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == 'Indent' ? 'active' : '' }}">
        {!! link_to_route('projects.estimation.index','Indent',[$project->id]) !!}
    </li>
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('projects.show', trans('project.show'), [$project->id]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }}">
        {!! link_to_route('projects.jobs.index', trans('project.jobs').' ('.$project->jobs->count().')', [$project->id]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'Resource Allocation' ? 'active' : '' }}">
        {!! link_to_route('allocation.index', trans('project.allocation'), [$project->id]) !!}
    </li>

</ul>
<br>
