<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
					<img src="{{ asset('assets/images/1.png')}}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">BLESSING SERVICE</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">

               <li>
                    <a href="{{route('member.dashboard')}}" >
                        <div class="menu-title">@lang('Dashboard')</div>
                    </a>
                </li>

                {{-- <li class="menu-label">@lang('Master Management')</li> --}}
				<li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='lni lni-users'></i>
                        </div>
                        <div class="menu-title">Layanan</div>
                    </a>
                    <ul>
                        <li> <a href="{{route('member.layanan')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Lists')</a></li>
                    </ul>
                </li>
				<li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='lni lni-users'></i>
                        </div>
                        <div class="menu-title">Antrian</div>
                    </a>
                    <ul>
                        <li> <a href="{{route('member.antrian')}}"><i class="bx bx-right-arrow-alt"></i>@lang('Lists')</a></li>
                        <li> <a href="{{route('member.antrian.histpry')}}"><i class="bx bx-right-arrow-alt"></i>@lang('History')</a></li>
                    </ul>
                </li>

                {{-- <li class="menu-label">@lang('Membership Management')</li> --}}

            </ul>
            <!--end navigation-->
        </div>
