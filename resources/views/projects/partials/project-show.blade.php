
 
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ trans('project.show') }}</h3></div>
    <div class="panel-body">
        <table class="table table-condensed">
            <tbody>
                <tr><td class="col-xs-3">{{ trans('project.name') }}</td><td class="col-xs-9">{{ $project->name }}</td></tr>
                <tr><td>{{ trans('project.description') }}</td><td>{!! nl2br($project->description) !!}</td></tr>
                <tr><td>{{ trans('project.proposal_date') }}</td><td>{{ dateId($project->proposal_date) }}</td></tr>
                @can('see-pricings', $project)
                <tr><td>{{ trans('project.proposal_value') }}</td><td class="text-right">{{ formatRp($project->proposal_value) }}</td></tr>
                <tr><td>{{ trans('project.project_value') }}</td><td class="text-right">{{ formatRp($project->project_value) }}</td></tr>
                @endcan
                <tr><td>{{ trans('project.start_date') }}</td><td>{{ dateId($project->start_date) }}</td></tr>
                <tr><td>{{ trans('project.end_date') }}</td><td>{{dateId($project->end_date) }}</td></tr>
                <tr><td>Address</td><td>{{($project->location) }}</td></tr>
                <tr><td>{{ trans('app.status') }}</td><td>{{ $project->present()->status }}</td></tr>
                <tr>
                    <td>{{ trans('project.customer') }}</td>
                    <?php   $client_info = DB::table('vishwa_client_info')->where('id',$project->client_id)->first();    

                    ?>
                    <td>{{$client_info->Client_name}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
