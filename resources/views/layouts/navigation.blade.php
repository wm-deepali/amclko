<style>
    .sidebar-nav::-webkit-scrollbar {
        display: none;
    }
</style>

<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>


    {{-- ================= LOGO ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('logos.*') ? 'active' : '' }}" href="{{ route('logos.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-image') }}"></use>
            </svg>
            Logo Management
        </a>
    </li>


    {{-- ================= SLIDER ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('sliders.*') ? 'active' : '' }}" href="{{ route('sliders.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-image') }}"></use>
            </svg>
            Slider Management
        </a>
    </li>


    {{-- ================= BACKGROUND PAGE ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('backgrounds.*') ? 'active' : '' }}"
            href="{{ route('backgrounds.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-wallpaper') }}"></use>
            </svg>
            Background Management
        </a>
    </li>

    {{-- ================= COURSES PAGE ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-courses.*') ? 'active' : '' }}" href="{{ route('manage-courses.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-library') }}"></use>
            </svg>
            Courses Management
        </a>
    </li>


    {{-- ================= PICTURE GALLERY ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('galleries.*') ? 'active' : '' }}"
            href="{{ route('galleries.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-camera') }}"></use>
            </svg>
            Picture Management
        </a>
    </li>

    {{-- ================= VIDEO GALLERY ================= --}}
    <li class="nav-group">
        <a class="nav-link {{ request()->routeIs('videos.*') ? 'active' : '' }}" href="{{ route('videos.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-video') }}"></use>
            </svg>
            Video Management
        </a>
    </li>

    {{-- ================= AFFILIATION ================= --}}
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-badge') }}"></use>
            </svg>
            Affiliation Management
        </a>
        <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('recognizations.index') }}">Govt. Recognition</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('skill-dev.index') }}">Skill Development</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-urdu-academy.index') }}">Urdu Academy</a></li>
        </ul>
    </li>

    {{-- ================= ABOUT US ================= --}}
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
            </svg>
            About Us Management
        </a>
        <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('abouts.index') }}">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('chairmen.index') }}">Chairman Message</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('secretaries.index') }}">Secretary Message</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('missions.index') }}">Vision & Mission</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('certificates.index') }}">View Certificate</a></li>
        </ul>
    </li>

    {{-- ================= ADMISSION & COURSES ================= --}}
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
            </svg>
            Admission Management
        </a>
        <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('applications.index') }}">Application Form</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="#">Our Courses</a></li> -->
        </ul>
    </li>

    {{-- ================= CONTACT US ================= --}}
    <li class="nav-group">
        <a class="nav-link {{ request()->routeIs('contacts.*') ? 'active' : '' }}" href="{{ route('contacts.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-phone') }}"></use>
            </svg>
            Contact Us Management
        </a>
    </li>

    {{-- ================= WEB SETTINGS ================= --}}
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-settings') }}"></use>
            </svg>
            Web Settings
        </a>
        <ul class="nav-group-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.password.edit') }}">Change Password</a></li>
        </ul>
    </li>

</ul>