<li><a href="{{route('employee.dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
<li><a href="{{route('employee.profile')}}"><i class="fa fa-user"></i><span>My Profile</span></a></li> 



<?php
$menus=DB::table('vishwa_menu_master')->where('menu_config',2)->where('is_active',1)->get(); 
$menu_per = DB::table('vishwa_menu_permission')->where('user_id',Auth::user()->id)->where('is_active',1)->get(); 
$document=App\Models\Document::where('portal_id',Auth::user()->getEmp->portal_id)->where('employee_id',Auth::user()->getEmp->id)->get();
$documentshare=App\Models\DocumentShare::where('shareEmployee_id',Auth::user()->getEmp->id)->where('portal_id',Auth::user()->getEmp->portal_id)->get();
$documentApproval=App\Models\Document::where('for_approval',Auth::user()->getEmp->id)->where('portal_id',Auth::user()->getEmp->portal_id)->get();
 
?>
@foreach($menus as $menu)
    @foreach($menu_per as $per)
        @if($per->menu_id == $menu->id)
            @if($menu->parent_id == 0)
                <li class="treeview "><a href="#"><i class="{{$menu->icon}}"></i><span>{{$menu->menu_name}}</span><i class="fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        @if($menu->menu_name == "Project Management")                   
                            <li><a href="{{route('projects.index')}}"><i class="fa fa-list"></i> Projects</a></li>
                        @endif
                        @foreach($menus as $child)
                            @foreach($menu_per as $per_child)
                                @if($per_child->menu_id == $child->id)

                                    @if($menu->id == $child->parent_id)
                                        @if($child->route_link == '#')
 
                                            <li class="treeview">
                                                <a href="#"><i class="{{$child->icon}}"></i><span>{{$child->menu_name}}</span><i class="fa fa-angle-right"></i></a>                 
                                        
                                        @else
                                            <li>
                                                <a href="{{route($child->route_link)}}"><i class="{{$child->icon}}"></i><span>{{$child->menu_name}}</span></a>
                                            </li>
                                        @endif
                                        
                                      
                                        <ul class="treeview-menu">
                                            @if($child->menu_name == "Preparation")                   
                                                @foreach($portalServices as $value)                    
                                                    <li><a href="{{route('employee.prepration',$value->getServices->id)}}"><i class="fa fa-dot-circle-o"></i> {{$value->getServices->service_name}}</a></li>
                                                @endforeach
                                            @endif
                                            
                                            @foreach($menus as $sub_child)
                                                @foreach($menu_per as $per_sub)
                                                    @if($per_sub->menu_id == $sub_child->id)
                                                        @if($child->id == $sub_child->parent_id )
                                                            <li><a href="{{route($sub_child->route_link)}}"><i class="{{$sub_child->icon}}"></i> {{$sub_child->menu_name}}</a></li>
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
                    </ul>
                </li>
            @endif
       @endif
    @endforeach 
@endforeach

 

                
 
 
 

