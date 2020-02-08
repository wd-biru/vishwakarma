 @extends('layout.app')
@section('title')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <div class="page-title">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i></i>&nbsp;Tickets Issue </h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="">Ticket list</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
@include('includes.msg')
@include('includes.validation_messages')
<div class="row">
    <div class="col-md-12">
        <div class="content-section">

            <!-- <a href="{{route('issue.create')}}"><button id="addissue" class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a><br><br> -->
            <button id="addissue"  type="button" style="margin-left: 907px" class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button><br><br>

            <div class="  table-responsive ">
                <table class="table table-bordered main-table search-table " >
                    <thead>
                        <tr class="t-head">
                            <th>Id No</th>
                            <th>Issue Type</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>



                        <?php $i=1;?>
                    @if($issue_list != null && !empty($issue_list))
                        @foreach($issue_list as $list)


                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$list->issue_type}}</td>
                            <td>
                                @if($list->status==1)

                                <form action="{{route('IssueDelete',['id' => $list->id])}}" method="get">
                                    <input type="hidden" name="status" value="0">
                                    <button style="background: white;border:none;outline: none;"  type="submit"><img src="{{ my_asset('images/activate.png') }}"></button >
                                </form>

                                @else
                                    <form action="{{route('IssueDelete',['id' => $list->id])}}" method="get">
                                    <input type="hidden" name="status" value="1">
                                    <button  type="submit" style="background: white;border:none;outline: none;"><img src="{{ my_asset('images/deactivate.png') }}"></button>
                                </form>
                                @endif
                            </td>
                            <td><a style="margin-right: 6px;" class="show_modal" data-name="{{$list->issue_type}}" data-id="{{$list->id}}"><i class="far fa-edit"></i> </a>
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



<div class="modal fade" id="myModalServicesmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="padding-left: 130px;" aria-label="Close"> × </button>
                    <h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp;Add Issue</h5>
                </div>
                <div class="modal-body">
                    <div class="form portlet-body ">

                        {{csrf_field()}}
                        <div class="form-group is-empty">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Issue Name:</label>
                                    <div class="col-md-7">
                     <input class="form-control col-md-8" type="text" id="addissueinput"  name="name" value="" placeholder="Enter issue Name">

                                        <!-- <a href="{{route('issue.create')}}"><button id="addissue" class="btn btn-primary "><i class="fa fa-user-plus" aria-hidden="true" title="New" ></i>&nbsp;&nbsp;Add </button></a> -->



                                        <br><br>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button type="button" id="myModalServicesAdd" class="btn btn-primary pull-right"><i class="fa fa-check">&nbsp;Submit</i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="myModFees" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <form method="post" action="{{route('issue.update')}}">
                <div class="modal-header">
                    {{csrf_field()}}

                    <button class="close" data-dismiss="modal" style="padding-left: 130px;">x</button>
                    <h4>Update Issue</h4>
                </div>
                <div class="modal-body" >
                    <label>Issue Type: </label>
                    <input class="form-control" type="text" required="" id="issue_type" name="issue_type" value="" required>
                     <input  id="issue_type_id" name="id" value="" type="hidden">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="Submit" id="send" ><i class="fa fa-check"></i> Save</button>
                </div>
           </form>
        </div>
    </div>
</div>

@endsection
@section('script')

<script type="text/javascript">
jQuery('.show_modal').on('click',function(){
    jQuery('#myModFees').modal('show');
    var id = jQuery(this).data('id');
    var name = jQuery(this).data('name');
    $("#issue_type").val(name);
    $("#issue_type_id").val(id);
    });


    $('#addissue').on('click', function () {
    jQuery('#myModalServicesmodal').modal('show');
});




 $('#myModalServicesAdd').on('click', function () {
          var issue_type = jQuery('#addissueinput').val();
    if(issue_type =='')
            {
            alert('please fill Issue');
            return false;
            }
        $.ajax({
            type: 'post',
            url: "{{route('portalInfoStore.store')}}",
            data: { issue_type: issue_type, _token: '{{csrf_token()}}' },
            dataType : 'json',
            success: function(response){
                         //alert();
                            if(response.success){
                              if(response.message){
                                 ViewHelpers.notify("success",response.message);
                                 location.reload(true);
                                  jQuery('#myModFees').modal('hide');
                              }
                            }
                            else{
                              if(response.message){
                                 ViewHelpers.notify("error",response.message);
                              }
                            }
                        },
                        error: function(err){
                            //alert(err) ;
                        }
        });
    });






$(document).keypress(function(e) {
  if ($("#myModalServicesmodal").hasClass('in') && (e.keycode == 13 || e.which == 13)) {
   $("#myModalServicesAdd").click();
  }
})

$(document).keypress(function(e) {
  if ($("#myModFees").hasClass('in') && (e.keycode == 13 || e.which == 13)) {
   $("#send").click();
  }
})




</script>
@endsection
