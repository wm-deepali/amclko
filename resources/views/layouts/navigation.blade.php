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
        <a class="nav-link {{ request()->routeIs('manage-logos.*') ? 'active' : '' }}"
            href="{{ route('manage-logos.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-image') }}"></use>
            </svg>
            Logo Management
        </a>
    </li>


    {{-- ================= SLIDER ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-sliders.*') ? 'active' : '' }}"
            href="{{ route('manage-sliders.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-layers') }}"></use>
            </svg>
            Slider Management
        </a>
    </li>


    {{-- ================= BACKGROUND PAGE ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-backgrounds.*') ? 'active' : '' }}"
            href="{{ route('manage-backgrounds.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-wallpaper') }}"></use>
            </svg>
            Background Management
        </a>
    </li>

    {{-- ================= COURSES PAGE ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-courses.*') ? 'active' : '' }}"
            href="{{ route('manage-courses.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-library') }}"></use>
            </svg>
            Courses Management
        </a>
    </li>


    {{-- ================= PROGRAMS ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-programs.*') ? 'active' : '' }}"
            href="{{ route('manage-programs.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
            </svg>
            Programs Management
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-blogs.*') ? 'active' : '' }}"
            href="{{ route('manage-blogs.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            Blog Management
        </a>
    </li>

  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manage-faqs.*') ? 'active' : '' }}"
        href="{{ route('manage-faqs.index') }}">
        <svg class="nav-icon">
            <use xlink:href="{{ asset('icons/coreui.svg#cil-info') }}"></use>
        </svg>
        FAQ Management
    </a>
</li>



    {{-- ================= ANNUAL REPORT ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-annual-reports.*') ? 'active' : '' }}"
            href="{{ route('manage-annual-reports.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-file') }}"></use>
            </svg>
            Annual Report
        </a>
    </li>

    {{-- ================= PICTURE GALLERY ================= --}}
    {{-- ================= PICTURE GALLERY ================= --}}
    <li class="nav-group {{ request()->routeIs('manage-gallery-categories.*', 'manage-galleries.*') ? 'show' : '' }}">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-camera') }}"></use>
            </svg>
            Picture Management
        </a>

        <ul class="nav-group-items">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manage-gallery-categories.*') ? 'active' : '' }}"
                    href="{{ route('manage-gallery-categories.index') }}">
                    Categories
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manage-galleries.*') ? 'active' : '' }}"
                    href="{{ route('manage-galleries.index') }}">
                    Pictures
                </a>
            </li>
        </ul>
    </li>


    {{-- ================= VIDEO GALLERY ================= --}}
    <li class="nav-group">
        <a class="nav-link {{ request()->routeIs('manage-videos.*') ? 'active' : '' }}"
            href="{{ route('manage-videos.index') }}">
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
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-recognizations.index') }}">Govt.
                    Recognition</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-skill-dev.index') }}">Skill Development</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-urdu-academy.index') }}">Urdu Academy</a>
            </li>
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
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-abouts.index') }}">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-chairmen.index') }}">Chairman Message</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-secretaries.index') }}">Secretary
                    Message</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-missions.index') }}">Vision & Mission</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('manage-certificates.index') }}">View
                    Certificate</a></li>
        </ul>
    </li>

    {{-- ================= ADMISSION & COURSES ================= --}}
    <li class="nav-group">
        <a class="nav-link {{ request()->routeIs('manage-applications.*') ? 'active' : '' }}"
            href="{{  route('manage-applications.index')}}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-school') }}"></use>
            </svg>
            Admission Form
        </a>
    </li>

    {{-- ================= CAREER ================= --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('manage-careers.*') ? 'active' : '' }}"
            href="{{ route('manage-careers.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-briefcase') }}"></use>
            </svg>
            Career Applications
        </a>
    </li>


    {{-- ================= CONTACT US ================= --}}
    <li class="nav-group">
        <a class="nav-link {{ request()->routeIs('manage-contacts.*') ? 'active' : '' }}"
            href="{{ route('manage-contacts.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-phone') }}"></use>
            </svg>
            Contact Us Management
        </a>
    </li>

    {{-- ================= ENQUIRIES ================= --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('manage-enquiries.*') ? 'active' : '' }}"
        href="{{ route('manage-enquiries.index') }}">
        <svg class="nav-icon">
            <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
        </svg>
        Enquiry Management
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