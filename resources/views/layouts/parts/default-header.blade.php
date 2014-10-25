<header class="main-header">

    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">{!!Config::get('app.name')!!}</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">            
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">  
                        <i class="fa fa-user"></i>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">                          
                            <p>
                                {{ Auth::user()->name }}
                                <small>{!!Config::get('app.name')!!} {{ Auth::user()->role_name }}</small>
                                <small>
                                    <a href="/users/{{Auth::user()->id}}/change-password" style="color: white">
                                        Change Password
                                    </a>
                                </small>
                            </p>
                        </li>                      
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>