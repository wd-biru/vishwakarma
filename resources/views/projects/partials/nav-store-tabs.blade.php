<br>
<ul class="nav nav-tabs">

    <li class="{{ Request::segment(3) == 'storeInventory' ? 'active' : '' }}">
        {!! link_to_route('storeInventory', 'Store Intial Stock',[$project->id,base64_encode($store)]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'storeInword' ? 'active' : '' }}">
        {!! link_to_route('storeInword', 'Store Inward', [$project->id,base64_encode($store)]) !!}
    </li>

     <li class="{{ Request::segment(3) == 'getstoreitemlistinvalter' ? 'active' : '' }}">
        {!! link_to_route('getstoreitemlistinvalter', 'View & Alter Inward', [$project->id,base64_encode($store)]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'storeoutward' ? 'active' : '' }}">
        {!! link_to_route('storeoutward', 'Store outward', [$project->id,base64_encode($store)]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'viewandalteroutward' ? 'active' : '' }}">
        {!! link_to_route('viewandalteroutward', 'View and Alter outward', [$project->id,base64_encode($store)]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'storetostore' ? 'active' : '' }}">
        {!! link_to_route('storetostore', 'Store To Store Transfer', [$project->id,base64_encode($store)]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'viewamdalterstoretransfer' ? 'active' : '' }}">
        {!! link_to_route('viewamdalterstoretransfer', 'View And Alter Store Transfer', [$project->id,base64_encode($store)]) !!}
    </li>

    <li class="{{ Request::segment(3) == 'currentItemStock' ? 'active' : '' }}">
        {!! link_to_route('currentItemStock', 'Current Store Stock', [$project->id,base64_encode($store)]) !!}
    </li>


</ul>
<br>