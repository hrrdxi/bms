<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="/" class="logo">MINI BANK <span>SMK AMALIAH CIAWI 1 & 2</span></a></h1>
        <ul class="list-unstyled components mb-5">
            <!-- Dashboard without dropdown -->
            <li class="active">
                <a href="{{ url('/dashboard') }}"><span class="fa fa-home mr-3"></span> Dashboard</a>
            </li>
            
            <!-- Tabungan Nasabah Dropdown -->
            <li>
                <a href="#tabunganSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span class="fa fa-user mr-3"></span> Tabungan Nasabah
                </a>
                <ul class="collapse list-unstyled" id="tabunganSubmenu">
                    <li><a href="{{ url('setoran') }}">Setoran Masuk</a></li>
                    <li><a href="{{ url('penarikan') }}">Penarikan Tabungan</a></li>
                </ul>
            </li>
            
            <!-- Nasabah Dropdown -->
            <li>
                <a href="#nasabahSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span class="fa fa-suitcase mr-3"></span> Nasabah
                </a>
                <ul class="collapse list-unstyled" id="nasabahSubmenu">
                    <li><a href="{{ url('nasabah') }}">Data Nasabah</a></li>
                    <li><a href="{{ url('saldo') }}">Cek Saldo Nasabah</a></li>
                </ul>
            </li>
            
            <!-- Another Menu Example with Single Link -->
            <li>
                <a href="{{ url('data-lain') }}"><span class="fa fa-cogs mr-3"></span> Data Lain</a>
            </li>
        </ul>
        
        <div class="footer">
            <p>&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a></p>
        </div>
    </div>
</nav>
