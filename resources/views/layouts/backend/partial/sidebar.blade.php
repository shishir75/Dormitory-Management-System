<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('home') }}" class="brand-link">
		<img src="{{ asset('assets/backend/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
		     style="opacity: .8">
		<span class="brand-text font-weight-light">DMS</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="info">
				<a href="#" class="d-block">
					@if(Auth::user()->role->id == 2)
						@php
                            $dept = App\Models\Dept::where('name', Auth::user()->name)->first();
						@endphp
						{{ $dept->short_name }} Office

                    @elseif(Auth::user()->role->id == 3)
                        @php
                            $hall = App\Models\Hall::where('name', Auth::user()->name)->first();
                        @endphp
                        {{ $hall->short_name }} Office
                    @elseif(Auth::user()->role->id == 5)
                        @php
                            $dining = App\Models\Dining::where('name', Auth::user()->name)->first();
                        @endphp
                        {{ $dining->short_name }}
					@else
						{{ Auth::user()->name }}
					@endif
				</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				@if(Request::is('register*')))
					<li class="nav-item has-treeview">
						<a href="{{ route('register.dashboard') }}" class="nav-link {{ Request::is('register/dashboard') ? 'active' : '' }}">
							<i class="nav-icon fa fa-dashboard"></i>
							<p>
								Dashboard
							</p>
						</a>
					</li>
					<li class="nav-item has-treeview {{ Request::is('register/dept*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('register/dept*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-sliders"></i>
							<p>
								Departments
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('register.dept.create') }}" class="nav-link {{ Request::is('register/dept/create') ? 'active' : '' }}">
									<i class="fa fa-circle-o nav-icon"></i>
									<p>Add Department</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('register.dept.index') }}" class="nav-link {{ Request::is('register/dept') ? 'active' : '' }}">
									<i class="fa fa-circle-o nav-icon"></i>
									<p>All Depts</p>
								</a>
							</li>
						</ul>
					</li>


				<li class="nav-item has-treeview {{ Request::is('register/session*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('register/session*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-clock-o"></i>
						<p>
							Sessions
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('register.session.create') }}" class="nav-link {{ Request::is('register/session/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Session</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('register.session.index') }}" class="nav-link {{ Request::is('register/session') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Sessions</p>
							</a>
						</li>
					</ul>
				</li>

                <li class="nav-item has-treeview {{ Request::is('register/hall*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('register/hall*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashcube"></i>
                        <p>
                            Halls
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('register.hall.create') }}" class="nav-link {{ Request::is('register/hall/create') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Add Hall</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register.hall.index') }}" class="nav-link {{ Request::is('register/hall') ? 'active' : '' }}">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>All Halls</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('register.received_money.index') }}" class="nav-link {{ Request::is('register/receive-bill') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Hall Bills
                        </p>
                    </a>
                </li>

                <li class="nav-header">MENU</li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('register.change-password.index') }}" class="nav-link {{ Request::is('register/change-password*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Change Password
                            </p>
                        </a>
                    </li>

				@elseif(Request::is('dept-office*')))

                    <li class="nav-item has-treeview">
                        <a href="{{ route('dept_office.dashboard') }}" class="nav-link {{ Request::is('dept-office/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('dept_office.halls.index') }}" class="nav-link {{ Request::is('dept-office/halls') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Halls
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ Request::is('dept-office/student*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('dept-office/student*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-graduation-cap"></i>
                            <p>
                                Students
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dept_office.student.create') }}" class="nav-link {{ Request::is('dept-office/student/create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>Add Student</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dept_office.student.index') }}" class="nav-link {{ Request::is('dept-office/student') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>All Students</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">MENU</li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('dept_office.change-password.index') }}" class="nav-link {{ Request::is('dept-office/change-password*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                Change Password
                            </p>
                        </a>
                    </li>


			@elseif(Request::is('hall-office*')))

                <li class="nav-item has-treeview">
                    <a href="{{ route('hall_office.dashboard') }}" class="nav-link {{ Request::is('hall-office/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('hall_office.allotted-students.index') }}" class="nav-link {{ Request::is('hall-office/allotted-students*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Allotted Students
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ Request::is('hall-office/rooms*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('hall-office/rooms*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-graduation-cap"></i>
						<p>
							Rooms
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('hall_office.rooms.create') }}" class="nav-link {{ Request::is('hall-office/rooms/create') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Add Rooms</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('hall_office.rooms.index') }}" class="nav-link {{ Request::is('hall-office/rooms') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>All Rooms</p>
							</a>
						</li>
					</ul>
				</li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('hall_office.payment.index') }}" class="nav-link {{ Request::is('hall-office/payment*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Make Dining Payment
                        </p>
                    </a>
                </li>

                <li class="nav-header">MENU</li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('hall_office.change-password.index') }}" class="nav-link {{ Request::is('hall-office/change-password*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>


			@elseif(Request::is('student*')))
				<li class="nav-item has-treeview">
					<a href="{{ route('student.dashboard') }}" class="nav-link {{ Request::is('student/dashboard') ? 'active' : '' }}">
						<i class="nav-icon fa fa-dashboard"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('student.coupon.index') }}" class="nav-link {{ Request::is('student/coupon*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Food Coupons
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ route('student.transaction') }}" class="nav-link {{ Request::is('student/transaction') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Transactions
                        </p>
                    </a>
                </li>

                <li class="nav-header">MENU</li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('student.change-password.index') }}" class="nav-link {{ Request::is('student/change-password*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>

            @elseif(Request::is('dining*')))
                <li class="nav-item has-treeview">
                    <a href="{{ route('dining.dashboard') }}" class="nav-link {{ Request::is('dining/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('dining.coupon.index') }}" class="nav-link {{ Request::is('dining/coupon*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Food Coupons
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('dining.transaction') }}" class="nav-link {{ Request::is('dining/transaction') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Transactions
                        </p>
                    </a>
                </li>

                <li class="nav-header">MENU</li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('dining.change-password.index') }}" class="nav-link {{ Request::is('dining/change-password*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>

			@endif
				<li class="nav-item">
					<a class="nav-link" href="{{ route('logout') }}"
					   onclick="event.preventDefault();
					   document.getElementById('logout-form').submit();">
						<i class="nav-icon fa fa-sign-out"></i> Logout
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
