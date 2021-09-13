<?php
	use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
	$configs    		= session('configs');
	$level    			= session('level');
	(session('advert')) ? $advert = session('advert') : $advert = null;
?>
		<li class="sidebar-toggler-wrapper hide">
			<div class="sidebar-toggler">
				<span></span>
			</div>
		</li>
		@if($level == "Super Admin")
		<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
			<h3 class="uppercase" style="color: #000;font-weight: 600;">Home</h3>
		</li>
		<li class="nav-item {{($menu_active == 'home') ? 'active' : ''}}">
			<a href="{{url('home')}}" class="nav-link">
				<i class="icon-home"></i>
				<span class="title">Home</span>
			</a>
		</li>
		<li class="nav-item {{($menu_active == 'setting-home-user') ? 'active' : ''}}">
			<a href="{{url('setting/home/user')}}" class="nav-link">
				<i class="fa fa-cog "></i>
				<span class="title">Home Setting</span>
			</a>
		</li>
		@endif

		@if(MyHelper::hasAccess([347,348,349,350], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #3C3424;font-weight: 600;">Recruitment</h3>
			</li>
		@endif
		@if(MyHelper::hasAccess([347,348,349,350], $grantedFeature))
		<li class="nav-item {{($menu_active == 'hair-stylist') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="fa fa-cut"></i>
				<span class="title">Hair Stylist</span>
				<span class="arrow {{($menu_active == 'hair-stylist') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				<li class="nav-item {{($submenu_active == 'hair-stylist-candidate') ? 'active open' : ''}}">
					<a href="{{url('recruitment/hair-stylist/candidate')}}" class="nav-link ">
						<span class="title">Candidate List</span>
					</a>
				</li>
				<li class="nav-item {{($submenu_active == 'hair-stylist-list') ? 'active open' : ''}}">
					<a href="{{url('recruitment/hair-stylist')}}" class="nav-link ">
						<span class="title">Hair Stylist List</span>
					</a>
				</li>
			</ul>
		@endif

		@if(MyHelper::hasAccess([2,4,7,9,148], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Accounts</h3>
			</li>
			<li class="nav-item {{($menu_active == 'user') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-users"></i>
					<span class="title">User</span>
					<span class="arrow {{($menu_active == 'user') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([4], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-new') ? 'active open' : ''}}">
						<a href="{{url('user/create')}}" class="nav-link ">
							<span class="title">New User</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([2], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-list') ? 'active open' : ''}}">
						<a href="{{url('user')}}" class="nav-link ">
							<span class="title">User List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([323,324,325,326,327,328,329,330,331,332,333,334,335,336,337], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'role') ? 'active open' : ''}}">
							<a href="javascript:;" class="nav-link nav-toggle">
								<span class="title">User Role</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								@if(MyHelper::hasAccess([323,325,326,327], $grantedFeature))
									<li class="nav-item {{(isset($child_active) && $child_active == 'job-level-list') ? 'active open' : ''}}">
										<a href="{{url('job-level')}}" class="nav-link ">
											<span class="title">Job Level List</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([328,329,330,331,332], $grantedFeature))
									<li class="nav-item {{(isset($child_active) && $child_active == 'user-department-list') ? 'active open' : ''}}">
										<a href="{{url('user/department')}}" class="nav-link ">
											<span class="title">Department List</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([334], $grantedFeature))
									<li class="nav-item {{(isset($child_active) && $child_active == 'role-new') ? 'active open' : ''}}">
										<a href="{{url('role/create')}}" class="nav-link ">
											<span class="title">New Role</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([333,335,336,337], $grantedFeature))
									<li class="nav-item {{(isset($child_active) && $child_active == 'role-list') ? 'active open' : ''}}">
										<a href="{{url('role')}}" class="nav-link ">
											<span class="title">Role List</span>
										</a>
									</li>
								@endif
							</ul>
						</li>
					@endif
					@if(MyHelper::hasAccess([7], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'user-log') ? 'active open' : ''}}">
						<a href="{{url('user/activity')}}" class="nav-link ">
							<span class="title">Log Activity</span>
						</a>
					</li>
					@endif

					@if(MyHelper::hasAccess([40], $configs))
						@if(MyHelper::hasAccess([91], $grantedFeature))
							@if(MyHelper::hasAccess([41], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-sent') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-sent')}}" class="nav-link ">
										<span class="title">[Response] Pin Sent</span>
									</a>
								</li>
									<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-sent-whatsapp') ? 'active open' : ''}}">
										<a href="{{url('user/autoresponse/pin-sent-whatsapp')}}" class="nav-link ">
											<span class="title">[Response] Pin Sent WhatsApp</span>
										</a>
									</li>
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-create') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-create')}}" class="nav-link ">
										<span class="title">[Response] Pin Create</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([42], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-verify') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-verify')}}" class="nav-link ">
										<span class="title">[Response] Pin Verified</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([106], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-email-verify') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/email-verify')}}" class="nav-link ">
										<span class="title">[Response] Email Verify</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-changed') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-changed')}}" class="nav-link ">
										<span class="title">[Response] Pin Changed First Time</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-changed-forgot-password') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-changed-forgot-password')}}" class="nav-link ">
										<span class="title">[Response] Pin Changed Forgot Password</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([83], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-forgot') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-forgot')}}" class="nav-link ">
										<span class="title">[Response] Pin Forgot</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([44], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-success') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-success')}}" class="nav-link ">
										<span class="title">[Response] Login Success</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([45], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-failed') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-failed')}}" class="nav-link ">
										<span class="title">[Response] Login Failed</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-login-first-time') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/login-first-time')}}" class="nav-link ">
										<span class="title">[Response] Login First Time</span>
									</a>
								</li>
							@endif
						@endif
					@endif
				</ul>
			</li>

			@if(MyHelper::hasAccess([5], $configs))
			@if(MyHelper::hasAccess([9], $grantedFeature))
			<li class="nav-item {{($menu_active == 'admin-outlet') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-eye"></i>
					<span class="title">Admin Outlet</span>
					<span class="arrow {{($menu_active == 'admin-outlet') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([4], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'admin-outlet-create') ? 'active open' : ''}}">
						<a href="{{url('user/adminoutlet/create')}}" class="nav-link ">
							<span class="title">New Admin Outlet</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([9], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'admin-outlet-list') ? 'active open' : ''}}">
						<a href="{{url('user/adminoutlet')}}" class="nav-link ">
							<span class="title">Admin Outlet List</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@endif

		@endif

		@if(MyHelper::hasAccess([20], $configs))
			@if(MyHelper::hasAccess([11,13], $grantedFeature))
			<li class="nav-item {{($menu_active == 'membership') ? 'active' : ''}}">
				<a href="{{url('membership')}}" class="nav-link">
					<i class="icon-badge"></i>
					<span class="title">Membership</span>
				</a>
			</li>
			@endif
		@endif

		@if($level == "Super Admin")
		<li class="nav-item {{($menu_active == 'expired-qrcode') ? 'active' : ''}}">
			<a href="{{url('setting/qrcode_expired')}}" class="nav-link">
				<i class="fa fa-qrcode"></i>
				<span class="title">Setting Expired QR Code</span>
			</a>
		</li>

		<li class="nav-item {{($menu_active == 'count-login-failed') ? 'active' : ''}}">
			<a href="{{url('setting/count_login_failed')}}" class="nav-link">
				<i class="fa fa-times-circle-o"></i>
				<span class="title">Setting Count Login Failed</span>
			</a>
		</li>

		@if(MyHelper::hasAccess([18], $configs))
			@if(MyHelper::hasAccess([77], $configs))
			<li class="nav-item {{($menu_active == 'point-reset') ? 'active' : ''}}">
				<a href="{{url('setting/point_reset')}}" class="nav-link">
					<i class="fa fa-refresh"></i>
					<span class="title">Setting Point Reset</span>
				</a>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([120,148], $grantedFeature))
		<li class="nav-item {{($menu_active == 'profile-completion') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="icon-users"></i>
				<span class="title">Profile Completion</span>
				<span class="arrow {{($menu_active == 'profile-completion') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([148], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'complete-profile') ? 'active open' : ''}}">
					<a href="{{url('setting/complete-profile')}}" class="nav-link ">
						<span class="title">User Profile Completion</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([120], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'complete-user-profile-point-bonus') ? 'active' : ''}}">
					<a href="{{url('user/autoresponse/complete-user-profile-point-bonus')}}" class="nav-link nav-toggle">
						<span class="title">[Response] User Profile Completion Point Bonus</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif

		@if(MyHelper::hasAccess([19], $configs))
			@if(MyHelper::hasAccess([78], $configs))
			<li class="nav-item {{($menu_active == 'balance-reset') ? 'active' : ''}}">
				<a href="{{url('setting/balance_reset')}}" class="nav-link">
					<i class="fa fa-refresh"></i>
					<span class="title">Setting {{env('POINT_NAME', 'Points')}} Reset</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'balance-resets') ? 'active' : ''}}">
				<a href="{{url('autoresponse/balance-resets/report-point-reset')}}" class="nav-link">
					<i class="fa fa-envelope"></i>
					<span class="title">[Email] {{env('POINT_NAME', 'Points')}} Reset</span>
				</a>
			</li>
			@endif
		@endif

		@endif

		@if(MyHelper::hasAccess([301,302,303,304,305], $grantedFeature))
			<li class="nav-item {{($menu_active == 'user-franchise') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-user-plus"></i>
					<span class="title">User Mitra</span>
					<span class="arrow {{($menu_active == 'user-franchise') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([301,302,304], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-franchise-list') ? 'active open' : ''}}">
							<a href="{{url('user/user-franchise')}}" class="nav-link ">
								<span class="title">User Mitra List</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([303], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-franchise-new') ? 'active open' : ''}}">
							<a href="{{url('user/user-franchise/create')}}" class="nav-link ">
								<span class="title">New User Mitra</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([304], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-franchise-import') ? 'active open' : ''}}">
							<a href="{{url('user/user-franchise/import')}}" class="nav-link ">
								<span class="title">Export & Import</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([304], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'user-autoresponse-new-user-franchise') ? 'active open' : ''}}">
							<a href="{{url('user/autoresponse-franchise/new-user-franchise')}}" class="nav-link ">
								<span class="title">[Response] New User Mitra</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'user-autoresponse-reset-password-user-franchise') ? 'active open' : ''}}">
							<a href="{{url('user/autoresponse-franchise/reset-password-user-franchise')}}" class="nav-link ">
								<span class="title">[Response] Reset Password User Mitra</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
		@endif

		@if(MyHelper::hasAccess([338,339,340,341,342,343,344,345], $grantedFeature))
		<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
			<h3 class="uppercase" style="color: #3C3424;font-weight: 600;">Business Development</h3>
		</li>
		@if(MyHelper::hasAccess([338,339,340,341], $grantedFeature))
		<li class="nav-item {{($menu_active == 'partners') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="fa fa-users"></i>
				<span class="title">Partners</span>
				<span class="arrow {{($menu_active == 'partners') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([338], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'list-partners') ? 'active open' : ''}}">
					<a href="{{url('businessdev/partners')}}" class="nav-link ">
						<span class="title">List Partner</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([338], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'list-candidate-partners') ? 'active open' : ''}}">
					<a href="{{url('businessdev/partners/candidate')}}" class="nav-link ">
						<span class="title">List Candidate Partner</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif
		@if(MyHelper::hasAccess([342,343,344,345], $grantedFeature))
		<li class="nav-item {{($menu_active == 'locations') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="fa fa-institution"></i>
				<span class="title">Locations</span>
				<span class="arrow {{($menu_active == 'locations') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([342], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'list-locations') ? 'active open' : ''}}">
					<a href="{{url('businessdev/locations')}}" class="nav-link ">
						<span class="title">List Locations</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([342], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'list-candidate-locations') ? 'active open' : ''}}">
					<a href="{{url('businessdev/locations/candidate')}}" class="nav-link ">
						<span class="title">List Candidate Locations</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif
		@endif



		@if(MyHelper::hasAccess([19,21,24,26,32,33,34,43,45,48,50,56,57,164,165,166,167], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Browse</h3>
			</li>
			@if(MyHelper::hasAccess([34], $configs))
				@if(MyHelper::hasAccess([19,21,164,165,166,167], $grantedFeature))
				<li class="nav-item {{($menu_active == 'news') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-feed"></i>
						<span class="title">News</span>
						<span class="arrow {{($menu_active == 'news') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([21], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-new') ? 'active open' : ''}}">
							<a href="{{url('news/create')}}" class="nav-link ">
								<span class="title">New News</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([19], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-list') ? 'active open' : ''}}">
							<a href="{{url('news')}}" class="nav-link ">
								<span class="title">News List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([164,166,167], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-category') ? 'active open' : ''}}">
							<a href="{{url('news/category')}}" class="nav-link ">
								<span class="title">News Category</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([165], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-category-new') ? 'active open' : ''}}">
							<a href="{{url('news/category/create')}}" class="nav-link ">
								<span class="title">New News Category</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([22,166], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'news-manage-position') ? 'active open' : ''}}">
								<a href="{{url('news/position/assign')}}" class="nav-link ">
									<span class="title">Manage Position</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([120,122], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'news-autoresponse-create-news') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/news/create-news')}}" class="nav-link ">
								<span class="title">[Forward] Create News</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'news-autoresponse-update-news') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/news/update-news')}}" class="nav-link ">
								<span class="title">[Forward] Update News</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([95], $configs))
			@if(MyHelper::hasAccess([155,156,157,158,159], $grantedFeature))
			<li class="nav-item {{($menu_active == 'brand') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-badge"></i>
					<span class="title">Brand</span>
					<span class="arrow {{($menu_active == 'brand') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([156], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'brand-new') ? 'active open' : ''}}">
						<a href="{{url('brand/create')}}" class="nav-link ">
							<span class="title">New Brand</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([155,157,158,159], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'brand-list') ? 'active open' : ''}}">
						<a href="{{url('brand')}}" class="nav-link ">
							<span class="title">List Brand</span>
						</a>
					</li>
					@endif
					{{-- @if(MyHelper::hasAccess([157], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'inactive-brand-image') ? 'active open' : ''}}">
						<a href="{{url('brand/inactive-image')}}" class="nav-link ">
							<span class="title">Inactive Brand Image</span>
						</a>
					</li>
					@endif --}}
				</ul>
			</li>
			@endif
			@endif

			@if(MyHelper::hasAccess([24,26,32,33,34,261], $grantedFeature))
			<li class="nav-item {{($menu_active == 'outlet') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-pointer"></i>
					<span class="title">Outlet</span>
					<span class="arrow {{($menu_active == 'outlet') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(!MyHelper::hasAccess([82], $configs))
						@if(MyHelper::hasAccess([26], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-new') ? 'active open' : ''}}">
							<a href="{{url('outlet/create')}}" class="nav-link ">
								<span class="title">New Outlet</span>
							</a>
						</li>
						@endif
					@endif
					{{--
					@if(MyHelper::hasAccess([247], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-list-user-franchise') ? 'active open' : ''}}">
							<a href="{{url('outlet/list/user-franchise')}}" class="nav-link ">
								<span class="title">List User Franchise</span>
							</a>
						</li>
					@endif
					--}}
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-list') ? 'active open' : ''}}">
						<a href="{{url('outlet/list')}}" class="nav-link ">
							<span class="title">Outlet List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([199], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'default-outlet') ? 'active open' : ''}}">
						<a href="{{url('setting/default_outlet')}}" class="nav-link ">
							<span class="title">Default Outlet</span>
						</a>
					</li>
					@endif
					{{-- @if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-qrcode') ? 'active open' : ''}}">
						<a href="{{url('outlet/qrcode')}}" class="nav-link ">
							<span class="title">QRCode Outlet</span>
						</a>
					</li>
					@endif --}}
					@if(MyHelper::hasAccess([4], $configs))
						@if(MyHelper::hasAccess([34], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-holiday') ? 'active open' : ''}}">
							<a href="{{url('outlet/holiday')}}" class="nav-link ">
								<span class="title">Outlet Holiday Setting</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([2], $configs) || MyHelper::hasAccess([3], $configs))
						@if(MyHelper::hasAccess([27], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'manage-location') ? 'active open' : ''}}">
							<a href="{{url('outlet/manage-location')}}" class="nav-link ">
								<span class="title">Manage Location</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([2], $configs) || MyHelper::hasAccess([3], $configs))
						@if(MyHelper::hasAccess([32, 33], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'outlet-export-import') ? 'active open' : ''}}">
								<a href="{{url('outlet/export-import')}}" class="nav-link ">
									<span class="title">Export Import Outlet</span>
								</a>
							</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([261], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'export-outlet-pin') ? 'active open' : ''}}">
							<a href="{{url('outlet/export-outlet-pin')}}" class="nav-link ">
								<span class="title">Export Outlet PIN</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([5], $configs) && MyHelper::hasAccess([101], $configs))
						@if(MyHelper::hasAccess([24], $grantedFeature) && MyHelper::hasAccess([40], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'outlet-pin-response') ? 'active open' : ''}}">
								<a href="{{url('outlet/autoresponse/request_pin')}}" class="nav-link ">
									<span class="title">Outlet Apps Access Feature</span>
								</a>
							</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([120,122], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-autoresponse-outlet-pin-sent') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/outlet/outlet-pin-sent')}}" class="nav-link ">
								<span class="title">[Response] Outlet Pin Sent</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'outlet-autoresponse-outlet-pin-sent-user-franchise') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/outlet/outlet-pin-sent-user-franchise')}}" class="nav-link ">
								<span class="title">[Response] Outlet Pin Sent User Franchise</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'outlet-autoresponse-request-admin-user-franchise') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/outlet/request-admin-user-franchise')}}" class="nav-link ">
								<span class="title">[Response] Request Admin User Franchise</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'outlet-incomplete-response') ? 'active open' : ''}}">
							<a href="{{url('outlet/autoresponse/incomplete-outlet-data')}}" class="nav-link ">
								<span class="title">[Forward] Incomplete Outlet Data</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([294,295,296,297,298], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-group-filter') ? 'active open' : ''}}">
							<a href="javascript:;" class="nav-link nav-toggle">
								<span class="title">Outlet Group Filter</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item {{(isset($child_active) && $child_active == 'outlet-group-filter-new') ? 'active open' : ''}}">
									<a href="{{url('outlet-group-filter/create')}}" class="nav-link ">
										<span class="title">New Outlet Group Filter</span>
									</a>
								</li>
								@if(MyHelper::hasAccess([294,295,297,298], $grantedFeature))
								<li class="nav-item {{(isset($child_active) && $child_active == 'outlet-group-filter-list') ? 'active open' : ''}}">
									<a href="{{url('outlet-group-filter')}}" class="nav-link ">
										<span class="title">Outlet Group Filter List</span>
									</a>
								</li>
								@endif
							</ul>
						</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([43,45,48,50,56,57,236,239], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-wallet"></i>
					<span class="title">Product</span>
					<span class="arrow {{($menu_active == 'product') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([45], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category-new') ? 'active open' : ''}}">
						<a href="{{url('product/category/create')}}" class="nav-link ">
							<span class="title">New Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([43], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category-list') ? 'active open' : ''}}">
						<a href="{{url('product/category')}}" class="nav-link ">
							<span class="title">Category List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([239], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-promo-category-new') ? 'active open' : ''}}">
						<a href="{{url('product/promo-category/create')}}" class="nav-link ">
							<span class="title">New Promo Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([236], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-promo-category-list') ? 'active open' : ''}}">
						<a href="{{url('product/promo-category')}}" class="nav-link ">
							<span class="title">Promo Category List</span>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item {{($submenu_active == 'product-tag-list') ? 'active open' : ''}}">
						<a href="{{url('product/tag')}}" class="nav-link ">
							<span class="title">Tag List</span>
						</a>
					</li> -->
					@if(!MyHelper::hasAccess([1], $configs))
						@if(MyHelper::hasAccess([50], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'product-new') ? 'active open' : ''}}">
							<a href="{{url('product/create')}}" class="nav-link ">
								<span class="title">New Product</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([10], $configs)|| MyHelper::hasAccess([11], $configs))
						@if(MyHelper::hasAccess([56,57], $grantedFeature))
						<li class="nav-item {{(strpos($submenu_active , 'product-import') !== false) ? 'active open' : ''}}">
							<a href="javascript:;" class="nav-link nav-toggle">
								<span class="title">Export & Import Product</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item {{($submenu_active == 'product-import-global') ? 'active open' : ''}}">
									<a href="{{url('product/import/global')}}" class="nav-link ">
										<span class="title">Global</span>
									</a>
								</li>
								<li class="nav-item {{($submenu_active == 'product-import-detail') ? 'active open' : ''}}">
									<a href="{{url('product/import/detail')}}" class="nav-link ">
										<span class="title">Product Detail</span>
									</a>
								</li>
								<li class="nav-item {{($submenu_active == 'product-import-price') ? 'active open' : ''}}">
									<a href="{{url('product/import/price')}}" class="nav-link ">
										<span class="title">Product Price</span>
									</a>
								</li>
							</ul>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list') ? 'active open' : ''}}">
						<a href="{{url('product')}}" class="nav-link ">
							<span class="title">Product List</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'product-image') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<span class="title">Image Product</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item {{(isset($child_active) && $child_active == 'product-image-add') ? 'active open' : ''}}">
								<a href="{{url('product/image/add')}}" class="nav-link ">
									<span class="title">Upload Image</span>
								</a>
							</li>
							<li class="nav-item {{(isset($child_active) && $child_active == 'product-image-detail') ? 'active open' : ''}}">
								<a href="{{url('product/image/detail')}}" class="nav-link ">
									<span class="title">Upload Image Detail</span>
								</a>
							</li>
							<li class="nav-item {{(isset($child_active) && $child_active == 'product-image-list') ? 'active open' : ''}}">
								<a href="{{url('product/image/list')}}" class="nav-link ">
									<span class="title">Image List</span>
								</a>
							</li>
						</ul>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-visible') ? 'active open' : ''}}">
						<a href="{{url('product/visible')}}" class="nav-link ">
							<span class="title">Visible Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-hidden') ? 'active open' : ''}}">
						<a href="{{url('product/hidden')}}" class="nav-link ">
							<span class="title">Hidden Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-category') ? 'active open' : ''}}">
						<a href="{{url('product/category/assign')}}" class="nav-link ">
							<span class="title">Manage Product Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-position') ? 'active open' : ''}}">
						<a href="{{url('product/position/assign')}}" class="nav-link ">
							<span class="title">Manage Position</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'product-photo-default') ? 'active open' : ''}}">
						<a href="{{url('product/photo/default')}}" class="nav-link ">
							<span class="title">Product Photo Default</span>
						</a>
					</li>
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([48,49,50,51,52], $grantedFeature))
				<li class="nav-item {{($menu_active == 'product-plastic') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-wallet"></i>
						<span class="title">Product Plastic</span>
						<span class="arrow {{($menu_active == 'product-plastic') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'plastic-type') ? 'active open' : ''}}">
							<a href="javascript:;" class="nav-link nav-toggle">
								<span class="title">Plastic Type</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								@if(MyHelper::hasAccess([50], $grantedFeature))
								<li class="nav-item {{(isset($child_active) && $child_active == 'plastic-type-new') ? 'active open' : ''}}">
									<a href="{{url('plastic-type/create')}}" class="nav-link ">
										<span class="title">New Plastic Type</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([48,49,51,52], $grantedFeature))
								<li class="nav-item {{(isset($child_active) && $child_active == 'plastic-type-list') ? 'active open' : ''}}">
									<a href="{{url('plastic-type')}}" class="nav-link ">
										<span class="title">Plastic Type List</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([48,51], $grantedFeature))
								<li class="nav-item {{(isset($child_active) && $child_active == 'plastic-type-position') ? 'active open' : ''}}">
									<a href="{{url('plastic-type/position')}}" class="nav-link ">
										<span class="title">Plastic Type Position</span>
									</a>
								</li>
								@endif
							</ul>
						</li>
						@if(MyHelper::hasAccess([50], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'product-plastic-new') ? 'active open' : ''}}">
							<a href="{{url('product-plastic/create')}}" class="nav-link ">
								<span class="title">New Product Plastic</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([48,49,51,52], $grantedFeature))
							<li class="nav-item {{($submenu_active  == 'product-plastic-list') ? 'active open' : ''}}">
								<a href="{{url('product-plastic')}}" class="nav-link ">
									<span class="title">Product Plastic List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([48,49,51], $grantedFeature))
							<li class="nav-item {{($submenu_active  == 'product-plastic-stock') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/stock-outlet')}}" class="nav-link ">
									<span class="title">Product Plastic Update Stock</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active  == 'product-plastic-use-product') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/use/product')}}" class="nav-link ">
									<span class="title">Use Plastic Product</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active  == 'product-plastic-use-product-variant') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/use/product-variant')}}" class="nav-link ">
									<span class="title">Use Plastic Product Variant</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-plastic-import-price') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/import-price')}}" class="nav-link ">
									<span class="title">Export & Import Product Plastic Price</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-plastic-import') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/import')}}" class="nav-link ">
									<span class="title">Export & Import Use Plastic Product</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-plastic-import-product-variant') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/import-product-variant')}}" class="nav-link ">
									<span class="title">Export & Import Use Plastic Product Variant</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'import-plastic-status') ? 'active open' : ''}}">
								<a href="{{url('product-plastic/import-plastic-status-outlet')}}" class="nav-link ">
									<span class="title">Export & Import Plastic Status Outlet</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
			@endif

			@if(MyHelper::hasAccess([91], $configs)&&MyHelper::hasAccess([180,181,182,183,184,185,186], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product-modifier') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-puzzle-piece"></i>
					<span class="title">Topping</span>
					<span class="arrow {{($menu_active == 'product-modifier') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([181], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-new') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/create')}}" class="nav-link ">
							<span class="title">New Topping</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([182,183,184], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-list') ? 'active open' : ''}}">
						<a href="{{url('product/modifier')}}" class="nav-link ">
							<span class="title">Topping List</span>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item {{($submenu_active == 'product-tag-list') ? 'active open' : ''}}">
						<a href="{{url('product/tag')}}" class="nav-link ">
							<span class="title">Tag List</span>
						</a>
					</li> -->
					@if(MyHelper::hasAccess([183], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'product-modifier-position') ? 'active open' : ''}}">
							<a href="{{url('product/modifier/position')}}" class="nav-link ">
								<span class="title">Manage Position</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([185,186], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-modifier-price') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/price')}}" class="nav-link ">
							<span class="title">Topping Price</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'product-modifier-detail') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/detail')}}" class="nav-link ">
							<span class="title">Topping Detail</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'product-modifier-inventory-brand') ? 'active open' : ''}}">
						<a href="{{url('product/modifier/inventory-brand')}}" class="nav-link">
							<span class="title">Topping Inventory Brand</span>
						</a>
					</li>
					<li class="nav-item {{(strpos($submenu_active , 'product-modifier-import') !== false) ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<span class="title">Export & Import Topping</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item {{($submenu_active == 'product-modifier-import-global') ? 'active open' : ''}}">
								<a href="{{url('product/import/modifier')}}" class="nav-link ">
									<span class="title">Import Topping</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-modifier-import-price') ? 'active open' : ''}}">
								<a href="{{url('product/import/modifier-price')}}" class="nav-link ">
									<span class="title">Import Topping Price</span>
								</a>
							</li>
						</ul>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([283,284,285,286,287], $grantedFeature))
				<li class="nav-item {{($menu_active == 'product-modifier-group') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-glass"></i>
						<span class="title">Product Variant NON PRICE (NO SKU)</span>
						<span class="arrow {{($menu_active == 'product-modifier-group') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([284], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'product-modifier-group-new') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group/create')}}" class="nav-link ">
									<span class="title">New Product Variant NON PRICE (NO SKU)</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([283,285,286,287], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'product-modifier-group-list') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group')}}" class="nav-link ">
									<span class="title">Product Variant NON PRICE (NO SKU) List</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-modifier-group-price') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group/price')}}" class="nav-link ">
									<span class="title">Product Variant NON PRICE (NO SKU) Price</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-modifier-group-detail') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group/detail')}}" class="nav-link ">
									<span class="title">Product Variant NON PRICE (NO SKU) Detail</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-modifier-group-position') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group/position')}}" class="nav-link ">
									<span class="title">Manage Position Product Variant NON PRICE (NO SKU)</span>
								</a>
							</li>
							<li class="nav-item {{(strpos($submenu_active , 'product-modifier-group-import') !== false) ? 'active open' : ''}}">
								<a href="javascript:;" class="nav-link nav-toggle">
									<span class="title">Export & Import Product Variant NON PRICE (NO SKU)</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item {{($submenu_active == 'product-modifier-group-import-global') ? 'active open' : ''}}">
										<a href="{{url('product/modifier-group/import')}}" class="nav-link ">
											<span class="title">Import Product Variant NON PRICE (NO SKU)</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'product-modifier-group-import-price') ? 'active open' : ''}}">
										<a href="{{url('product/modifier-group/import-price')}}" class="nav-link ">
											<span class="title">Import Product Variant NON PRICE (NO SKU) Price</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item {{($submenu_active == 'product-modifier-group-inventory-brand') ? 'active open' : ''}}">
								<a href="{{url('product/modifier-group/inventory-brand')}}" class="nav-link ">
									<span class="title">Inventory Brand</span>
								</a>
							</li>
						@endif
					</ul>

				</li>
			@endif

			@if(MyHelper::hasAccess([278,279,280,281,282], $grantedFeature))
				<li class="nav-item {{($menu_active == 'product-variant') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-coffee"></i>
						<span class="title">Product Variant (SKU)</span>
						<span class="arrow {{($menu_active == 'product-variant') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([279], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'product-variant-new') ? 'active open' : ''}}">
								<a href="{{url('product-variant/create')}}" class="nav-link ">
									<span class="title">New Variant</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([278,279,281], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'product-variant-list') ? 'active open' : ''}}">
								<a href="{{url('product-variant')}}" class="nav-link ">
									<span class="title">Variant List</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-variant-position') ? 'active open' : ''}}">
								<a href="{{url('product-variant/position')}}" class="nav-link ">
									<span class="title">Variant Position</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-variant-group-remove') ? 'active open' : ''}}">
								<a href="{{url('product-variant-group/list-group')}}" class="nav-link ">
									<span class="title">Remove Product Variant (SKU)</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-variant-group-list') ? 'active open' : ''}}">
								<a href="{{url('product-variant-group/list')}}" class="nav-link ">
									<span class="title">Product Variant (SKU) List</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-variant-group-price') ? 'active open' : ''}}">
								<a href="{{url('product-variant-group/price')}}" class="nav-link ">
									<span class="title">Product Variant (SKU) Price</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'product-variant-group-detail') ? 'active open' : ''}}">
								<a href="{{url('product-variant-group/detail')}}" class="nav-link ">
									<span class="title">Product Variant (SKU) Detail</span>
								</a>
							</li>
							<li class="nav-item {{(strpos($submenu_active , 'product-variant-import') !== false) ? 'active open' : ''}}">
								<a href="javascript:;" class="nav-link nav-toggle">
									<span class="title">Export & Import</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item {{($submenu_active == 'product-variant-import-global') ? 'active open' : ''}}">
										<a href="{{url('product-variant/import')}}" class="nav-link ">
											<span class="title">Import Variant</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'product-variant-group-import-global') ? 'active open' : ''}}">
										<a href="{{url('product-variant-group/import')}}" class="nav-link ">
											<span class="title">Import Product Variant (SKU)</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'product-variant-group-import-price') ? 'active open' : ''}}">
										<a href="{{url('product-variant-group/import-price')}}" class="nav-link ">
											<span class="title">Import Product Variant (SKU) Price</span>
										</a>
									</li>
								</ul>
							</li>
						@endif
					</ul>
				</li>
			@endif

		@endif

		@if(MyHelper::hasAccess([58,59,60,61,62,63,64,66,69,71,299], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Order</h3>
			</li>

			@if(MyHelper::hasAccess([69], $grantedFeature))
			<li class="nav-item {{($menu_active == 'transaction') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Product Transaction</span>
					<span class="arrow {{($menu_active == 'transaction') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([13,12], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-all') ? 'active open' : ''}}">
						<a href="{{url('transaction/all/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">All Transaction</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transactions-export') ? 'active open' : ''}}">
						<a href="{{url('transaction/list-export')}}" class="nav-link ">
							<span class="title">List Export</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transactions-send-report-to-outlet') ? 'active open' : ''}}">
						<a href="{{url('transaction/send-report-outlet')}}" class="nav-link ">
							<span class="title">Send Report to Outlet</span>
						</a>
					</li>
					@endif
				{{-- <!-- <li class="nav-item {{($submenu_active == 'transaction-offline') ? 'active open' : ''}}">
                    <a href="{{url('transaction/offline/'.date('YmdHis'))}}" class="nav-link ">
                        <span class="title">Offline</span>
                    </a>
                </li> -->
                @if(MyHelper::hasAccess([12], $configs))
                <li class="nav-item {{($submenu_active == 'transaction-pickup order') ? 'active open' : ''}}">
                    <a href="{{url('transaction/pickup order/'.date('YmdHis'))}}" class="nav-link ">
                        <span class="title">Pickup Order</span>
                    </a>
                </li>
                @endif
                @if(MyHelper::hasAccess([92], $configs))
                <li class="nav-item {{($submenu_active == 'transaction-advance order') ? 'active open' : ''}}">
                    <a href="{{url('transaction/advance order/'.date('YmdHis'))}}" class="nav-link ">
                        <span class="title">Catering Order</span>
                    </a>
                </li>
                @endif --}}
				@if(MyHelper::hasAccess([12, 13], $configs) && MyHelper::hasAccess([93], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-success')}}" class="nav-link ">
							<span class="title">[Response] Transaction Success</span>
						</a>
					</li>
					<!--<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-payment') ? 'active open' : ''}}">-->
					<!--	<a href="{{url('transaction/autoresponse/transaction-payment')}}" class="nav-link ">-->
					<!--		<span class="title">[Response] Transaction Payment</span>-->
					<!--	</a>-->
					<!--</li>-->
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-expired') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-expired')}}" class="nav-link ">
							<span class="title">[Response] Transaction Expired</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-accepted') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-accepted')}}" class="nav-link ">
							<span class="title">[Response] Order Accepted</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-ready') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-ready')}}" class="nav-link ">
							<span class="title">[Response] Order Ready</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-taken') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-taken')}}" class="nav-link ">
							<span class="title">[Response] Order Taken</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-taken-by-driver') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-taken-by-driver')}}" class="nav-link ">
							<span class="title">[Response] Order Taken By Driver</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-reject') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-reject')}}" class="nav-link ">
							<span class="title">[Response] Order Rejected</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-cron-transaction') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/cron-transaction')}}" class="nav-link ">
							<span class="title">[Response] Cron Transaction</span>
						</a>
					</li>
					@if(MyHelper::hasAccess([99], $configs))
					<li class="nav-item {{($submenu_active == 'transaction-point-achievement') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-point-achievement')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Transaction Point Achievement</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'transaction-failed-point-refund') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-failed-point-refund')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Transaction Failed Point Refund</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'rejected-order-point-refund') ? 'active' : ''}}">
						<a href="{{url('transaction/autoresponse/rejected-order-point-refund')}}" class="nav-link nav-toggle">
							<span class="title">[Response] Rejected Order Point Refund</span>
						</a>
					</li>
					@if(MyHelper::hasAccess([80], $configs))
						<li class="nav-item {{($submenu_active == 'delivery-status-update') ? 'active' : ''}}">
							<a href="{{url('transaction/autoresponse/delivery-status-update')}}" class="nav-link nav-toggle">
								<span class="title">[Response] Delivery Status Update</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'transaction-autoresponse-delivery-rejected') ? 'active' : ''}}">
							<a href="{{url('autoresponse/transaction/delivery-rejected')}}" class="nav-link nav-toggle">
								<span class="title">[Forward] Delivery Rejected</span>
							</a>
						</li>
					@endif
					@endif

					<!-- <li class="nav-item {{($submenu_active == 'transaction-autoresponse-topup-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/topup-success')}}" class="nav-link ">
							<span class="title">[Response] Topup Success</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-admin-notification') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/admin-notification')}}" class="nav-link ">
							<span class="title">[Response] Admin Notification</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-generate-approval-code') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/generate-approval-code')}}" class="nav-link ">
							<span class="title">[Response] Generate Approval Code</span>
						</a>
					</li> -->
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([316,317,318,319], $grantedFeature))
				<li class="nav-item {{($menu_active == 'response-with-code') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-qrcode"></i>
						<span class="title">Response With Code</span>
						<span class="arrow {{($menu_active == 'response-with-code') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([318], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'order-taken-with-code') ? 'active open' : ''}}">
								<a href="{{url('transaction/autoresponse/order-taken-with-code')}}" class="nav-link ">
									<span class="title">[Response] Order Taken With Code</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'order-taken-delivery-with-code') ? 'active open' : ''}}">
								<a href="{{url('transaction/autoresponse/order-taken-delivery-with-code')}}" class="nav-link ">
									<span class="title">[Response] Order Taken Delivery With Code</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([317], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'response-with-code-new') ? 'active open' : ''}}">
								<a href="{{url('response-with-code/create')}}" class="nav-link ">
									<span class="title">New Code</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([316,318,319], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'response-with-code-list') ? 'active open' : ''}}">
								<a href="{{url('response-with-code')}}" class="nav-link ">
									<span class="title">Code List</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
			@endif

			@if(MyHelper::hasAccess([299], $grantedFeature))
				<li class="nav-item {{($menu_active == 'failed-void-payment') ? 'active open' : ''}}">
					<a href="{{url('transaction/failed-void-payment')}}" class="nav-link ">
						<i class="fa fa-exclamation-triangle"></i>
						<span class="title">Failed Void Payment</span>
					</a>
				</li>
			@endif

			@if(MyHelper::hasAccess([18], $configs))
				@if(MyHelper::hasAccess([71], $grantedFeature))
				<li class="nav-item {{($menu_active == 'point') ? 'active' : ''}}">
					<a href="{{url('transaction/point')}}" class="nav-link nav-toggle">
						<i class="fa fa-history"></i>
						<span class="title">Point Log History</span>
					</a>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([19], $configs))
				@if(MyHelper::hasAccess([71], $grantedFeature))
				<li class="nav-item {{($menu_active == 'balance') ? 'active' : ''}}">
					<a href="{{url('transaction/balance')}}" class="nav-link nav-toggle">
						<i class="fa fa-clock-o"></i>
						<span class="title">{{env('POINT_NAME', 'Points')}} Log History</span>
					</a>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([58,59,60,61,62,63], $grantedFeature))
			<li class="nav-item {{($menu_active == 'order') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-cogs"></i>
					<span class="title">Order Settings</span>
					<span class="arrow {{($menu_active == 'order') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([58,59,60,62], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-rule') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/rule')}}" class="nav-link ">
							<span class="title">Calculation Rule</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([13], $configs))
						@if(MyHelper::hasAccess([14], $configs))
							@if(MyHelper::hasAccess([61,63], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'internal-courier') ? 'active open' : ''}}">
								<a href="{{url('transaction/internalcourier')}}" class="nav-link ">
									<span class="title">Internal Courier</span>
								</a>
							</li>
							@endif
						@endif
					@endif
					@if(MyHelper::hasAccess([12], $configs))
						@if(MyHelper::hasAccess([58], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'transaction-processing') ? 'active open' : ''}}">
							<a href="{{url('setting/processing_time')}}" class="nav-link ">
								<span class="title">Processing Time</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([58,59,60,62], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-setting') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/cashback')}}" class="nav-link ">
							<span class="title">Global {{env('POINT_NAME', 'Points')}} Setting</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([79], $configs))
					<li class="nav-item {{($submenu_active == 'free-delivery') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/free-delivery')}}" class="nav-link ">
							<span class="title">Setting Free Delivery</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([109], $configs))
					<li class="nav-item {{($submenu_active == 'credit_card_payment_gateway') ? 'active open' : ''}}">
						<a href="{{url('setting/credit_card_payment_gateway')}}" class="nav-link ">
							<span class="title">Credit Card Payment Gateway</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([250], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'setting-payment-method') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/available-payment')}}" class="nav-link ">
								<span class="title">Setting Payment Method</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([120], $configs) && MyHelper::hasAccess([272], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'setting-timer-payment-gateway') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/timer-payment-gateway')}}" class="nav-link ">
								<span class="title">Setting Timer Payment Gateway</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([250], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'refund-reject-order') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/refund-reject-order')}}" class="nav-link ">
								<span class="title">Setting Refund Reject Order</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([262], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'auto-reject-time') ? 'active' : ''}}">
						<a href="{{url('transaction/setting/auto-reject')}}" class="nav-link nav-toggle">
							<span class="title">Setting Auto Reject Time</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([321], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-messages') ? 'active' : ''}}">
						<a href="{{url('transaction/setting/transaction-messages')}}" class="nav-link nav-toggle">
							<span class="title">Transaction Messages</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([250], $grantedFeature))
				<li class="nav-item {{($menu_active == 'delivery-settings') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-truck"></i>
						<span class="title">Delivery Settings</span>
						<span class="arrow {{($menu_active == 'delivery-settings') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'delivery-setting-available') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/available-delivery')}}" class="nav-link ">
								<span class="title">Available Delivery</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'delivery-setting-upload-image') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/delivery-upload-image')}}" class="nav-link ">
								<span class="title">Upload Logo Delivery</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'delivery-setting-outlet') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/delivery-outlet')}}" class="nav-link ">
								<span class="title">Outlet Availability</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'delivery-setting-outlet-import') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/delivery-outlet/import')}}" class="nav-link ">
								<span class="title">Import/Export Outlet Availability</span>
							</a>
						</li>
						@if(MyHelper::hasAccess([13], $configs))
							<li class="nav-item {{($submenu_active == 'delivery-setting-package-detail') ? 'active open' : ''}}">
								<a href="{{url('transaction/setting/package-detail-delivery')}}" class="nav-link ">
									<span class="title">Setting Package Detail Delivery</span>
								</a>
							</li>
						@endif
						<li class="nav-item {{(isset($child_active) && $child_active == 'forward-wehelpyou') ? 'active open' : ''}}">
							<a href="{{url('transaction/setting/forward-why-low-balance')}}" class="nav-link ">
								<span class="title">[Forward] WeHelpYou Low Balance</span>
							</a>
						</li>
					</ul>
				</li>
			@endif

			@if(MyHelper::hasAccess([116], $configs))
			<li class="nav-item {{($menu_active == 'payment-method') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-credit-card"></i>
					<span class="title">Payment Method</span>
					<span class="arrow {{($menu_active == 'payment-method') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([257], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'new-category') ? 'active open' : ''}}">
						<a href="{{url('payment-method-category/create')}}" class="nav-link ">
							<span class="title">New Category</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([258,259,260], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'category-list') ? 'active open' : ''}}">
						<a href="{{url('payment-method-category')}}" class="nav-link ">
							<span class="title">Category List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([253], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'new-payment-method') ? 'active open' : ''}}">
						<a href="{{url('payment-method/create')}}" class="nav-link ">
							<span class="title">New Payment Method</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([254,255,256], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'payment-method-list') ? 'active open' : ''}}">
						<a href="{{url('payment-method')}}" class="nav-link ">
							<span class="title">Payment Method List</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([62], $grantedFeature))
			<li class="nav-item {{($menu_active == 'product-price') ? 'active' : ''}}">
				<a href="{{url('product/price')}}" class="nav-link nav-toggle">
					<i class="fa fa-tag"></i>
					<span class="title">Outlet Product Price</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'product-detail') ? 'active open' : ''}}">
				<a href="{{url('product/outlet-detail')}}" class="nav-link ">
					<i class="fa fa-tag"></i>
					<span class="title">Outlet Product Detail</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'outlet-different-price') ? 'active' : ''}}">
				<a href="{{url('outlet/different-price')}}" class="nav-link nav-toggle">
					<i class="fa fa-check"></i>
					<span class="title">Outlet Different Price</span>
				</a>
			</li>
		@endif

			@if(MyHelper::hasAccess([197,198], $grantedFeature))
			<li class="nav-item {{($menu_active == 'default-max-order') ? 'active' : ''}}">
				<a href="{{url('setting/max_order')}}" class="nav-link nav-toggle">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Default Maximum Order</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'max-order') ? 'active' : ''}}">
				<a href="{{url('outlet/max-order')}}" class="nav-link nav-toggle">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Outlet Maximum Order</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([17], $configs))
				@if(MyHelper::hasAccess([64,66], $grantedFeature))
				<li class="nav-item {{($menu_active == 'manual-payment') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-money"></i>
						<span class="title">Manual Payment</span>
						<span class="arrow {{($menu_active == 'order') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([66], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-method-new') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment/create')}}" class="nav-link ">
									<span class="title">New Payment Method</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([64], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-method-list') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment')}}" class="nav-link ">
									<span class="title">Payment Method List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([64], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'manual-payment-list') ? 'active open' : ''}}">
								<a href="{{url('transaction/manualpayment/list')}}" class="nav-link ">
									<span class="title">Manual Payment Transaction</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'manual-payment-deals') ? 'active open' : ''}}">
									<a href="{{url('deals/manualpayment/list')}}" class="nav-link ">
										<span class="title">Manual Payment Deals</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'bank') ? 'active open' : ''}}">
									<a href="{{url('transaction/manualpayment/banks')}}" class="nav-link ">
										<span class="title">Bank List</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([25], $configs))
							@if(MyHelper::hasAccess([64], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'bank-method') ? 'active open' : ''}}">
									<a href="{{url('transaction/manualpayment/banks/method')}}" class="nav-link ">
										<span class="title">Payment Method List</span>
									</a>
								</li>
							@endif
						@endif
					</ul>
				</li>
			@endif
		@endif
			@if(MyHelper::hasAccess([249], $grantedFeature))
				<li class="nav-item {{($menu_active == 'report-gosend') ? 'active open' : ''}}">
					<a href="{{url('report/gosend')}}" class="nav-link nav-toggle">
						<i class="fa fa-truck"></i>
						<span class="title">Report GoSend</span>
					</a>
				</li>
			@endif
			@if(MyHelper::hasAccess([322], $grantedFeature))
				<li class="nav-item {{($menu_active == 'report-wehelpyou') ? 'active open' : ''}}">
					<a href="{{url('report/wehelpyou')}}" class="nav-link nav-toggle">
						<i class="fa fa-truck"></i>
						<span class="title">Report Wehelpyou</span>
					</a>
				</li>
			@endif
			@if(MyHelper::hasAccess([263], $grantedFeature))
				<li class="nav-item {{($menu_active == 'report-payment') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-credit-card"></i>
						<span class="title">Report Payment</span>
						<span class="arrow {{($menu_active == 'report-payment') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'report-payment-midtrans') ? 'active open' : ''}}">
							<a href="{{url('report/payment/midtrans')}}" class="nav-link ">
								<span class="title">Midtrans</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'report-payment-ipay88') ? 'active open' : ''}}">
							<a href="{{url('report/payment/ipay88')}}" class="nav-link ">
								<span class="title">Ipay88</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'report-payment-shopee') ? 'active open' : ''}}">
							<a href="{{url('report/payment/shopee')}}" class="nav-link ">
								<span class="title">Shopee Pay</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'report-payment-export') ? 'active open' : ''}}">
							<a href="{{url('report/payment/list-export')}}" class="nav-link ">
								<span class="title">List Export</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([274,275,276], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Invalid Transaction</h3>
			</li>

			@if(MyHelper::hasAccess([274], $grantedFeature))
				<li class="nav-item {{($menu_active == 'mark-as-pending-invalid') ? 'active open' : ''}}">
					<a href="{{url('transaction/invalid-flag/mark-as-pending-invalid')}}" class="nav-link ">
						<i class="fa fa-list-ul"></i>
						<span class="title">Mark as Pending Invalid</span>
					</a>
				</li>
			@endif

			@if(MyHelper::hasAccess([274], $grantedFeature))
				<li class="nav-item {{($menu_active == 'mark-as-invalid') ? 'active open' : ''}}">
					<a href="{{url('transaction/invalid-flag/mark-as-invalid')}}" class="nav-link ">
						<i class="fa fa-list-ul"></i>
						<span class="title">Mark as Invalid</span>
					</a>
				</li>
			@endif

			@if(MyHelper::hasAccess([275], $grantedFeature))
				<li class="nav-item {{($menu_active == 'mark-as-valid') ? 'active open' : ''}}">
					<a href="{{url('transaction/invalid-flag/mark-as-valid')}}" class="nav-link ">
						<i class="fa fa-list-ul"></i>
						<span class="title">Mark as Valid</span>
					</a>
				</li>
			@endif

			@if(MyHelper::hasAccess([276], $grantedFeature))
				<li class="nav-item {{($menu_active == 'log-invalid-flag') ? 'active open' : ''}}">
					<a href="{{url('transaction/log-invalid-flag/list')}}" class="nav-link ">
						<i class="fa fa-list-ul"></i>
						<span class="title">Log Invalid Flag</span>
					</a>
				</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([25], $configs) || MyHelper::hasAccess([26], $configs))
			@if(MyHelper::hasAccess([72,73,74,75,76,77,78,79,80,81,97], $grantedFeature))
				<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
					<h3 class="uppercase" style="color: #000;font-weight: 600;">Promo</h3>
				</li>
				@if(MyHelper::hasAccess([25], $configs))
					@if(MyHelper::hasAccess([72,73,74,75,76], $grantedFeature))
					<li class="nav-item {{($menu_active == 'deals') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-gift"></i>
							<span class="title">Deals</span>
							<span class="arrow {{($menu_active == 'deals') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([74], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-create') ? 'active open' : ''}}">
								<a href="{{url('deals/create')}}" class="nav-link ">
									<span class="title">New Deals</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([72], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-list') ? 'active open' : ''}}">
								<a href="{{url('deals')}}" class="nav-link ">
									<span class="title">Deals List</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([18], $configs))
								@if(MyHelper::hasAccess([74], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'deals-point-create') ? 'active open' : ''}}">
									<a href="{{url('deals-point/create')}}" class="nav-link ">
										<span class="title">New Point Deals</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([72], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'deals-point-list') ? 'active open' : ''}}">
									<a href="{{url('deals-point')}}" class="nav-link ">
										<span class="title">Deals Point List</span>
									</a>
								</li>
								@endif
							@endif
							@if(MyHelper::hasAccess([49], $configs))
								@if(MyHelper::hasAccess([97], $grantedFeature))
									<li class="nav-item {{($submenu_active == 'deals-autoresponse-claim-free-deals-success') ? 'active open' : ''}}">
										<a href="{{url('transaction/autoresponse/claim-free-deals-success')}}" class="nav-link ">
											<i class="fa fa-mail-forward"></i>
											<span class="title">[Response] Claim Free Deals Success</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'deals-autoresponse-claim-paid-deals-success') ? 'active open' : ''}}">
										<a href="{{url('transaction/autoresponse/claim-paid-deals-success')}}" class="nav-link ">
											<i class="fa fa-mail-forward"></i>
											<span class="title">[Response] Claim Paid Deals Success</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'deals-autoresponse-claim-point-deals-success') ? 'active open' : ''}}">
										<a href="{{url('transaction/autoresponse/claim-point-deals-success')}}" class="nav-link ">
											<i class="fa fa-mail-forward"></i>
											<span class="title">[Response] Claim Point Deals Success</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'deals-autoresponse-redeem-deals-success') ? 'active open' : ''}}">
										<a href="{{url('transaction/autoresponse/redeem-voucher-success')}}" class="nav-link ">
											<i class="fa fa-mail-forward"></i>
											<span class="title">[Response] Redeems Deals</span>
										</a>
									</li>
								@endif
							@endif
							@if(MyHelper::hasAccess([120,122], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-autoresponse-create-deals') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/deals/create-deals')}}" class="nav-link ">
									<span class="title">[Forward] Create Deals</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'deals-autoresponse-update-deals') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/deals/update-deals')}}" class="nav-link ">
									<span class="title">[Forward] Update Deals</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
				@endif


				<!-- @if(MyHelper::hasAccess([139,140,141,142,143], $grantedFeature))
					<li class="nav-item {{($menu_active == 'deals-subscription') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-present"></i>
							<span class="title">Deals Subscription</span>
							<span class="arrow {{($menu_active == 'deals-subscription') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([141], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-subscription-create') ? 'active open' : ''}}">
								<a href="{{url('deals-subscription/create')}}" class="nav-link ">
									<span class="title">New Deals Subscription</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([139,140,142,143], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-subscription-list') ? 'active open' : ''}}">
								<a href="{{url('deals-subscription')}}" class="nav-link ">
									<span class="title">Deals Subscription List</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
				@endif -->

				@if(MyHelper::hasAccess([288,289,290,291,292], $grantedFeature))
					<li class="nav-item {{($menu_active == 'product-bundling') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-present"></i>
							<span class="title">Product Bundling</span>
							<span class="arrow {{($menu_active == 'product-bundling') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([290], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'product-bundling-category-new') ? 'active open' : ''}}">
									<a href="{{url('product-bundling/category/create')}}" class="nav-link ">
										<span class="title">New Bundling Category</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([288], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'product-bundling-category') ? 'active open' : ''}}">
									<a href="{{url('product-bundling/category')}}" class="nav-link ">
										<span class="title">Bundling Category List</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([290], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'product-bundling-create') ? 'active open' : ''}}">
									<a href="{{url('product-bundling/create')}}" class="nav-link ">
										<span class="title">New Product Bundling</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([288], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'product-bundling-list') ? 'active open' : ''}}">
									<a href="{{url('product-bundling')}}" class="nav-link ">
										<span class="title">Product Bundling List</span>
									</a>
								</li>
								<li class="nav-item {{($submenu_active == 'product-bundling-position') ? 'active open' : ''}}">
									<a href="{{url('product-bundling/position/assign')}}" class="nav-link ">
										<span class="title">Manage Position</span>
									</a>
								</li>
									<li class="nav-item {{($submenu_active == 'product-bundling-setting') ? 'active open' : ''}}">
										<a href="{{url('product-bundling/setting')}}" class="nav-link ">
											<span class="title">Setting Name Brand Bundling</span>
										</a>
									</li>
							@endif
						</ul>
					</li>
				@endif
				@endif

				
				@if(MyHelper::hasAccess([26], $configs))
					@if(MyHelper::hasAccess([77,78,79,80,81], $grantedFeature))
					<li class="nav-item {{($menu_active == 'inject-voucher') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-birthday-cake"></i>
							<span class="title">Inject Voucher</span>
							<span class="arrow {{($menu_active == 'inject-voucher') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([79], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inject-voucher-create') ? 'active open' : ''}}">
								<a href="{{url('inject-voucher/create')}}" class="nav-link ">
									<span class="title">New Inject Voucher</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([77], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inject-voucher-list') ? 'active open' : ''}}">
								<a href="{{url('inject-voucher')}}" class="nav-link ">
									<span class="title">Inject Voucher List</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([49], $configs))
								<li class="nav-item {{($submenu_active == 'deals-autoresponse-receive-inject-voucher') ? 'active open' : ''}}">
									<a href="{{url('transaction/autoresponse/receive-inject-voucher')}}" class="nav-link ">
										<i class="fa fa-mail-forward"></i>
										<span class="title">[Response] Receive Inject Voucher</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([120,122], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inject-voucher-autoresponse-create-inject-voucher') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/inject-voucher/create-inject-voucher')}}" class="nav-link ">
									<span class="title">[Forward] Create Inject Voucher</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'inject-voucher-autoresponse-update-inject-voucher') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/inject-voucher/update-inject-voucher')}}" class="nav-link ">
									<span class="title">[Forward] Update Inject Voucher</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
				@endif

				@if(MyHelper::hasAccess([187,188,189,190,191], $grantedFeature))
					<li class="nav-item {{($menu_active == 'welcome-voucher') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-ticket"></i>
							<span class="title">Welcome Voucher</span>
							<span class="arrow {{($menu_active == 'welcome-voucher') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([189], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-create') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher/create')}}" class="nav-link ">
										<span class="title">New Welcome Voucher</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([187], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-list') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher')}}" class="nav-link ">
										<span class="title">Welcome Voucher List</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([187,190], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'welcome-voucher-setting') ? 'active open' : ''}}">
									<a href="{{url('welcome-voucher/setting')}}" class="nav-link ">
										<span class="title">Welcome Voucher Setting</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([293], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'deals-autoresponse-welcome-voucher') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/welcome-voucher/receive-welcome-voucher')}}" class="nav-link ">
									<span class="title">[Response] Welcome Voucher</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([120,122], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'welcome-voucher-autoresponse-create-welcome-voucher') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/welcome-voucher/create-welcome-voucher')}}" class="nav-link ">
									<span class="title">[Forward] Create Welcome Voucher</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'welcome-voucher-autoresponse-update-welcome-voucher') ? 'active open' : ''}}">
								<a href="{{url('autoresponse/welcome-voucher/update-welcome-voucher')}}" class="nav-link ">
									<span class="title">[Forward] Update Welcome Voucher</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([72], $grantedFeature))
			<li class="nav-item {{($menu_active == 'deals-transaction') ? 'active open' : ''}}">
				<a href="{{url('deals/transaction')}}" class="nav-link nav-toggle">
					<i class="fa fa-bar-chart"></i>
					<span class="title">Deals Transaction</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([93], $configs))
				@if(MyHelper::hasAccess([200,201,202,203,204], $grantedFeature))
				<li class="nav-item {{($menu_active == 'promo-campaign') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-tag"></i>
						<span class="title">Promo Campaign</span>
						<span class="arrow {{($menu_active == 'promo-campaign') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([202], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promo-campaign-create') ? 'active open' : ''}}">
							<a href="{{url('promo-campaign/create')}}" class="nav-link ">
								<span class="title">New Promo Campaign</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([200], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promo-campaign-list') ? 'active open' : ''}}">
							<a href="{{url('promo-campaign')}}" class="nav-link ">
								<span class="title">Promo Campaign List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([120,122], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promo-campaign-autoresponse-create-promo-campaign') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/promo-campaign/create-promo-campaign')}}" class="nav-link ">
								<span class="title">[Forward] Create Promo Campaign</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'promo-campaign-autoresponse-update-promo-campaign') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/promo-campaign/update-promo-campaign')}}" class="nav-link ">
								<span class="title">[Forward] Update Promo Campaign</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif
			@if(MyHelper::hasAccess([233], $grantedFeature))
			<li class="nav-item {{($menu_active == 'promo-cashback-setting') ? 'active open' : ''}}">
				<a href="{{url('promo-setting/cashback')}}" class="nav-link nav-toggle">
					<i class="fa fa-money"></i>
					<span class="title">Promo Cashback Setting</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([115], $configs))
				@if(MyHelper::hasAccess([216], $grantedFeature))
				<li class="nav-item {{($menu_active == 'referral') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-user-plus"></i>
						<span class="title">Referral</span>
						<span class="arrow {{($menu_active == 'referral') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([216], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'referral-setting') ? 'active open' : ''}}">
							<a href="{{url('referral/setting')}}" class="nav-link ">
								<span class="title">Referral Setting</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([216], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'referral-report') ? 'active open' : ''}}">
							<a href="{{url('referral/report')}}" class="nav-link ">
								<span class="title">Referral Report</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([73], $configs))
				@if(MyHelper::hasAccess([130,131,132,133,134], $grantedFeature))
				<li class="nav-item {{($menu_active == 'reward') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-trophy"></i>
						<span class="title">Reward</span>
						<span class="arrow {{($menu_active == 'reward') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([132], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'reward-create') ? 'active open' : ''}}">
							<a href="{{url('reward/create')}}" class="nav-link ">
								<span class="title">New Reward</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([130,131,133,134], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'reward-list') ? 'active open' : ''}}">
							<a href="{{url('reward')}}" class="nav-link ">
								<span class="title">Reward List</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([76], $configs))
				@if(MyHelper::hasAccess([130,131,134], $grantedFeature))
				<li class="nav-item {{($menu_active == 'spinthewheel') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-circle-o-notch"></i>
						<span class="title">Spin The Wheel</span>
						<span class="arrow {{($menu_active == 'spinthewheel') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([131], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-new') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/create')}}" class="nav-link ">
								<span class="title">New Item</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([130], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-list') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/list')}}" class="nav-link ">
								<span class="title">Item List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([134], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'spinthewheel-setting') ? 'active open' : ''}}">
							<a href="{{url('spinthewheel/setting')}}" class="nav-link ">
								<span class="title">Setting</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([84], $configs))
				@if(MyHelper::hasAccess([172,173,174,175,176], $grantedFeature))
				<li class="nav-item {{($menu_active == 'subscription') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-gift"></i>
						<span class="title">Subscription</span>
						<span class="arrow {{($menu_active == 'subscription') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([172], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'subscription-create') ? 'active open' : ''}}">
							<a href="{{url('subscription/create')}}" class="nav-link ">
								<span class="title">New Subscription</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([173], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'subscription-list') ? 'active open' : ''}}">
							<a href="{{url('subscription')}}" class="nav-link ">
								<span class="title">Subscription List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([173], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'subscription-claim-report') ? 'active open' : ''}}">
							<a href="{{url('subscription/claim-report')}}" class="nav-link ">
								<span class="title">Subscription Claim Report</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'subscription-transaction-report') ? 'active open' : ''}}">
							<a href="{{url('subscription/transaction-report')}}" class="nav-link ">
								<span class="title">Subscription Transaction Report</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'subscription-list-export') ? 'active open' : ''}}">
							<a href="{{url('subscription/list-export')}}" class="nav-link ">
								<span class="title">List Export</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([113], $configs))
							@if(MyHelper::hasAccess([97], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'subscription-autoresponse-get-free-subscription-success') ? 'active open' : ''}}">
									<a href="{{url('transaction/autoresponse/get-free-subscription-success')}}" class="nav-link ">
										<i class="fa fa-mail-forward"></i>
										<span class="title">[Response] Get Free Subscription Success</span>
									</a>
								</li>
								<li class="nav-item {{($submenu_active == 'subscription-autoresponse-buy-paid-subscription-success') ? 'active open' : ''}}">
									<a href="{{url('transaction/autoresponse/buy-paid-subscription-success')}}" class="nav-link ">
										<i class="fa fa-mail-forward"></i>
										<span class="title">[Response] Buy Paid Subscription Success</span>
									</a>
								</li>
								<li class="nav-item {{($submenu_active == 'subscription-autoresponse-Buy-point-subscription-success') ? 'active open' : ''}}">
									<a href="{{url('transaction/autoresponse/buy-point-subscription-success')}}" class="nav-link ">
										<i class="fa fa-mail-forward"></i>
										<span class="title">[Response] Buy Point Subscription Success</span>
									</a>
								</li>
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([264,265,266,267,268], $grantedFeature))
				<li class="nav-item {{($menu_active == 'welcome-subscription') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-ticket"></i>
						<span class="title">Welcome Subscription</span>
						<span class="arrow {{($menu_active == 'welcome-subscription') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([266], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'welcome-subscription-create') ? 'active open' : ''}}">
								<a href="{{url('welcome-subscription/create')}}" class="nav-link ">
									<span class="title">New Welcome Subscription</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([264], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'welcome-subscription-list') ? 'active open' : ''}}">
								<a href="{{url('welcome-subscription')}}" class="nav-link ">
									<span class="title">Welcome Subscription List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([264,267], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'welcome-subscription-setting') ? 'active open' : ''}}">
								<a href="{{url('welcome-subscription/setting')}}" class="nav-link ">
									<span class="title">Welcome Subscription Setting</span>
								</a>
							</li>
						@endif
                        @if(MyHelper::hasAccess([178], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'welcome-subscription-autoresponse-receive-welcome-subscription') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/welcome-subscription/receive-welcome-subscription')}}" class="nav-link ">
								<span class="title">[Response] Receive Welcome Subscription</span>
							</a>
						</li>
                        @endif
						@if(MyHelper::hasAccess([120,122], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'welcome-subscription-autoresponse-create-welcome-subscription') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/welcome-subscription/create-welcome-subscription')}}" class="nav-link ">
								<span class="title">[Forward] Create Welcome Subscription</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'welcome-subscription-autoresponse-update-welcome-subscription') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/welcome-subscription/update-welcome-subscription')}}" class="nav-link ">
								<span class="title">[Forward] Update Welcome Subscription</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
			@endif

			@if(MyHelper::hasAccess([99], $configs))
				@if(MyHelper::hasAccess([221,222,223,224,225,226], $grantedFeature))
				<li class="nav-item {{($menu_active == 'achievement') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-trophy"></i>
						<span class="title">Achievement</span>
						<span class="arrow {{($menu_active == 'achievement') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([223], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'achievement-create') ? 'active open' : ''}}">
							<a href="{{url('achievement/create')}}" class="nav-link ">
								<span class="title">New Achievement</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([221], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'achievement-list') ? 'active open' : ''}}">
							<a href="{{url('achievement')}}" class="nav-link ">
								<span class="title">Achievement List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([226], $grantedFeature))
							<li class="nav-item {{(strpos($submenu_active , 'achievement-report') !== false) ? 'active open' : ''}}">
								<a href="javascript:;" class="nav-link nav-toggle">
									<span class="title">Report Achievement</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item {{($submenu_active == 'achievement-report') ? 'active open' : ''}}">
										<a href="{{url('achievement/report')}}" class="nav-link ">
											<span class="title">Achievement</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'achievement-report-user') ? 'active open' : ''}}">
										<a href="{{url('achievement/report/user-achievement')}}" class="nav-link ">
											<span class="title">User Achievement</span>
										</a>
									</li>
									<li class="nav-item {{($submenu_active == 'achievement-report-membership') ? 'active open' : ''}}">
										<a href="{{url('achievement/report/membership')}}" class="nav-link ">
											<span class="title">Membership Achievement</span>
										</a>
									</li>
								</ul>
							</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([100], $configs))
				@if(MyHelper::hasAccess([227,228,229,230,231,232,306,307,308,309,310], $grantedFeature))
				<li class="nav-item {{($menu_active == 'quest') ? 'active open' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-bullseye"></i>
						<span class="title">Quest</span>
						<span class="arrow {{($menu_active == 'quest') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([306,307,308,309,310], $grantedFeature))
							<li class="nav-item {{(strpos($submenu_active , 'quest-voucher') !== false) &&  $submenu_active != 'quest-autoresponse-receive-quest-voucher'? 'active open' : ''}}">
								<a href="javascript:;" class="nav-link nav-toggle">
									<span class="title">Quest Voucher</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									@if(MyHelper::hasAccess([308], $grantedFeature))
										<li class="nav-item {{(isset($child_active) && $child_active == 'quest-voucher-create') ? 'active open' : ''}}">
											<a href="{{url('quest-voucher/create')}}" class="nav-link ">
												<span class="title">New Quest Voucher</span>
											</a>
										</li>
									@endif
									@if(MyHelper::hasAccess([306], $grantedFeature))
										<li class="nav-item {{(isset($child_active) && $child_active == 'quest-voucher-list') ? 'active open' : ''}}">
											<a href="{{url('quest-voucher')}}" class="nav-link ">
												<span class="title">Quest Voucher List</span>
											</a>
										</li>
									@endif
									@if(MyHelper::hasAccess([120,122], $grantedFeature))
										<li class="nav-item {{(isset($child_active) && $child_active == 'quest-voucher-autoresponse-create-quest-voucher') ? 'active open' : ''}}">
											<a href="{{url('autoresponse/quest-voucher/create-quest-voucher')}}" class="nav-link ">
												<span class="title">[Forward] Create Quest Voucher</span>
											</a>
										</li>
											<li class="nav-item {{(isset($child_active) && $child_active == 'quest-voucher-autoresponse-update-quest-voucher') ? 'active open' : ''}}">
											<a href="{{url('autoresponse/quest-voucher/update-quest-voucher')}}" class="nav-link ">
												<span class="title">[Forward] Update Quest Voucher</span>
											</a>
										</li>
									@endif
								</ul>
							</li>
						@endif
						@if(MyHelper::hasAccess([229], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'quest-create') ? 'active open' : ''}}">
							<a href="{{url('quest/create')}}" class="nav-link ">
								<span class="title">New Quest</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([227], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'quest-list') ? 'active open' : ''}}">
							<a href="{{url('quest')}}" class="nav-link ">
								<span class="title">Quest List</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([232], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'quest-report') ? 'active open' : ''}}">
							<a href="{{url('quest/report')}}" class="nav-link ">
								<span class="title">Report Quest</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([122], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'quest-autoresponse-quest-completed') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/quest/quest-completed')}}" class="nav-link ">
								<span class="title">[Response] Quest Completed</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'quest-autoresponse-receive-quest-point') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/quest/receive-quest-point')}}" class="nav-link ">
								<span class="title">[Response] Receive Quest Point</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'quest-autoresponse-receive-quest-voucher') ? 'active open' : ''}}">
							<a href="{{url('autoresponse/quest/receive-quest-voucher')}}" class="nav-link ">
								<span class="title">[Response] Receive Quest Voucher</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif
			@if(MyHelper::hasAccess([311,312,313,314,315], $grantedFeature))
				<li class="nav-item {{($menu_active == 'disburse-promo-pg') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-tag"></i>
						<span class="title">Rule Promo Payment Gateway</span>
						<span class="arrow {{($menu_active == 'disburse-promo-pg') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([313], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'disburse-promo-pg-new') ? 'active open' : ''}}">
								<a href="{{url('disburse/rule-promo-payment-gateway/create')}}" class="nav-link ">
									<span class="title">New Promo Payment Gateway</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([311,312,314,315], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'disburse-promo-pg-list') ? 'active open' : ''}}">
								<a href="{{url('disburse/rule-promo-payment-gateway')}}" class="nav-link ">
									<span class="title">Promo Payment Gateway List</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'disburse-promo-pg-list-trx') ? 'active open' : ''}}">
								<a href="{{url('disburse/rule-promo-payment-gateway/list-trx')}}" class="nav-link ">
									<span class="title">Promo Payment Gateway List Transaction</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'disburse-promo-pg-validation') ? 'active open' : ''}}">
								<a href="{{url('disburse/rule-promo-payment-gateway/validation')}}" class="nav-link ">
									<span class="title">Promo Payment Gateway Validation</span>
								</a>
							</li>
							<li class="nav-item {{($submenu_active == 'disburse-promo-pg-validation-report') ? 'active open' : ''}}">
								<a href="{{url('disburse/rule-promo-payment-gateway/validation/report')}}" class="nav-link ">
									<span class="title">Promo Payment Gateway Validation Report</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
			@endif

		@if(MyHelper::hasAccess([83,96,97,98,100,103,104,105,106,107,108,109,111], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">CRM</h3>
			</li>

			@if(MyHelper::hasAccess([96,97], $grantedFeature))
			<li class="nav-item {{($menu_active == 'crm-setting') ? 'active' : ''}}">
				<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
					<i class="icon-settings"></i>
					<span class="title">CRM Setting</span>
					<span class="arrow {{($menu_active == 'crm-setting') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([96], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'textreplace') ? 'active' : ''}}">
						<a href="{{url('textreplace')}}" class="nav-link nav-toggle">
							<span class="title">Text Replace</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([97], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'email') ? 'active' : ''}}">
						<a href="{{url('email-header-footer')}}" class="nav-link nav-toggle">
							<span class="title">Email Header & Footer</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([74,75], $configs))
					<li class="nav-item {{($submenu_active == 'whatsapp') ? 'active' : ''}}">
						<a href="{{url('setting/whatsapp')}}" class="nav-link nav-toggle">
							<span class="title">WhatsApp Setting</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(MyHelper::hasAccess([58], $configs) || MyHelper::hasAccess([59], $configs) || MyHelper::hasAccess([60], $configs))
				@if(MyHelper::hasAccess([83], $grantedFeature))
				<li class="nav-item {{($menu_active == 'enquiries') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-action-undo"></i>
						<span class="title">Enquiries</span>
						<span class="arrow {{($menu_active == 'enquiries') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'enquiries-list') ? 'active open' : ''}}">
							<a href="{{url('enquiries')}}" class="nav-link">
								<span class="title">Enquiry List</span>
							</a>
						</li>
						@if(MyHelper::hasAccess([40], $configs))
							@if(MyHelper::hasAccess([94], $grantedFeature))
								@if(MyHelper::hasAccess([46], $configs))
								<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-kritik,-saran-&-keluhan') ? 'active open' : ''}}">
									<a href="{{url('about/autoresponse/enquiry-kritik,-saran-&-keluhan')}}" class="nav-link ">
										<span class="title">[Response] Kritik, Saran & Keluhan</span>
									</a>
								</li>
								@endif
								@if(MyHelper::hasAccess([47], $configs))
									<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-pengubahan-data-diri') ? 'active open' : ''}}">
										<a href="{{url('about/autoresponse/enquiry-pengubahan-data-diri')}}" class="nav-link ">
											<span class="title">[Response] Pengubahan Data Diri</span>
										</a>
									</li>
								@endif
								@if(MyHelper::hasAccess([48], $configs))
									<li class="nav-item {{($submenu_active == 'autoresponse-enquiry-lain-_-lain') ? 'active open' : ''}}">
										<a href="{{url('about/autoresponse/enquiry-lain-_-lain')}}" class="nav-link ">
											<span class="title">[Response] Lain - Lain</span>
										</a>
									</li>
								@endif
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif
			@if(MyHelper::hasAccess([90], $configs) && MyHelper::hasAccess([179,212], $grantedFeature) )
				<li class="nav-item {{($menu_active == 'user-feedback') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-thumbs-o-up"></i>
						<span class="title">User Feedback</span>
						<span class="arrow {{($menu_active == 'user-feedback') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([179], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'user-feedback-list') ? 'active open' : ''}}">
								<a href="{{url('user-feedback')}}" class="nav-link ">
									<span class="title">User Feedback List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([212], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'feedback-setting') ? 'active open' : ''}}">
								<a href="{{url('user-feedback/setting')}}" class="nav-link ">
									<span class="title">User Feedback Setting</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([179], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'user-feedback-report') ? 'active open' : ''}}">
								<a href="{{url('user-feedback/report')}}" class="nav-link ">
									<span class="title">Report User Feedback</span>
								</a>
							</li>
						@endif
						<li class="nav-item {{($submenu_active == 'user-feedback-response') ? 'active open' : ''}}">
							<a href="{{url('user-feedback/autoresponse')}}" class="nav-link ">
								<span class="title">[Response] User Feedback</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
			@if(MyHelper::hasAccess([50], $configs))
				@if(MyHelper::hasAccess([98,100,103,104,105,106,107,108], $grantedFeature))
				<li class="nav-item {{($menu_active == 'campaign') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-speech"></i>
						<span class="title"> Single Campaign</span>
						<span class="arrow {{($menu_active == 'campaign') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([100], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'campaign-create') ? 'active open' : ''}}">
							<a href="{{url('campaign/create')}}" class="nav-link ">
								<span class="title">New Campaign</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([98], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'campaign-list') ? 'active open' : ''}}">
								<a href="{{url('campaign')}}" class="nav-link ">
									<span class="title">Campaign List</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([51], $configs))
							@if(MyHelper::hasAccess([104], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-email-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/email/outbox')}}" class="nav-link ">
										<span class="title">Email Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([52], $configs))
							@if(MyHelper::hasAccess([106], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-sms-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/sms/outbox')}}" class="nav-link ">
										<span class="title">SMS Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([53], $configs))
							@if(MyHelper::hasAccess([108], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-push-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/push/outbox')}}" class="nav-link ">
										<span class="title">Push Outbox</span>
									</a>
								</li>
							@endif
						@endif
						@if(MyHelper::hasAccess([75], $configs))
							@if(MyHelper::hasAccess([108], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-whatsapp-outbox') ? 'active open' : ''}}">
									<a href="{{url('campaign/whatsapp/outbox')}}" class="nav-link ">
										<span class="title">WhatsApp Outbox</span>
									</a>
								</li>
							@endif
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([72], $configs))
				@if(MyHelper::hasAccess([109,110,111,112,113], $grantedFeature))
				<li class="nav-item {{($menu_active == 'promotion') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-emoticon-smile"></i>
						<span class="title">Promotion</span>
						<span class="arrow {{($menu_active == 'promotion') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([111], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'new-deals-promotion') ? 'active open' : ''}}">
							<a href="{{url('promotion/deals/create')}}" class="nav-link ">
								<span class="title">New Deals Promotion</span>
							</a>
						</li>
						@endif
						<li class="nav-item {{($submenu_active == 'deals-promotion') ? 'active open' : ''}}">
							<a href="{{url('promotion/deals')}}" class="nav-link ">
								<span class="title">Deals Promotion</span>
							</a>
						</li>
						@if(MyHelper::hasAccess([111], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'promotion-create') ? 'active open' : ''}}">
							<a href="{{url('promotion/create')}}" class="nav-link ">
								<span class="title">New Promotion</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([109], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'promotion-list') ? 'active open' : ''}}">
								<a href="{{url('promotion')}}" class="nav-link ">
									<span class="title">Promotion List</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([205,206,207,208,209], $grantedFeature))
			<li class="nav-item {{($menu_active == 'point-injection') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-diamond"></i>
					<span class="title">Point Injection</span>
					<span class="arrow {{($menu_active == 'point-injection') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([207], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'point-injection-create') ? 'active open' : ''}}">
							<a href="{{url('point-injection/create')}}" class="nav-link ">
								<span class="title">New Point Injection</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([205,206,208,209], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'point-injection-create') ? 'active open' : ''}}">
							<a href="{{url('point-injection')}}" class="nav-link ">
								<span class="title">List Point Injection</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
			@endif

			@if(MyHelper::hasAccess([114,115,116,117,118], $grantedFeature))
				<li class="nav-item {{($menu_active == 'inboxglobal') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-feed"></i>
						<span class="title">Inbox Global</span>
						<span class="arrow {{($menu_active == 'inboxglobal') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([116], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inboxglobal-create') ? 'active' : ''}}">
								<a href="{{url('inboxglobal/create')}}" class="nav-link ">
									<span class="title">New Inbox Global</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([114], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'inboxglobal-list') ? 'active' : ''}}">
								<a href="{{url('inboxglobal')}}" class="nav-link ">
									<span class="title">Inbox Global List</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
			@endif

			@if(MyHelper::hasAccess([119], $configs))
				<li class="nav-item {{($menu_active == 'redirect-complex') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-external-link"></i>
						<span class="title">Redirect Complex</span>
						<span class="arrow {{($menu_active == 'redirect-complex') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'redirect-complex-create') ? 'active' : ''}}">
							<a href="{{url('redirect-complex/create')}}" class="nav-link ">
								<span class="title">New Redirect Complex</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'redirect-complex-list') ? 'active' : ''}}">
							<a href="{{url('redirect-complex')}}" class="nav-link ">
								<span class="title">Redirect Complex List</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
			<!-- @if(MyHelper::hasAccess([55], $configs))
				@if(MyHelper::hasAccess([119,120,121,122,123], $grantedFeature))
				<li class="nav-item {{($menu_active == 'autocrm') ? 'active' : ''}}">
					<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
						<i class="icon-ghost"></i>
						<span class="title">Auto CRM</span>
						<span class="arrow {{($menu_active == 'autocrm') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([121], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'autocrm-new') ? 'active' : ''}}">
							<a href="{{url('autocrm/create')}}" class="nav-link nav-toggle">
								<span class="title">New Auto CRM</span>
							</a>
						</li>
						@endif
						@if(MyHelper::hasAccess([119], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'autocrm-list') ? 'active' : ''}}">
							<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
								<span class="title">Auto CRM List</span>
							</a>
						</li>
						@endif
					</ul>
				</li>
				@endif
			@endif -->

		@endif

        @if(MyHelper::hasAccess([15,16,17,18,144,145,146,147,148,273,241], $grantedFeature))
            <li class="heading" style="height: 50px;padding: 25px 15px 10px;">
                <h3 class="uppercase" style="color: #000;font-weight: 600;">Settings</h3>
            </li>
        @endif
		@if(MyHelper::hasAccess([15,16,17,18,144,145,146,147,148,241], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-home') ? 'active' : ''}}">
				<a href="{{url('setting/home')}}" class="nav-link">
					<i class="icon-screen-tablet "></i>
					<span class="title">Mobile Apps Home</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([273], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-outlet-apps') ? 'active' : ''}}">
				<a href="{{url('setting/outletapp')}}" class="nav-link">
					<i class="fa fa-tablet"></i>
					<span class="title">Setting Outlet Apps</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([346], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-mitra-apps') ? 'active' : ''}}">
				<a href="{{url('setting/mitra-apps')}}" class="nav-link">
					<i class="fa fa-tablet"></i>
					<span class="title">Setting Mitra Apps</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([94], $configs))
		@if(MyHelper::hasAccess([210], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-phone') ? 'active' : ''}}">
				<a href="{{url('setting/phone')}}" class="nav-link">
					<i class="fa fa-phone"></i>
					<span class="title">Setting Phone Number</span>
				</a>
			</li>
		@endif
		@endif

		@if(MyHelper::hasAccess([160], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-text-menu') ? 'active' : ''}}">
				<a href="{{url('setting/text_menu')}}" class="nav-link">
					<i class="fa fa-bars"></i>
					<span class="title">Text Menu</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([33], $configs))
		@if (!empty($advert))
			@if(MyHelper::hasAccess([124], $grantedFeature))
			<li class="nav-item {{($menu_active == 'advert') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-newspaper-o"></i>
					<span class="title">Page Advertisement</span>
					<span class="arrow {{($menu_active == 'advert') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@foreach ($advert as $val)
					<li class="nav-item {{($submenu_active == $val ) ? 'active open' : ''}}">
						<a href="{{url('advert')}}/{{ $val }}" class="nav-link ">
							<span class="title">{{ ucwords(str_replace('-', ' ', $val)) }}</span>
						</a>
					</li>
					@endforeach
				</ul>
			</li>
			@endif
		@endif
		@endif

		@if(MyHelper::hasAccess([192,193,194,195,196,214,215,217,218,219], $grantedFeature))
			<li class="nav-item {{($menu_active == 'fraud-detection') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-exclamation"></i>
					<span class="title">Fraud Detection</span>
					<span class="arrow {{($menu_active == 'fraud-detection') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([192], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'fraud-detection-update') ? 'active open' : ''}}">
							<a href="{{url('setting-fraud-detection')}}" class="nav-link ">
								<span class="title">Fraud Detection Settings</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([193], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-device') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/device')}}" class="nav-link ">
								<span class="title">Report Fraud Device</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([214], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-point') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-point')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Point</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([194], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-day') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-day')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Day</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([195], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-week') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-week')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction Week</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([215], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-transaction-between') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/transaction-between')}}" class="nav-link ">
								<span class="title">Report Fraud Transaction in Between</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([115], $configs))
						@if(MyHelper::hasAccess([217], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'report-fraud-referral-user') ? 'active open' : ''}}">
								<a href="{{url('fraud-detection/report/referral-user')}}" class="nav-link ">
									<span class="title">Report Fraud Referral User</span>
								</a>
							</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([218], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-referral') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/referral')}}" class="nav-link ">
								<span class="title">Report Fraud Referral</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([219], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'report-fraud-promo-code') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/report/promo-code')}}" class="nav-link ">
								<span class="title">Report Fraud Promo Code</span>
							</a>
						</li>
					@endif
					@if(MyHelper::hasAccess([196], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'suspend-user') ? 'active open' : ''}}">
							<a href="{{url('fraud-detection/suspend-user')}}" class="nav-link ">
								<span class="title">List User Fraud</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
		@endif

		@if($level == "Super Admin")
		<li class="nav-item {{($menu_active == 'setting-version') ? 'active' : ''}}">
			<a href="{{url('version')}}" class="nav-link">
				<i class="fa fa-info-circle"></i>
				<span class="title">Version Control</span>
			</a>
		</li>
		@endif

		@if(MyHelper::hasAccess([149,150,151,152,153], $grantedFeature))
		<li class="nav-item {{($menu_active == 'custom-page') ? 'active open' : ''}}">
			<a href="javascript:;" class="nav-link nav-toggle">
				<i class="icon-book-open"></i>
				<span class="title">Custom Page</span>
				<span class="arrow {{($menu_active == 'custom-page') ? 'open' : ''}}"></span>
			</a>
			<ul class="sub-menu">
				@if(MyHelper::hasAccess([150], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'custom-page-create') ? 'active open' : ''}}">
					<a href="{{url('custom-page/create')}}" class="nav-link ">
						<span class="title">New Custom Page</span>
					</a>
				</li>
				@endif
				@if(MyHelper::hasAccess([149,151,152,153], $grantedFeature))
				<li class="nav-item {{($submenu_active == 'custom-page-list') ? 'active open' : ''}}">
					<a href="{{url('custom-page')}}" class="nav-link ">
						<span class="title">Custom Page List</span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		@endif
		@if(MyHelper::hasAccess([108], $configs))
			@if(MyHelper::hasAccess([168,169,170,171], $grantedFeature))
			<li class="nav-item {{($menu_active == 'setting-intro') ? 'active open' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-screen-tablet"></i>
					<span class="title">Intro Apps</span>
					<span class="arrow {{($menu_active == 'setting-intro') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([150], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'setting-intro-first') ? 'active open' : ''}}">
						<a href="{{url('setting/intro/first')}}" class="nav-link ">
							<span class="title">Intro First Install</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([149,151,152,153], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'setting-intro-home') ? 'active open' : ''}}">
						<a href="{{url('setting/intro/home')}}" class="nav-link ">
							<span class="title">Tutorial In Home</span>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([162,163], $grantedFeature))
		<li class="nav-item {{($menu_active == 'confirmation-messages') ? 'active' : ''}}">
			<a href="{{url('setting/confirmation-messages')}}" class="nav-link">
				<i class="icon-speech"></i>
				<span class="title">Confirmation Messages</span>
			</a>
		</li>
		@endif

		@if(MyHelper::hasAccess([220], $grantedFeature))
			<li class="nav-item {{($menu_active == 'maintenance-mode') ? 'active' : ''}}">
				<a href="{{url('setting/maintenance-mode')}}" class="nav-link">
					<i class="icon-wrench"></i>
					<span class="title">Maintenance Mode</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([251,252], $grantedFeature))
			<li class="nav-item {{($menu_active == 'time-expired') ? 'active' : ''}}">
				<a href="{{url('setting/time-expired')}}" class="nav-link">
					<i class="fa fa-envelope"></i>
					<span class="title">Time Expired OTP and Email</span>
				</a>
			</li>
			<li class="nav-item {{($submenu_active == 'setting-popup-messages') ? 'active open' : ''}}">
				<a href="{{url('setting/otp-messages')}}" class="nav-link ">
					<i class="fa fa-envelope"></i>
					<span class="title">OTP Message</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([85,86,87,88,89,154], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">About</h3>
			</li>

			@if(MyHelper::hasAccess([85], $grantedFeature))
			<li class="nav-item {{($menu_active == 'about') ? 'active' : ''}}">
				<a href="{{url('setting/about')}}" class="nav-link nav-toggle">
					<i class="icon-info"></i>
					<span class="title">About Us</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([88,89], $grantedFeature))
			<li class="nav-item {{($menu_active == 'faq') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-question"></i>
					<span class="title">FAQ</span>
					<span class="arrow {{($menu_active == 'faq') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([89], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'faq-new') ? 'active open' : ''}}">
						<a href="{{url('setting/faq/create')}}" class="nav-link ">
							<span class="title">New FAQ</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([88], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'faq-list') ? 'active open' : ''}}">
						<a href="{{url('setting/faq')}}" class="nav-link ">
							<span class="title">List FAQ</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([88], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'faq-sort') ? 'active open' : ''}}">
							<a href="{{url('setting/faq/sort')}}" class="nav-link ">
								<span class="title">Sorting FAQ List</span>
							</a>
						</li>
					@endif
				</ul>
			</li>
			@endif
			@if(MyHelper::hasAccess([86], $grantedFeature))
			<li class="nav-item {{($menu_active == 'tos') ? 'active' : ''}}">
				<a href="{{url('setting/tos')}}" class="nav-link nav-toggle">
					<i class="icon-note"></i>
					<span class="title">Ketentuan Layanan</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([96], $configs))
			@if(MyHelper::hasAccess([154], $grantedFeature))
			<li class="nav-item {{($menu_active == 'delivery-service') ? 'active' : ''}}">
				<a href="{{url('delivery-service')}}" class="nav-link nav-toggle">
					<i class="icon-social-dropbox"></i>
					<span class="title">Delivery Services</span>
				</a>
			</li>
			@endif
			@endif
			<!-- @if(MyHelper::hasAccess([87], $grantedFeature))
			<li class="nav-item {{($menu_active == 'contact') ? 'active' : ''}}">
				<a href="{{url('setting/contact')}}" class="nav-link nav-toggle">
					<i class="icon-call-in"></i>
					<span class="title">Contact Us</span>
				</a>
			</li>
			@endif -->
		@endif

		@if(MyHelper::hasAccess([234], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Disburse</h3>
			</li>

			<li class="nav-item {{($menu_active == 'disburse-dashboard') ? 'active' : ''}}">
				<a href="{{url('disburse/dashboard')}}" class="nav-link nav-toggle">
					<i class="fa fa-th"></i>
					<span class="title">Dashboard</span>
				</a>
			</li>

			<li class="nav-item {{($menu_active == 'disburse-list-all') ? 'active' : ''}}">
				<a href="{{url('disburse/list/all')}}" class="nav-link nav-toggle">
					<i class="fa fa-list"></i>
					<span class="title">List All </span>
				</a>
			</li>

			<li class="nav-item {{($menu_active == 'disburse-list-success') ? 'active' : ''}}">
				<a href="{{url('disburse/list/success')}}" class="nav-link nav-toggle">
					<i class="fa fa-list"></i>
					<span class="title">List Success</span>
				</a>
			</li>

			@if(MyHelper::hasAccess([235], $grantedFeature))
				<li class="nav-item {{($menu_active == 'disburse-list-fail-action') ? 'active' : ''}}">
					<a href="{{url('disburse/list/fail-action')}}" class="nav-link nav-toggle">
						<i class="fa fa-list"></i>
						<span class="title">List Fail</span>
					</a>
				</li>
			@else
				<li class="nav-item {{($menu_active == 'disburse-list-fail') ? 'active' : ''}}">
					<a href="{{url('disburse/list/fail')}}" class="nav-link nav-toggle">
						<i class="fa fa-list"></i>
						<span class="title">List Fail</span>
					</a>
				</li>
			@endif

			<li class="nav-item {{($menu_active == 'disburse-list-trx') ? 'active' : ''}}">
				<a href="{{url('disburse/list/trx')}}" class="nav-link nav-toggle">
					<i class="fa fa-list"></i>
					<span class="title">List Transaction Online</span>
				</a>
			</li>

			@if(MyHelper::hasAccess([235], $grantedFeature))
				<li class="nav-item {{($menu_active == 'disburse-settings') ? 'active' : ''}}">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-sliders"></i>
						<span class="title">Settings</span>
						<span class="arrow {{($menu_active == 'disburse-settings') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item {{($submenu_active == 'autoresponse-failed-send-disburse') ? 'active open' : ''}}">
							<a href="{{url('disburse/autoresponse/failed-send-disburse')}}" class="nav-link ">
								<span class="title">[Response] Failed Send Disburse</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'disburse-setting-add-bank-account') ? 'active open' : ''}}">
							<a href="{{url('disburse/setting/bank-account')}}" class="nav-link ">
								<span class="title">Add Bank Account</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'disburse-setting-edit-bank-account') ? 'active open' : ''}}">
							<a href="{{url('disburse/setting/edit-bank-account')}}" class="nav-link ">
								<span class="title">Edit Bank Account</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'disburse-setting-mdr') ? 'active open' : ''}}">
							<a href="{{url('disburse/setting/mdr')}}" class="nav-link ">
								<span class="title">MDR</span>
							</a>
						</li>
						<li class="nav-item {{($submenu_active == 'disburse-setting-global') ? 'active open' : ''}}">
							<a href="{{url('disburse/setting/global')}}" class="nav-link ">
								<span class="title">Global Setting</span>
							</a>
						</li>
					</ul>
				</li>
			@endif
		@endif
		@if(MyHelper::hasAccess([125,126,127,128,129,271], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #000;font-weight: 600;">Report</h3>
			</li>
			<li class="nav-item {{($menu_active == 'report-single') ? 'active' : ''}}">
				<a href="{{url('report')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Report</span>
				</a>
			</li>
			<li class="nav-item {{($menu_active == 'report-compare') ? 'active' : ''}}">
				<a href="{{url('report/compare')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Compare Report</span>
				</a>
			</li> 
			@if(MyHelper::hasAccess([125], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-global') ? 'active' : ''}}">
				<a href="{{url('report/global')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Global</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([126], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-customer') ? 'active' : ''}}">
				<a href="{{url('report/customer/summary')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Customer</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([127], $grantedFeature))
			<li class="nav-item {{($menu_active == 'report-product') ? 'active' : ''}}">
				<a href="{{url('report/product')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Product</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([128], $grantedFeature))
			<li class="nav-item {{($submenu_active == 'report-outlet') ? 'active' : ''}}">
				<a href="{{url('report/outlet')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Outlet</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([271], $grantedFeature))
			<li class="nav-item {{($submenu_active == 'report-shift') ? 'active' : ''}}">
				<a href="{{url('report/shift/summary')}}" class="nav-link nav-toggle">
					<i class="icon-graph"></i>
					<span class="title">Shift</span>
				</a>
			</li>
			@endif
		@endif

		{{-- @if(MyHelper::hasAccess([129], $grantedFeature))
		<li class="nav-item {{($menu_active == 'report-magic') ? 'active' : ''}}">
			<a href="{{url('report/magic')}}" class="nav-link nav-toggle">
				<i class="icon-graph"></i>
				<span class="title">Magic Report</span>
			</a>
		</li>
		@endif --}}
