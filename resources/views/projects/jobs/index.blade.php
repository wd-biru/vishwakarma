@extends('layout.project')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;{{ trans('project.jobs')}} </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">{{ isset($title) ? $title :  trans('project.details') }}</li>
        </ul>
    </div>
</div>

@endsection

@section('action-buttons')
@if(Auth::user()->user_type != 'employee')
    {!! html_link_to_route('projects.jobs.create', trans('job.create'), [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
    {!! html_link_to_route('projects.jobs.add-from-other-project', trans('job.add_from_other_project'), [$project->id], ['class' => 'btn btn-default','icon' => 'plus']) !!}
    @endif

@endsection

@section('content-project')

@if ($jobs->isEmpty())
<p>{{ trans('project.no_jobs') }},
    {{ link_to_route('projects.jobs.create', trans('job.create'), [$project->id]) }}.
</p>
@else

@foreach($jobs->groupBy('type_id') as $key => $groupedJobs)

<div id="project-jobs" class="panel panel-default table-responsive">
    <div class="panel-heading">
        <div class="pull-right">
            @can('update', $project)
                @if (request('action') == 'sort_jobs')
                    {{ link_to_route('projects.jobs.index', trans('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
                @else
                    {{ link_to_route('projects.jobs.index', trans('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }}
                 
                    {!! link_to_route('projects.jobs-export', trans('project.jobs_list_export_html'), [$project->id, 'html', 'job_type' => $key], ['class' => '','target' => '_blank']) !!} |
                    {!! link_to_route('projects.job-progress-export', trans('project.jobs_progress_export_html'), [$project->id, 'html', 'job_type' => $key], ['class' => '','target' => '_blank']) !!}
              
                @endif
            @endcan
        </div>
        <h3 class="panel-title">
            {{ $key == 1 ? trans('project.jobs') : trans('project.additional_jobs') }}
            @if (request('action') == 'sort_jobs')
            <em>: {{ trans('project.sort_jobs') }}</em>
            @endif
        </h3>
    </div>
    @if (request('action') == 'sort_jobs')
        <ul class="sort-jobs list-group">
            @foreach($groupedJobs as $key => $job)
                <li id="{{ $job->id }}" class="list-group-item">
                    <i class="fa fa-arrows-v" style="margin-right: 15px"></i> {{ $key + 1 }}. {{ $job->name }}
                </li>
            @endforeach
        </ul>
    @else
    <table class="table table-condensed table-striped">
        <thead>
            <th>{{ trans('app.table_no') }}</th>
            <th>{{ trans('job.name') }}</th>
            <th class="text-center">{{ trans('job.tasks_count') }}</th>
            <th class="text-center">{{ trans('job.progress') }}</th>
            @can('see-pricings', new App\Entities\Projects\Job)
            <th class="text-right">{{ trans('job.price') }}</th>
            @endcan
            {{-- <th>{{ trans('job.worker') }}</th> --}}
            <th class="text-center">{{ trans('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($groupedJobs as $key => $job)
            @php
            $no = 1 + $key;
            $job->progress = $job->tasks->avg('progress');
            @endphp
            <tr id="{{ $job->id }}" {!! $job->progress <= 50 ? 'style="background-color: #faebcc"' : '' !!}>
                <td>{{ $no }}</td>
                <td>
                    {{ $job->name }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li>{{ $task->name }}</li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ formatDecimal($job->progress) }} %</td>
                @can('see-pricings', $job)
                <td class="text-right">{{ formatRp($job->price) }}</td>
                @endcan
                {{-- <td>{{ $job->worker->name }}</td> --}}
                <td class="text-center">
                  
                    {!! html_link_to_route('jobs.show', '',[$job->id],['icon' => 'search', 'title' => 'Lihat ' . trans('job.show'), 'class' => 'btn btn-info btn-xs','id' => 'show-job-' . $job->id]) !!}
               
                    @can('edit', $job)
                    {!! html_link_to_route('jobs.edit', '',[$job->id],['icon' => 'edit', 'title' => trans('job.edit'), 'class' => 'btn btn-warning btn-xs']) !!}
                    @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="7">{{ trans('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-center">{{ $groupedJobs->sum('tasks_count') }}</th>
                <th class="text-center">
                    <span title="Total Progress">{{ formatDecimal($groupedJobs->sum('progress') / $groupedJobs->count()) }} %</span>
                    <span title="Overal Progress" style="font-weight:300">({{ formatDecimal($project->getJobOveralProgress()) }} %)</span>
                </th>
                @can('see-pricings', new App\Entities\Projects\Job)
                <th class="text-right">{{ formatRp($groupedJobs->sum('price')) }}</th>
                @endcan
                <th colspan="2">
              
@if(Auth::user()->user_type != 'employee')
                        @if (request('action') == 'sort_jobs')
                            {{ link_to_route('projects.jobs.index', trans('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right']) }}
                        @else
                          
                        @endif
                        @endif
                  
                </th>
            </tr>
        </tfoot>
    </table>
    @endif
</div>
@endforeach

@endif
@endsection

@can('update', $project)
@if (request('action') == 'sort_jobs')

@section('ext_js')
    {!! Html::script(url('assets/js/plugins/jquery-ui.min.js')) !!}
@endsection

@section('script')

<script>
(function() {
    $('.sort-jobs').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            $.post("{{ route('projects.jobs-reorder', $project->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection

@endif
@endcan
