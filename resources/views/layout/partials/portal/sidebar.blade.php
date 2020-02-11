<?php
// $category = App\Models\MenuMaster::tree();

// dd($category);


$menus = DB::table('vishwa_menu_master')->where('menu_config', 1)->where('is_active', 1)->get();
$menu_per = DB::table('vishwa_menu_permission')->where('user_id', Auth::user()->id)->where('is_active', 1)->get();
?>

<li><a href="{{route('portal.dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>

<li class="treeview"><a href="#"><i class="fa fa-cog"></i><span>Portal Config</span></a>
    <ul class="treeview-menu">
        <li><a href="{{route('Config.portal')}}"><i class="fa fa-telegram"></i><span>General</span></a>
        <li><a href="{{route('Config.portal.workFlow')}}"><i class="fa fa-telegram"></i><span>Work Flow </span></a>
        <li><a href="{{route('portal.billingCycle')}}"><i class="fa fa-money"></i><span>Billing Cycle Config</span></a></li>
    </ul>
<li><a href="{{route('master.vendorReg')}}"><i class="fa fa-industry"></i><span>Vendor Registration</span></a></li>
{{--<li><a href="{{route('portal.bankAccount')}}"><i class="fa fa-bank"></i><span>Bank</span></a></li>--}}

@foreach($menus as $menu)
    @foreach($menu_per as $per)
        @if($per->menu_id == $menu->id)
            @if($menu->parent_id == 0 )
                <li class="treeview "><a href="#"><i class="{{$menu->icon}}"></i><span>{{$menu->menu_name}}</span><i
                                class="fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">

                        @if($menu->menu_name == "PMO")
                            <li><a href="{{route('projects.index')}}"><i class="fa fa-list"></i> Projects</a></li>
                        @endif
                        @foreach($menus as $child)
                            @foreach($menu_per as $per_child)
                                @if($per_child->menu_id == $child->id)
                                    @if($menu->id == $child->parent_id)
                                        @if($child->route_link == '#')
                                            <li class="treeview ">
                                                <a href="#"><i
                                                            class="{{$child->icon}}"></i><span>{{$child->menu_name}}</span><i
                                                            class="fa fa-angle-right"></i></a>
                                        @else
                                            <li>
                                                <a href="{{route($child->route_link)}}"><i class="{{$child->icon}}"></i><span>{{$child->menu_name}}</span></a>
                                            </li>
                                        @endif


                                        <ul class="treeview-menu">

                                            @if($child->menu_name == "Preparation")
                                                @foreach(Auth::user()->getPortal->getPortalServices as $value)
                                                    <li><a href="{{route('prepration',$value->getServices->id)}}"><i
                                                                    class="fa fa-dot-circle-o"></i> {{$value->getServices->service_name}}
                                                        </a></li>
                                                @endforeach
                                            @endif

                                            @foreach($menus as $sub_child)
                                                @foreach($menu_per as $per_sub)
                                                    @if($per_sub->menu_id == $sub_child->id)
                                                        @if($child->id == $sub_child->parent_id )
                                                            <li><a href="{{route($sub_child->route_link)}}"><i
                                                                            class="{{$sub_child->icon}}"></i> {{$sub_child->menu_name}}
                                                                </a></li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </ul> </li>

                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </li>
                @endif
                @endif
                @endforeach
                @endforeach


                </ul></li>

                {{--<li><a href="{{route('portal.employee.timeSheet')}}"><i class="fa fa-dashboard"></i><span>Employee Time Sheet</span></a></li>--}}


                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script type="text/javascript">

                    //$("span:contains('Projects List')").parent().remove();

                </script>
