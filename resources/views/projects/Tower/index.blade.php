@extends('layout.project')

@section('title')
<div class="page-title">
    <div>
        <h1><i class="fa fa-dashboard"></i>&nbsp;Tower</h1>
    </div>
    <div>
        <ul class="breadcrumb"> 
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
            <li>{{ link_to_route('projects.index',trans('project.projects'), ['status_id' => request('status_id', $project->status_id)]) }}</li>
            <li>{{ $project->present()->projectLink }}</li>
            <li><a href="">Tower</a></li>
            
        </ul>
    </div>
</div>

@endsection
 
@section('action-buttons')
@if(Auth::user()->user_type != 'employee')
    {!! html_link_to_route('projects.Tower.create', 'Tower Create', [$project->id], ['class' => 'btn btn-success','icon' => 'plus']) !!}
    
@endif

@endsection

@section('content-project')

@if(count($store_detail)<0)
<p>
    No Employee Found,Please Create Employee First.
</p>
@else
@include('includes.msg')
@include('includes.validation_messages')
<style type="text/css">
  .status{
    width: 15px;
  background: none;
  color: inherit;
  border: none;
  padding: 0;
  font: inherit;
  cursor: pointer;
  outline: inherit;
}
</style>

<div class="row">
<div class="col-md-7">
  <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">&nbsp;Tower List</h3>
        </div>
        <div class="panel-body">
    <div class="card col-md-12 ">
      <div class="table-responsive">
  <table   class="table table-bordered   search-table">
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Tower Name</th>
                            <th>Tower Incharge</th>
                            <th>Add Floor</th>
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>


                             @if(Auth::user()->user_type=="portal")
                            @foreach($store_detail as $store_detail_list)
                            <tr>
                            <td>{{$i++}}</td>
                            <td>
                    <form action="{{route('Tower.Details',[$project->id])}}"  method="post">
                             {{csrf_field()}} 
                    <input type="hidden" name="tower_id" value="{{$store_detail_list->id}}">
                    <button type="submit" class="btn btn-primary"> View {{$store_detail_list->tower_name}}</button>
                    </form>
                                      </td>
                            <td>
                            <?php 
                                $store_details_ids =  explode(',', $store_detail_list->tower_keeper_id);               
                                $store = $store_detail_list->getTowerename($store_details_ids); 


                            ?>
                            @foreach($store as $store_list)       
                                    {{$store_list->first_name}} &nbsp; {{$store_list->last_name}}@if(!$loop->last),@endif
                            @endforeach 
                            </td> 
                            <td>
                             <a type="button"  data-tower_id="{{$store_detail_list->id}}" class="btn btn-primary clickbutton" data-toggle="modal" data-target="#exampleModal">
                          Add Floor
                        </a>
                            </td>    
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    
                </table>






    </div>
    </div>

  </div>
</div>
</div>
 
<div class="col-md-5 show-data">
    <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">&nbsp;Tower Details</h3>
      </div>
      <div class="panel-body">
            <div class="card col-md-12 ">
      <div class="table-responsive">
  <table   class="table table-bordered   search-table">
                    <thead>
                        <tr class="t-head">
                            <th>Sr. No.</th>
                            <th>Floor Name</th>
                            <th>Area (sq.ft)</th>
                        </tr>
                    </thead>
                    <tbody><?php $i=1;?>
                    @if($VishwaProjectTowerdetails!=null)

                            @foreach($VishwaProjectTowerdetails as $list)
                            <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->floor_name}}</td>   
                            <td>{{$list->area}}</td>  
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                    
                </table>

                




    </div>
    </div>
          

</div>
</div>
</div>
 

</div>

@endif

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form action="{{route('Tower.DetailStore',[$project->id])}}"  method="GET">
          {{csrf_field()}} 
        <input type="hidden" name="tower_id" id="tower_id" value="" >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Floor</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <div class="form-group">
    <label for="email">Floor Name</label>
    <input type="text" class="form-control" name="floor_name" required="" autocomplete="off">
  </div>
  <div class="form-group">
    <label for="pwd">Area (sq.ft)</label>
    <input type="number" class="form-control" name="area" required="" step="any" autocomplete="off">
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>

   $(document).ready(function () {
    $('.clickbutton').click(function () {
        var tower_id = $(this).data('tower_id');
       
        $('#tower_id').val(tower_id);
        
    });
});
</script>

  @endsection






















