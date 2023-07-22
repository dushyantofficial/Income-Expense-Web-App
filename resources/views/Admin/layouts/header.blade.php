  <header class="app-header"><a class="app-header__logo" href="{{route('home')}}">@lang('langs.income') </a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
                                      aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
          <li class="app-search">
              <a href="{{route('calendar')}}" type="button" class="btn btn-danger">Calendar
              </a>&nbsp;&nbsp;
              <a href="{{url('clear_cache')}}" class="btn btn-success">Cache Clear</a>
              </a>&nbsp;

              @include('Admin.languages')
          </li>
          <!--Notification Menu-->

          <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                                  aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
              <ul class="app-notification dropdown-menu dropdown-menu-right">
                  <li class="app-notification__title">You have 4 new notifications.</li>
                  <div class="app-notification__content">
                      <li><a class="app-notification__item" href="javascript:;"><span
                                  class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                          class="fa fa-circle fa-stack-2x text-primary"></i><i
                                          class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                              <div>
                                  <p class="app-notification__message">Lisa sent you a mail</p>
                                  <p class="app-notification__meta">2 min ago</p>
                              </div>
                          </a></li>
                      <li><a class="app-notification__item" href="javascript:;"><span
                                  class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                          class="fa fa-circle fa-stack-2x text-danger"></i><i
                                          class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                              <div>
                                  <p class="app-notification__message">Mail server not working</p>
                                  <p class="app-notification__meta">5 min ago</p>
                              </div>
                          </a></li>
                      <li><a class="app-notification__item" href="javascript:;"><span
                                  class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                          class="fa fa-circle fa-stack-2x text-success"></i><i
                                          class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                              <div>
                                  <p class="app-notification__message">Transaction complete</p>
                                  <p class="app-notification__meta">2 days ago</p>
                              </div>
                          </a></li>
                      <div class="app-notification__content">
                          <li><a class="app-notification__item" href="javascript:;"><span
                                      class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                              class="fa fa-circle fa-stack-2x text-primary"></i><i
                                              class="fa fa-envelope fa-stack-1x fa-inverse"></i></span></span>
                                  <div>
                                      <p class="app-notification__message">Lisa sent you a mail</p>
                                      <p class="app-notification__meta">2 min ago</p>
                                  </div>
                              </a></li>
                          <li><a class="app-notification__item" href="javascript:;"><span
                                      class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                              class="fa fa-circle fa-stack-2x text-danger"></i><i
                                              class="fa fa-hdd-o fa-stack-1x fa-inverse"></i></span></span>
                                  <div>
                                      <p class="app-notification__message">Mail server not working</p>
                                      <p class="app-notification__meta">5 min ago</p>
                                  </div>
                              </a></li>
                          <li><a class="app-notification__item" href="javascript:;"><span
                                      class="app-notification__icon"><span class="fa-stack fa-lg"><i
                                              class="fa fa-circle fa-stack-2x text-success"></i><i
                                              class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                                  <div>
                                      <p class="app-notification__message">Transaction complete</p>
                                      <p class="app-notification__meta">2 days ago</p>
                                  </div>
                              </a></li>
                      </div>
                  </div>
                  <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
              </ul>
          </li>
          <!-- User Menu-->
          <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"
                  aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
              <ul class="dropdown-menu settings-menu dropdown-menu-right">
                  <li><a class="dropdown-item" href="{{route('profile')}}"><i class="fa fa-user fa-lg"></i> @lang('langs.profile')</a></li>
                  <li><a class="dropdown-item" href="{{route('profile')}}?document=password"><i class="fa fa-lg fa-fw fa-lock"></i>@lang('langs.change_password')</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                              class="fa fa-sign-out fa-lg"></i> @lang('langs.user_logout')</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
              </ul>
          </li>
      </ul>
  </header>

  {{--  <!-- Button trigger modal -->--}}
  {{--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">--}}
  {{--      Launch demo modal--}}
  {{--  </button>--}}

  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
       aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="calendar">
                      <div class="calendar-top">
                          <button class="icons" id="prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                          <div class="top">
                              <h3 id="monthYear"></h3>
                          </div>
                          <button class="icons" id="next"><i class="fa fa-chevron-right" aria-hidden="true"></i>
                          </button>
                      </div>
                      <div class="calendar-bottom">
                          <div class="days-of-week">
                              <p>SUN</p>
                              <p>MON</p>
                              <p>TUE</p>
                              <p>WED</p>
                              <p>THUR</p>
                              <p>FRI</p>
                              <p>SAT</p>
                          </div>
                          <div class="days"></div>
                      </div>
                  </div>


              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <a href="{{route('calendar')}}" type="button" class="btn btn-primary">ToDay Date</a>&nbsp;&nbsp;
              </div>
          </div>
      </div>
  </div>
  @push('page_scripts')

  @endpush
