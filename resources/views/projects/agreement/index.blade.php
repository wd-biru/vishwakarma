@extends('layout.project')


@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Agreement </h1>
    </div>
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>  
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li class="active">{{ isset($title) ? $title :  trans('agreement.details') }}</li>
        </ul>
    </div>
</div>

@endsection

@section('content-project')


@include('includes.msg')
@include('includes.validation_messages')


@section('action-buttons')
    @if(Auth::user()->user_type == 'employee')
          <?php 
            $userStage =Auth::user()->getEmp->getUserStage(null); 
          ?> 
          @if($userStage!="")
              {!! html_link_to_route('agreementResource.addagreement', 'Add Agreement', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
          @endif
    @else
        {!! html_link_to_route('agreementResource.uploadAgreement', 'Upload Agreement', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
        {!! html_link_to_route('agreementResource.addagreement', 'Add Agreement', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
    @endif
@endsection

@if(Auth::user()->user_type == 'employee')
  <?php 
    $userStage =Auth::user()->getEmp->getUserStage(null); 
  ?> 
  @if($userStage!="")
     @if($record->isEmpty()) 
        Indent list is empty.So,{{ link_to_route('agreementResorurce.addagreement', 'Add Agreement', [$project->id]) }}. 
    @endif  
  @endif
@else
  @if($record->isEmpty()) 
       Indent list is empty.So,{{ link_to_route('agreementResorurce.addagreement', 'Add Agreement', [$project->id]) }}.           
  @endif    
@endif


<div class="row">
    <div class="col-md-12">
          <div class="table-responsive" style="width:100%">
                    <table id="data-table" class="table table-striped table-bordered search-table">
                            <thead class="t-head">
                                <tr class="tab-text-align">
                                  <th>Sr.</th>
                                  <th>Agreement</th>
                                  <th>Created By</th>
                                  <th>Date</th>
                                  <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>
                                      <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" style="margin-right:5px;">
                                            <li>
                                                <a href="{{route('agreementResorurce.viewAgreement',$project->id)}}" class="btn btn-danger">View Agreement</a>
                                                {{--{!! html_link_to_route('agreementResorurce.viewagreement', 'View Agreement', [$project->id], ['class' => 'btn btn-link']) !!}--}}
                                            </li>
                                        </ul>
                                      </div>
                                  </td> 
                                </tr>
                                
                            </tbody>
                    </table>
                </div>
            </div>
    </div>


@endsection



 
 
