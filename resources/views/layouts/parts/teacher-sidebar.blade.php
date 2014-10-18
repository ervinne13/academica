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
            <li>
                <a href="/enrollment">
                    <span><i class="fa fa-plus text-blue"></i> 
                        Enroll Students
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
            <li class="header">Graded Items</li>
            <li>
                <a href="/graded-items/create">
                    <span><i class="fa fa-plus text-red"></i> 
                        Create Graded Item
                    </span>
                </a>
            </li>
            <li>
                <a href="/graded-items/type/Quizzes">
                    <span><i class="fa fa-book text-red"></i> 
                        Quizzes
                    </span>
                </a>
            </li>
            <li>
                <a href="/graded-items/type/Assignments">
                    <span><i class="fa fa-book text-maroon"></i> 
                        Assignments
                    </span>
                </a>
            </li>
            <li>
                <a href="/graded-items/type/Long Tests">
                    <span><i class="fa fa-book text-fuchsia"></i> 
                        Long Tests
                    </span>
                </a>
            </li>
            <li>
                <a href="/graded-items/type/Periodical Tests">
                    <span><i class="fa fa-book text-purple"></i> 
                        Periodical Tests
                    </span>
                </a>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>