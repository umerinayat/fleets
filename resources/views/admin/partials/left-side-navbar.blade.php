<!-- logo -->
<div class="row">
    <div class="col-md-12 text-center">
        <h3>Logo</h3>
    </div>
</div>
<!-- /logo -->

<!-- avator profile img -->
<div class="row mt-2">
    <div class="col-md-12 text-center">
        <img src="https://via.placeholder.com/70x70" alt="profile-img" class="rounded-circle">
    </div>
</div>
<!-- avator profile img -->

<!-- search -->
<div class="row mt-2">
    <div class="col-md-12">
        <input type="search" class="form-control form-control-sm" name="search-query" placeholder="Search" />
    </div>
</div>
<!-- search -->

<!-- nav links -->
<div class="row mt-2">
    <div class="col-md-12">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ Route('dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ Route('globalUpdateIndex') }}">Updates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Users</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
            </li>

              
            <li class="nav-item">
                <a class="nav-link" href="{{ route('brands.index') }}">Brands</a>
            </li>

            @can('super-admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tags.index') }}">Tags</a>
                </li>
            @endcan

            <li class="nav-item"> 
                <a class="nav-link" href="#"><b>Assests</b></a>
                <ul class="nav ml-4 flex-column">
                    
                    <li class="nav-item">
                        <a href="#email-addresses" class="nav-link">Email Sequence</a>
                    </li>

                </ul>
            </li>


            
            <li class="nav-item">
                <a class="nav-link" href="#">Billing</a>
            </li>

            <ul class="nav flex-column">
               
                <li class="nav-item">
                    <a class="nav-link" href="#"><b>System Settings</b></a>
                    <ul class="nav ml-4 flex-column">
                        <a href="{{ route('emailAccounts.index') }}" class="nav-link">Email Accounts</a>
                    </ul>
                    
                </li>

            </ul>

        </ul>
    </div>
</div>
<!-- nav links -->