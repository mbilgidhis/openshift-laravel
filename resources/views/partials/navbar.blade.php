<nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="/"><span class="fal fa-clock"></span> Timesheet</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @auth

            @can('view_master_data')
            <li class="nav-item dropdown" role="setting">
                <a href="#" id="btnSettingOrganization" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Setting</a>
                <div class="dropdown-menu" aria-labelledby="btnSettingOrganization">
                    <a href="{{ route('setting.index') }}" class="dropdown-item">Config</a>
                    <a href="{{ route('setting.holiday.index') }}" class="dropdown-item">Holiday</a>
                </div>
            </li>
            @endcan

            @can('user_management')
            <li class="nav-item dropdown" role="permission">
                <a href="#" id="btnPermissionOrganization" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">User Management</a>
                <div class="dropdown-menu" aria-labelledby="btnPermissionOrganization">
                    <a href="{{ route('user-management.index') }}" class="dropdown-item">User Management</a>
                    <a href="{{ route('role-management.index') }}" class="dropdown-item">Role Management</a>
                    <a href="{{ route('permission-management.index') }}" class="dropdown-item">Permission Management</a>
                </div>
            </li>
            @endcan

            {{-- Department --}}
            @can('view_department')
            <li class="nav-item dropdown" role="group">
                <a href="#" id="btnGroupOrganization" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Organization</a>
                <div class="dropdown-menu" aria-labelledby="btnGroupOrganization">
                    <a href="{{ route('department.index') }}" class="dropdown-item">Department</a>
                    <a href="{{ route('team.index') }}" class="dropdown-item">Team</a>
                </div>
            </li>
            @endcan
            {{-- Project --}}
            @can('view_project')
            <li class="nav-item dropdown" role="group">
                <a href="#" id="btnGrupProject" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Project</a>
                <div class="dropdown-menu" aria-labelledby="btnGrupProject">
                    <a href="{{ route('project.index') }}" class="dropdown-item">List Project</a>
                    @can('create_project')
                    <a href="{{ route('project.create') }}" class="dropdown-item">Create Project</a>
                    @endcan
                </div>
            </li>
            @endcan
            {{-- Category --}}
            @can('view_master_data')
            <li class="nav-item dropdown" role="group">
                <a href="#" id="btnGroupCategory" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category</a>
                <div class="dropdown-menu" aria-labelledby="btnGroupCategory">
                    <a href="{!! route('plan-category.index') !!}" class="dropdown-item">Plan</a>
                    <a href="{!! route('actual-category.index') !!}" class="dropdown-item">Actual</a>
                </div>
            </li>
            @endcan

            @can('view_plan')
            <li class="nav-item dropdown" role="group">
                <a href="#" id="btnGroupPlan" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Plan</a>
                <div class="dropdown-menu" aria-labelledby="btnGroupPlan">
                    <a href="{{ route('plan.index') }}" class="dropdown-item">List Plan</a>
                    @can('create_plan')
                    <a href="{{ route('plan.create') }}" class="dropdown-item">Create Plan</a>
                    @endcan
                </div>
            </li>
            @endcan

            @can('view_claim_overtime')
            <li class="nav-item dropdown" role="group">
                <a href="#" id="btnOvertimeGroup" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Overtime</a>
                <div class="dropdown-menu" aria-labelledby="btnOvertimeGroup">
                    <a href="{{ route('overtime.index') }}" class="dropdown-item">Overtime Claim</a>
                    @can('create_plan')
                    <a href="{{ route('overtime.unclaimed.index') }}" class="dropdown-item">Unclaimed Overtime</a>
                    @endcan
                </div>
            </li>
            @endcan

            @endauth
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img class="rounded-circle text-center" height="25" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="Card image cap"> 
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('profile') }}" class="dropdown-item">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>