<!-- Sidebar menu-->
@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        @if(isset($user))
            @if($user->profile_pic == '')
                <img class="app-sidebar__user-avatar" width="70px" src="{{asset('admin/images/dummy_img.png')}}"
                     alt="user">
            @else
                <img class="app-sidebar__user-avatar" src="{{asset('storage/images/'.$user->profile_pic)}}"
                     alt="User Image"
                     width="70px">
            @endif
        @else
            <img class="app-sidebar__user-avatar" width="70px" src="{{asset('admin/images/dummy_img.png')}}"
                 alt="user">

        @endif
        <br>
        @if(isset($user))
            <p class="app-sidebar__user-name">{{$user->name}}</p>
        @else
            <p class="app-sidebar__user-name">Demo</p>
        @endif

    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item {{ Request::is('home*') ? 'active' : '' }}" href="{{route('home')}}"><i
                    class="app-menu__icon fa fa-dashboard"></i><span
                    class="app-menu__label">@lang('langs.dashboard')</span></a></li>
        @if(isset($user))
            @if($user->role == config('constants.ROLE.ADMIN'))
                <li><a class="app-menu__item {{ Request::is('user*') ? 'active' : '' }}" href="{{route('user.index')}}"><i
                            class="app-menu__icon fa fa-users"></i><span
                            class="app-menu__label">@lang('langs.users')</span></a>
            </li>
            <li><a class="app-menu__item {{ Request::is('categories*') ? 'active' : '' }}"
                   href="{{route('categories.index')}}"><i class="fa fa-list-alt"
                                                           aria-hidden="true"></i>&nbsp;&nbsp;<span
                        class="app-menu__label">@lang('langs.categories')</span></a></li>
            @endif
        @endif
        <li><a class="app-menu__item {{ Request::is('account*') ? 'active' : '' }}" href="{{route('account.index')}}"><i
                    class="fa fa-bank"></i>&nbsp;&nbsp;<span class="app-menu__label">@lang('langs.account')</span></a>
        </li>
        <li><a class="app-menu__item {{ Request::is('incomes*') ? 'active' : '' }}" href="{{route('incomes.index')}}"><i
                    class="fa fa-rupee" aria-hidden="true"></i>&nbsp;&nbsp;<span
                    class="app-menu__label">@lang('langs.incomes')</span></a></li>
        <li><a class="app-menu__item {{ Request::is('expenses*') ? 'active' : '' }}" href="{{route('expenses.index')}}"><i
                    class="fa fa-rupee"></i>&nbsp;&nbsp;<span class="app-menu__label">@lang('langs.expenses')</span></a>
        </li>
        <li><a class="app-menu__item {{ Request::is('transfer*') ? 'active' : '' }}" href="{{route('transfer.index')}}"><i
                    class="fa fa-exchange"></i>&nbsp;&nbsp;<span class="app-menu__label">@lang('langs.transfer')</span></a>
        </li>
        <li><a class="app-menu__item {{ Request::is('report*') ? 'active' : '' }}" href="{{route('report.index')}}"><i
                    class="fa fa-bar-chart"></i>&nbsp;&nbsp;<span
                    class="app-menu__label">@lang('langs.report')</span></a></li>
{{--        <li><a class="app-menu__item {{ Request::is('backup-download*') ? 'active' : '' }}" href="{{route('backup-download')}}">--}}
{{--                <i class="fa fa-hdd-o"></i>&nbsp;&nbsp;<span--}}
{{--                    class="app-menu__label">Backup Download</span></a></li>--}}
{{--        <li><a class="app-menu__item {{ Request::is('send_message*') ? 'active' : '' }}" href="{{route('send-message')}}">--}}
{{--                <i class="fa fa-hdd-o"></i>&nbsp;&nbsp;<span--}}
{{--                    class="app-menu__label">Send Message</span></a></li>--}}
{{--        <li><a class="app-menu__item {{ Request::is('template_send_message*') ? 'active' : '' }}" href="{{route('template-send-message')}}">--}}
{{--                <i class="fa fa-hdd-o"></i>&nbsp;&nbsp;<span--}}
{{--                    class="app-menu__label">Template Send Message</span></a></li>--}}

    </ul>
</aside>
