<div id="sidebar" class="active">
    <div class="sidebar-wrapper active ">
<div class="sidebar-header position-relative">
<div class="d-flex justify-content-between align-items-center">
    <div class="logo">
        <a href="/">Logo</a>
    </div>
    <div class="sidebar-toggler  x">
        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
    </div>
</div>
</div>
<div class="sidebar-menu">
<ul class="menu">
    <li class="sidebar-title">Menu</li>
    
    <li
        class="sidebar-item">
        <a href="/" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <li
        class="sidebar-item ">
        <a href="{{ route('calonpelanggan.index') }}" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Calon Pelanggan</span>
        </a>
    </li>

    
    <li class="sidebar-title">Extra UI</li>
    <li
        class="sidebar-item ">
        <a href="{{ route('map.index') }}" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Map</span>
        </a>
    </li>

    
    
     
        @auth
        <form   action="{{route('logout')}}" method="post"> 
            @csrf
            <button class="btn btn-lg btn-outline-danger">Logout</button></form>
        @endauth
    
    
</ul>
</div>
</div>
</div>