@extends('layout.app')
@section('title')
    <div class="page-title">
        <div>
            <h1><i class="fa fa-bank" aria-hidden="true"></i></i>&nbsp; Cheque Management</h1>
        </div>
        <div>
            <ul class="breadcrumb">     
                <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                <li><a href="{{route('portal.bankAccount')}}"> Cheque Management</a></li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plus"></i> Add Cheque Info</h3></div>
            <div class="panel-body">
                @include('includes.msg')
                @include('includes.validation_messages')
                    <form class="form-horizontal" action="{{route('portal.bankAccount.store')}}" method="post" enctype="multipart/form-data">    {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body"> 
                                    <fieldset>
                                        <br>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Bank Name&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-sm-8">
                                            <select class="form-control" required="" name="bank_id" id="bank">
                                                @if(isset($bankMaster))
                                                    <option></option>
                                                    @foreach( $bankMaster as  $bankName)
                                                    <option value="{{$bankName->id}}">{{$bankName->bank_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Cheque Book From&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="cheque_book_From" placeholder="Cheque Book From" required="" value="{{old('cheque_book_From')}}">
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Cheque Book To&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8">
                                            <input class="form-control" type="text" name="cheque_book_to" placeholder="Cheque Book To" required="" value="{{old('cheque_book_to')}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Current Active&nbsp;<span style="color: #f70b0b">*</span></label>
                                            <div class="col-md-8" style="display: inline">
                                                Yes:&nbsp;&nbsp;&nbsp;<input type="radio" name="current_active" value="1" required="required">
                                                No:&nbsp;&nbsp;&nbsp;<input  type="radio" name="current_active" value="0" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit_btn" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
jQuery('#bank').select2({
    tags: true,
    tokenSeparators: [','],
    placeholder: "Select Bank Name"
});
</script>

@endsection