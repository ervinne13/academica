<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li>
                <a href="/">
                    <span><i class="fa fa-dashboard text-red"></i> 
                        Dashboard
                    </span>
                </a>
            </li>                                 
            <li>
                <a href="/teachers">
                    <span><i class="fa fa-users text-blue"></i> 
                        Teachers
                    </span>
                </a>
            </li>
            <li>
                <a href="/students">
                    <span><i class="fa fa-graduation-cap text-info"></i> 
                        Students
                    </span>
                </a>
            </li>
            <li>
                <a href="/subjects">
                    <span><i class="fa fa-book text-purple"></i> 
                        Subjects
                    </span>
                </a>
            </li> 
            <li>
                <a href="/classes">
                    <span><i class="fa fa-clock-o text-blue"></i> 
                        Classes
                    </span>
                </a>
            </li>
            <li>
                <a href="/sections">
                    <span><i class="fa fa-cubes text-info"></i> 
                        Sections
                    </span>
                </a>
            </li>
            <li>
                <a href="/enroll-by-student">
                    <span><i class="fa fa-plus text-fuchsia"></i> 
                        Enroll Student(s)
                    </span>
                </a>
            </li>
            <!--            <li>
                            <a href="/enrollment">
                                <span><i class="fa fa-plus text-fuchsia"></i> 
                                    Enroll Student to Class
                                </span>
                            </a>
                        </li>-->
            <li>
                <a href="/class-records">
                    <span><i class="fa fa-users text-info"></i> 
                        Class Records
                    </span>
                </a>
            </li>
            <!--            <li class="header"></li>
                        <li>
                            <a href="/change-admin-view/advanced">
                                <span>
                                    Advanced View
                                </span>
                            </a>
                        </li>-->
            <li>
                <a href="/grading-years">
                    <span><i class="fa fa-calendar text-blue"></i> 
                        Grading Years
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
                <a href="/graded-items">
                    <span><i class="fa fa-book text-red"></i> 
                        Graded Items
                    </span>
                </a>
            </li>

            @foreach($gradedItemTypes AS $gradedItemType)
            <li>
                <a href="/graded-items/type/{{$gradedItemType->id}}">
                    <span><i class="fa fa-book text-red"></i> 
                        {{$gradedItemType->name}}
                    </span>
                </a>
            </li>
            @endforeach

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>