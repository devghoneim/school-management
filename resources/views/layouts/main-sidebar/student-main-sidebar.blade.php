<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{trans('main_trans.Dashboard')}}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>



        <!-- الامتحانات-->
        <li>
            <a href="{{route('settings.index')}}"><i class="fas fa-book-open"></i><span
                    class="right-nav-text">الامتحانات</span></a>
        </li>


        <!-- Settings-->
        <li>
            <a href="{{route('settings.index')}}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">الملف الشخصي</span></a>
        </li>

    </ul>
</div>