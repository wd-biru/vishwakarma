@inject('projectStatuses', 'App\Entities\Projects\Status')


    @foreach($projectStatuses::toArray() as $statusId => $status)

    @php
        $projectCount = array_key_exists($statusId, $projectStatuses) ? $projectStatuses[$statusId] : 0;
        $status ;
    @endphp

    <li>{!! html_link_to_route('projects.index', $status, ['status_id' => $statusId]) !!}</li>


  @endforeach
