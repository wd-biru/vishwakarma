<li ><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
</li>
<li class="treeview"><a href="#"><i class="fa fa-cog"></i><span>Admin Config</span></a>
<ul class="treeview-menu">
    <li><a href="{{route('admin.config')}}"><i class="fa fa-telegram"></i><span>General</span></a>
</ul>

<li class="treeview "><a href="#"><i class="fa fa-bars"></i><span>Portal Management</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{route('portal')}}"><i class="fa fa-list-alt" aria-hidden="true"></i>List</a></li>
        <li><a href="{{route('portalVendorMapping')}}"><i class="fa fa-map-signs" aria-hidden="true"></i>Vendor Mapping</a></li>

    </ul>
</li>
<li class="treeview "><a href="#"><i class="fa fa-cogs"></i><span> Masters</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">


        <li><a href="{{route('department.master')}}"><i class="fa fa-gavel"></i>Department</a></li>
        <li><a href="{{route('itemType.master')}}"><i class="fa fa-list"></i>Item Type</a></li>
        <li><a href="{{route('master.matMgmt')}}"><i class="fa fa-envelope"></i>Material Mangement</a></li>
        <li><a href="{{route('SrvcMgm.index')}}"><i class="fa fa-asterisk"></i>Services Management</a></li>
        <li><a href="{{route('bankMaster.index')}}"><i class="fa fa-bank"></i><span>Bank Master</span></a></li>
        <li><a href="{{route('masterBillingCycle.index')}}"><i class="fa fa-money"></i>Billing Cycle</a></li>


    </ul>
</li>

<li class="treeview "><a href="#"><i class="fa fa-building"></i><span> Building Works</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{route('activityGroup.index')}}"><i class="fa fa-user"></i>Activity Group</a></li>
        <li><a href="{{route('subActivity.index')}}"><i class="fa fa-user"></i>Sub Activity Work</a></li>
        <li><a href="{{route('microAcivity.index')}}"><i class="fa fa-group"></i>Micro Activity Work</a></li>
        <li><a href="{{route('manPower.index')}}"><i class="fa fa-users"></i>Man Power</a></li>
    </ul>
</li>


 
  <li><a href="{{route('master.vendorReg')}}"><i class="fa fa-industry"></i><span>Vendor Registration</span></a></li> 
 
 
  <li><a href="{{route('SrvcList.index')}}"><i class="fa fa-list-alt"></i><span>Services Registration</span></a></li> 