@extends('layout.app')

@section('title', __('job.on_progress'))

@section('content')
<h1 class="page-header">{{ __('job.on_progress') }}</h1>

<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('project.name') }}</th>
            <th>{{ __('job.name') }}</th>
            <th class="text-center">{{ __('job.tasks_count') }}</th>
            <th class="text-center">{{ __('job.progress') }}</th>
            @can('see-pricings', new App\Entities\Projects\Job)
            <th class="text-right">{{ __('job.price') }}</th>
            @endcan
            <th>{{ __('job.worker') }}</th>
            <th>{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $job->project->nameLink() }}</td>
                <td>
                    {{ $job->nameLink() }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li style="cursor:pointer" title="{{ $task->progress }} %">
                            <i class="fa fa-battery-{{ ceil(4 * $task->progress/100) }}"></i>
                            {{ $task->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ formatDecimal($job->progress) }} %</td>
                @can('see-pricings', $job)
                <td class="text-right">{{ formatRp($job->price) }}</td>
                @endcan
                <td>{{ $job->worker->name }}</td>
                <td>
                    {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-info btn-xs']) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="8">{{ __('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                <th class="text-center">{{ $jobs->sum('tasks_count') }}</th>
                <th class="text-center">{{ formatDecimal($jobs->avg('progress')) }} %</th>
                @can('see-pricings', new App\Entities\Projects\Job)
                <th class="text-right">{{ formatRp($jobs->sum('price')) }}</th>
                @endcan
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
