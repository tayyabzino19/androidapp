<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">


            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('categories') }}" class="menu-link">
                    <i class="menu-icon flaticon2-notepad"></i>
                    <span class="menu-text">Categories</span>
                </a>
            </li>



            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('videos.index') }}" class="menu-link">
                    <i class="menu-icon flaticon-technology-2"></i>
                    <span class="menu-text">Videos</span>
                </a>
            </li>



            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('profile') }}" class="menu-link">
                    <i class="menu-icon flaticon2-gear"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </li>



            <li class="menu-item" aria-haspopup="true">
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                class="menu-link">
                    <i class="menu-icon flaticon-lock"></i>
                    <span class="menu-text">Log Out</span>

                </a>
            </li>

        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
</div>
<!--end::Aside-->
