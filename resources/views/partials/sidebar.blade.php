<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('welcome') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer')}}"></use>
                </svg>
                {{ __('Dashboard') }}
            </a>
        </li>
        @if (auth()->user()->is_admin)
            <li class="c-sidebar-nav-title">{{ __('Manage Checklists') }}</li>
            @foreach($admin_menu as $group)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open')}}"></use>
                        </svg>
                        {{ $group->name }}
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @foreach($group->checklists as $checklist)
                            <li class="c-sidebar-nav-item">
                                <a class="c-sidebar-nav-link" style="padding: .5rem .5rem .5rem 86px"
                                   href="{{ route('admin.checklist-groups.checklists.edit', [$group, $checklist]) }}">
                                    <svg class="c-sidebar-nav-icon">
                                        <use
                                            xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                                    </svg>
                                    {{ $checklist->name }}
                                </a>
                            </li>
                        @endforeach
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" style="padding: 1rem .5rem .5rem 86px"
                               href="{{ route('admin.checklist-groups.checklists.create', $group) }}">
                                <svg class="c-sidebar-nav-icon">
                                    <use
                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-note-add') }}"></use>
                                </svg>
                                {{ __('New checklist') }}
                            </a>
                        </li>
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" href="{{ route('admin.checklist-groups.edit', $group->id) }}">
                                <svg class="c-sidebar-nav-icon">
                                    <use
                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-pencil') }}"></use>
                                </svg>
                                {{ __('Edit checklist group') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endforeach
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.checklist-groups.create') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-library-add') }}"></use>
                    </svg>
                    {{ __('New checklist group') }}
                </a>
            </li>
            <li class="c-sidebar-nav-title">{{ __('Pages') }}</li>
            @foreach(\App\Models\Page::all() as $page)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.pages.edit', $page) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle')}}"></use>
                        </svg>
                        {{ $page->title }}
                    </a>
                </li>
            @endforeach
            <li class="c-sidebar-nav-title">{{ __('Manage Data') }}</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                    </svg>
                    {{ __('Users') }}
                </a>
            </li>
        @else
            @foreach($user_tasks_menu as $key => $user_task_menu)
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="{{ route('user.tasklist', $key) }}" >
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-'. $user_task_menu['icon']) }}"></use>
                        </svg>
                        {{ $user_task_menu['name'] }}
                        @livewire('user-tasks-counter', [
                            'task_type' => $key,
                            'tasks_count' => $user_task_menu['tasks_count'],
                        ])
                    </a>
                </li>
            @endforeach

            @foreach($user_menu as $group)
                <li class="c-sidebar-nav-title">
                    {{ $group['name'] }}
                    @if ($group['is_new'])
                        <span class="badge badge-info">NEW</span>
                    @elseif ($group['is_updated'])
                        <span class="badge badge-warning">UPD</span>
                    @endif
                </li>
                @foreach($group['checklists'] as $checklist)
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link"
                           href="{{ route('users.checklists.show', [$checklist['id']]) }}">
                            <svg class="c-sidebar-nav-icon">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                            </svg>
                            {{ $checklist['name'] }}
                            @livewire('completed-tasks-counter', [
                            'completed_tasks' => count($checklist['user_completed_tasks']),
                            'tasks_count' => count($checklist['tasks']),
                            'checklist_id' => $checklist['id'],
                            ])
                            @if ($checklist['is_new'])
                                <span class="badge badge-info">NEW</span>
                            @elseif ($checklist['is_updated'])
                                <span class="badge badge-warning">UPD</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            @endforeach
        @endif
        {{--        <li class="c-sidebar-nav-title">{{ __('Other') }}</li>--}}
        {{--        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('logout') }}"--}}
        {{--                                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
        {{--                <svg class="c-sidebar-nav-icon">--}}
        {{--                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>--}}
        {{--                </svg> {{ __('Logout') }}</a>--}}
        {{--            <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">--}}
        {{--                @csrf--}}
        {{--            </form>--}}
        {{--        </li>--}}
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
