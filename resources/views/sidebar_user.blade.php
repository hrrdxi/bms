<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="/" class="logo">MINI BANK <span>SMK AMALIAH CIAWI</span></a></h1>
        <ul class="list-unstyled components mb-5">
            <!-- Dashboard tanpa dropdown -->
            <li class="active">
                <a href="{{ url('user/dashboard') }}"><span class="fa fa-home mr-3"></span> Dashboard</a>
            </li>
            
            <!-- Lihat Transaksi tanpa bisa menginput -->
            <li>
                <a href="{{ url('user/transaksi') }}"><span class="fa fa-file-alt mr-3"></span> Pengajuan Penarikan</a>
                
            </li>
            
            <!-- Profil -->
            <li>
                <a href="{{ url('user/profil') }}"><span class="fa fa-user mr-3"></span> Profil</a>
            </li>
        </ul>

        <div class="footer">
            <p>&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a></p>
        </div>
    </div>
</nav>
