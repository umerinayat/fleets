<!-- Heading -->
<div class="sidebar-heading">
    Admin App
</div>

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFleets" aria-expanded="true"
        aria-controls="collapseFleets">
        <i class="fas fa-fw fa-users"></i>
        <span>Fleets</span>
    </a>
    <div id="collapseFleets" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Fleets:</h6>
            <a class="collapse-item" href="{{ route('fleets.index') }}">All Fleets</a>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRefuellings" aria-expanded="true"
        aria-controls="collapseRefuellings">
        <i class="fas fa-fw fa-users"></i>
        <span>Refuellings</span>
    </a>
    <div id="collapseRefuellings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Refuellings:</h6>
            <a class="collapse-item" href="{{ route('refuelling.index') }}">All Refuellings</a>
        </div>
    </div>
</li>



<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true"
        aria-controls="collapseUsers">
        <i class="fas fa-fw fa-users"></i>
        <span>Users</span>
    </a>
    <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Users:</h6>
            <a class="collapse-item" href="{{ route('users.index') }}">All Users</a>
        </div>
    </div>
</li>
