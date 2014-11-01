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
            <li>
                <a href="/class-records/teacher/{{Auth()->user()->id}}">
                    <span><i class="fa fa-users text-info"></i> 
                        Class Records
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