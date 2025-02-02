<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only"> Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="/" class="logo"> AM - BANK <span> SMK AMALIAH CIAWI 1 & 2 </span></a></h1>
        <ul class="list-unstyled components mb-5">
            <!-- Dashboard without dropdown -->
            <li class="active">
                <a href="{{ url('dashboard') }}"><span class="fa fa-home mr-3"></span> Dashboard </a>
            </li>
            
            <!-- Tabungan Nasabah Dropdown -->
            <li>
                <a href="#tabunganSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span class="fa fa-user mr-3"></span> Tabungan Nasabah
                </a>
                <ul class="collapse list-unstyled" id="tabunganSubmenu">
                    <li><a href="{{ url('setoran') }}"> Setoran Masuk </a></li>
                    <li><a href="{{ url('penarikan') }}"> Penarikan Tabungan </a></li>
                </ul>
            </li>
            
            <!-- Nasabah Dropdown -->
            <li>
                <a href="#nasabahSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <span class="fa fa-suitcase mr-3"></span> Nasabah
                </a>
                <ul class="collapse list-unstyled" id="nasabahSubmenu">
                    <li><a href="{{ url('nasabah') }}"> Data Nasabah </a></li>
                    <li><a href="{{ url('saldo') }}"> Cek Saldo Nasabah </a></li>
                </ul>
            </li>
            
            <!-- Another Menu Example with Single Link -->
            <li>
                <a href="{{ url('data-lain') }}"><span class="fa fa-cogs mr-3"></span> Data Lain </a>
            </li>

            <!-- Logout Button -->
            <li>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="fa fa-sign-out mr-3"></span> Logout
                </a>
            </li>
        </ul>
        
        <div class="footer">
            <p>&copy; <script>document.write(new Date().getFullYear());</script>| Made  <i class="icon-heart" aria-hidden="true"></i> by TeamDev</a></p>
        </div>
    </div>
</nav>

<!-- Form untuk Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    $(document).ready(function() {
    // Sidebar and Dropdown State Management
    const $sidebar = $('#sidebar');
    const $sidebarCollapseBtn = $('#sidebarCollapse');

    // Retrieve sidebar states
    const isSidebarCollapsed = sessionStorage.getItem('sidebarCollapsed') === 'true';
    const activeDropdowns = JSON.parse(sessionStorage.getItem('activeDropdowns') || '[]');

    // Apply saved sidebar state on page load
    if (isSidebarCollapsed) {
        $sidebar.addClass('active');
        $sidebarCollapseBtn.addClass('active');
    }

    // Restore active dropdowns
    activeDropdowns.forEach(dropdownId => {
        $(`#${dropdownId}`).addClass('show');
        $(`a[href="#${dropdownId}"]`).attr('aria-expanded', 'true');
    });

    // Toggle sidebar and save state
    $sidebarCollapseBtn.on('click', function() {
        $sidebar.toggleClass('active');
        $(this).toggleClass('active');
        sessionStorage.setItem('sidebarCollapsed', $sidebar.hasClass('active'));
    });

    // Manage dropdown states
    $('.dropdown-toggle').on('click', function() {
        const $submenu = $($(this).attr('href'));
        const dropdownId = $submenu.attr('id');
        const isOpen = $submenu.hasClass('show');
        
        // Get current open dropdowns
        let activeDropdowns = JSON.parse(sessionStorage.getItem('activeDropdowns') || '[]');
        
        if (isOpen) {
            // Remove from active dropdowns
            activeDropdowns = activeDropdowns.filter(id => id !== dropdownId);
        } else {
            // Add to active dropdowns if not already present
            if (!activeDropdowns.includes(dropdownId)) {
                activeDropdowns.push(dropdownId);
            }
        }
        
        // Save updated active dropdowns
        sessionStorage.setItem('activeDropdowns', JSON.stringify(activeDropdowns));
    });
});
</script>