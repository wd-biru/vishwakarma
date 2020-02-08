@extends('layout.app')
{{----}}
@section('content')
    <style type="text/css">
        #errmsg
        {
            color: red;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 90px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e09393;
            /*background-color: #ccc;*/
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            right: 0;
            height: 30px;
            width: 30px;
            left: 2px;
            top: 2px;
            bottom: 0;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        /*input:checked + .slider {
              background-color: #b4efc9;
            background-color: #00786a;
            }*/
        input:checked + .slider {
            /* background-color: #b4efc9;*/
            background-image:  linear-gradient(#69E0E8 , #007869);
            border: 1px solid #17827b;
        }
        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(56px);
        }
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        span.left {
            margin-top: 10px;
            margin-left: 6px;
            float: left;
            color: #151110;
            font-size: 12PX;
            font-weight:500;
        }
        span.right {
            float: right;
            margin-top: 10px;
            margin-right: 9px;
            color: #151110;
            font-size: 12PX;
            font-weight: 500;
        }
    </style>
    <!-- Side-Nav-->
    <div class="content-wrapper">
        <div class="page-title" >
            <div>
                <h1><i class="fa fa-dashboard"></i>&nbsp;General</h1>
            </div>

            <div>
                <center>
                    @if(Session::has('success'))
                        <font style="color:red">{!!session('success')!!}</font>
                    @endif
                </center>

                </center>
            </div>
            <div>
                <ul class="breadcrumb">
                    <li><a href="{{route('portal.dashboard')}}"><i class="fa fa-home fa-lg"></i></a></li>
                    <li><a href="#">Portal Config</a></li>
                    <li><a href="#">General</a></li>
                </ul>
            </div>
        </div>

        @if($AdminconfigtModels->count()>0)

            <form class="form-horizontal" action="{{url('#')}}" method="post" style="margin-top: 30px">
                <input type="hidden" class="form-control" name="RO_code" id="sel1" value="{{Auth::user()->getRocode->portal_no}}">
                {{ csrf_field() }}
                @foreach($AdminconfigtModels as $key => $AdminconfigtModele)

                    <div class="col-md-6">
                        <h2 class="text-center" style="font-size: 25px;background-color: #eee;padding-bottom: 15px; border-radius: 5px;line-height: 36px;">{{$key}}</h2>
                        <ul id="sortablePaymentMode" style=" padding:0px;background-color: #eee; padding-bottom: 2px; border-radius: 5px; margin-top:-10px">
                            @foreach($AdminconfigtModele as $AdminconfigtModel)
                                @if($AdminconfigtModel->input_type=='checkbox')
                                    <li class="card" style="padding:8px 15px 8px 15px; margin-bottom:8px;list-style:none;width:100%;">
                                        <div class="" style="margin-bottom: 33px;">
                                            <div class="col-md-6">
                                                <input type="hidden" name="field[]" value="{{$AdminconfigtModel->field_name}}">
                                                <label >{{$AdminconfigtModel->field_label}} </label>
                                            </div>
                                            <div class="col-md-6 " >
                                                <label class="switch pull-right">
                                                    <input style="margin-top:15px; " type="checkbox" name="{{$AdminconfigtModel->field_name}}" id="{{$AdminconfigtModel->field_name}}" @if($AdminconfigtModel->value!=null)checked @endif/>
                                                    <span class="slider round"> <span class="left">Yes</span> <span class="right">No</span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if($AdminconfigtModel->input_type=='datetimepicker')
                                    <li class="card" style="padding:8px 15px 8px 15px; margin-bottom:8px;list-style:none;width:100%;">
                                        <div class="" style="margin-bottom: 33px;">
                                            <div class="col-md-7">
                                                <input type="hidden" name="field[]" value="{{$AdminconfigtModel->field_name}}">
                                                <label >{{$AdminconfigtModel->field_label}}</label>
                                            </div>
                                            <div class="col-md-5">
                                                <?php $ndates= new \Carbon\Carbon($AdminconfigtModel->value); ?>
                                                <input style="width: 113%" type="text" class="form-control datetimepicker1" required="required" name="{{$AdminconfigtModel->field_name}}" id="{{$AdminconfigtModel->field_name}}" value="{{$ndates->format('d/m/Y h:s A')}}"  placeholder="Value"/>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if($AdminconfigtModel->input_type=='text')
                                    <li class="card" style="padding:8px 15px 8px 15px; margin-bottom:8px;list-style:none;width:100%;">
                                        <div class="" style="margin-bottom: 33px;">
                                            <div class="col-md-6">
                                                <input type="hidden" name="field[]" value="{{$AdminconfigtModel->field_name}}">
                                                <label >{{$AdminconfigtModel->field_label}}</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control pull-right" required="required" name="{{$AdminconfigtModel->field_name}}" value="{{$AdminconfigtModel->value}}"  placeholder="Value"/>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endforeach



                <div class="col-md-12" style="margin-bottom: 40px">
                    <center>
                            <input type="submit" class="btn btn-primary" id="updateconfig" value="Update">
                    </center>
                </div>
            </form>
        @endif
    </div>


<!-- Javascripts-->
@section('script')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('.datetimepicker1').datetimepicker({
                defaultDate:'01/01/2018 06:00:00',
                format: 'DD/MM/YYYY hh:mm:ss A',
                widgetPositioning: {
                    vertical: 'bottom'
                }
            });
            setManualSlipBookOption();
            $(document).on("click","#use_manual_slip_book",function(e){
                setManualSlipBookOption();
            });
        });
        function setManualSlipBookOption(){
            if($("#use_manual_slip_book").is(":checked")){
                $("#slip_book_container").show();
                //$("#slip_book").prop('checked', true);
            }
            else{
                $("#slip_book").prop('checked', false);
                $("#slip_book_container").hide();
            }
        }
    </script>

    <script>$('.table-responsive').on('show.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "inherit" );
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "auto" );
        })
        $(document).ready(function() {
            $(".submit-button").on("click", function(){
                return confirm("Do you want to Continue? ");
            });
        });

        $('input[name=Use_Common_Otp]'). removeAttr("required");
        $(document).ready(function(){
            $('input[name=Use_Common_Otp]').blur(function(){
                if(/^\d*$/.test($(this).val()) && parseInt($(this).val().length)<=4 || $(this).val()==''){
                    $("#updateconfig").attr("disabled", false);
                }else{
                    alert('Enter otp only numeric value and length maximum 4 digit!!');
                    $("#updateconfig").attr("disabled", true);
                }
            });
        });

    </script>
@endsection