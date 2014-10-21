<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li>
                <a href="/">
                    <span><i class="fa fa-dashboard text-red"></i> 
                        Home
                    </span>
                </a>
            </li>
            @foreach(Auth::user()->links AS $link)
            <li>
                <a href="{{$link->url}}">
                    <span><i class="fa fa-link text-blue"></i> 
                        {{$link->name}}
                    </span>
                </a>
            </li>            
            @endforeach
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>