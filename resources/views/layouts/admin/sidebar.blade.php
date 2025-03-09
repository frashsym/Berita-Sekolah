   <!-- Page Wrapper -->
   <div id="wrapper">

       <!-- Sidebar -->
       <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

           <!-- Sidebar - Brand -->
           <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
               <div class="sidebar-brand-icon">
                   <img src="{{ url('/images/Neper.png') }}" alt="" style="height: 50px; widht: 50px;">
               </div>
               <div class="sidebar-brand-text mx-3">NeperTimes</div>
           </a>

           <!-- Divider -->
           <hr class="sidebar-divider my-0">

           <!-- Nav Item - Dashboard -->
           <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
               <a class="nav-link" href="{{ url('/dashboard') }}">
                   <i class="fas fa-fw fa-tachometer-alt"></i>
                   <span>Dashboard</span></a>
           </li>

           <!-- Divider -->
           <hr class="sidebar-divider">

           <!-- Heading -->
           <div class="sidebar-heading">
               Menu
           </div>

           <!-- Nav Item - Berita -->
           <li class="nav-item {{ request()->is('berita') ? 'active' : '' }}">
               <a class="nav-link" href="{{ url('/berita') }}">
                   <i class="fas fa-fw fa-newspaper"></i>
                   <span class="ml-1">Berita</span></a>
           </li>

           <!-- Nav Item - Kategori -->
           <li class="nav-item {{ request()->is('kategori') ? 'active' : '' }}">
               <a class="nav-link" href="{{ url('/kategori') }}">
                   <i class="fas fa-fw fa-list"></i>
                   <span class="ml-1">Kategori</span></a>
           </li>

           <!-- Nav Item - Comment -->
           <li class="nav-item {{ request()->is('comments') ? 'active' : '' }}">
               <a class="nav-link" href="{{ url('/comments') }}">
                   <i class="fas fa-fw fa-comments"></i>
                   <span class="ml-1">Komentar</span></a>
           </li>

           <!-- Nav Item - Admin (Cek apakah user yang login adalah Super Admin) -->
           @if (auth()->user() && auth()->user()->isSuperAdmin())
               <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ url('/admin') }}">
                       <i class="fas fa-user-shield"></i>
                       <span class="ml-1">Admin</span>
                   </a>
               </li>

               <li class="nav-item {{ request()->is('role') ? 'active' : '' }}">
                   <a class="nav-link" href="{{ url('/role') }}">
                       <i class="fas fa-user-cog"></i>
                       <span class="ml-1">Role</span>
                   </a>
               </li>
           @endif

           <!-- Divider -->
           <hr class="sidebar-divider d-none d-md-block">

           <!-- Sidebar Toggler (Sidebar) -->
           <div class="text-center d-none d-md-inline">
               <button class="rounded-circle border-0" id="sidebarToggle"></button>
           </div>

       </ul>
       <!-- End of Sidebar -->
