<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Management</li>
            <li>
                <a href="/">
                    <span><i class="fa fa-dashboard text-red"></i> 
                        Dashboard
                    </span>
                </a>
            </li>
            <li>
                <a href="/teacher/{{Auth()->user()->id}}/classes">
                    <span><i class="fa fa-graduation-cap text-fuchsia"></i> 
                        My Classes
                    </span>
                </a>
            </li>
            <!--            <li>
                            <a href="/enrollment">
                                <span><i class="fa fa-plus text-blue"></i> 
                                    Enroll Students                        
                                </span>
                            </a>
                        </li>-->
            <li>
                <a href="/class-records/teacher/{{Auth()->user()->id}}">
                    <span><i class="fa fa-users text-info"></i> 
                        Class Records
                    </span>
                </a>
            </li>
            <li>
                <a href="/students">
                    <span><i class="fa fa-users text-aqua"></i> 
                        Students
                    </span>
                </a>
            </li>            
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>