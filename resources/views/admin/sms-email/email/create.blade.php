@extends('layout.app')
@section('title')
<div class="page-title">
    <div class="div">
        <h1><i class="fa fa-laptop"></i>E-mail Setting</h1>
    </div>
    <div class="div">
        <ul class="breadcrumb">
            <li><i class="fa fa-home fa-lg"></i></li>
            <li><a href="#">E-mail Setting</a></li>
        </ul>
    </div>
</div>
@endsection
@section('content')
@include('includes.msg')

<div class="mytabs">
    <div class="cardtb">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="row">
                    <form class="form-horizontal" action="{{route('email.store')}}" method="post">
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
