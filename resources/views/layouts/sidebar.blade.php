<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');

    (session('advert')) ? $advert = session('advert') : $advert = null;

 ?>
		<li class="sidebar-toggler-wrapper hide">
			<div class="sidebar-toggler">
				<span></span>
			</div>
		</li>
		<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
			<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Home</h3>
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
				<span class="title">Setting Home</span>
			</a>
		</li>

		@if(MyHelper::hasAccess([2,4,7,9], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Accounts</h3>
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
							@endif
							@if(MyHelper::hasAccess([42], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-verify') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-verify')}}" class="nav-link ">
										<span class="title">[Response] Pin Verified</span>
									</a>
								</li>
							@endif
							@if(MyHelper::hasAccess([43], $configs))
								<li class="nav-item {{($submenu_active == 'user-autoresponse-pin-changed') ? 'active open' : ''}}">
									<a href="{{url('user/autoresponse/pin-changed')}}" class="nav-link ">
										<span class="title">[Response] Pin Changed</span>
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
						@endif
					@endif
				</ul>
			</li>
			
			@if(MyHelper::hasAccess([5], $configs))
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

		@if(MyHelper::hasAccess([20], $configs))
			@if(MyHelper::hasAccess([10,12], $grantedFeature))
			<li class="nav-item {{($menu_active == 'membership') ? 'active' : ''}}">
				<a href="{{url('membership')}}" class="nav-link">
					<i class="icon-badge"></i>
					<span class="title">Membership</span>
				</a>
			</li>
			@endif
		@endif

		<li class="nav-item {{($menu_active == 'expired-qrcode') ? 'active' : ''}}">
			<a href="{{url('setting/qrcode_expired')}}" class="nav-link">
				<i class="fa fa-qrcode"></i>
				<span class="title">Setting Expired QR Code</span>
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

		@if(MyHelper::hasAccess([19], $configs))
			@if(MyHelper::hasAccess([78], $configs))
			<li class="nav-item {{($menu_active == 'balance-reset') ? 'active' : ''}}">
				<a href="{{url('setting/balance_reset')}}" class="nav-link">
					<i class="fa fa-refresh"></i>
					<span class="title">Setting Kopi Point Reset</span>
				</a>
			</li>
			@endif
		@endif

		@if(MyHelper::hasAccess([19,21,24,26,32,33,34,43,45,48,50,56,57], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Browse</h3>
			</li>
			@if(MyHelper::hasAccess([34], $configs))
				@if(MyHelper::hasAccess([19,21], $grantedFeature))
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
					</ul>
				</li>
				@endif
			@endif

			@if(MyHelper::hasAccess([24,26,32,33,34], $grantedFeature))
			<li class="nav-item {{($menu_active == 'outlet') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="icon-pointer"></i>
					<span class="title">Outlet</span>
					<span class="arrow {{($menu_active == 'outlet') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([26], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-new') ? 'active open' : ''}}">
						<a href="{{url('outlet/create')}}" class="nav-link ">
							<span class="title">New Outlet</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([2], $configs) || MyHelper::hasAccess([3], $configs))
						@if(MyHelper::hasAccess([32, 33], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-import') ? 'active open' : ''}}">
							<a href="{{url('outlet/import')}}" class="nav-link ">
								<span class="title">Export & Import Outlet</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-list') ? 'active open' : ''}}">
						<a href="{{url('outlet/list')}}" class="nav-link ">
							<span class="title">Outlet List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([24], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'outlet-qrcode') ? 'active open' : ''}}">
						<a href="{{url('outlet/qrcode')}}" class="nav-link ">
							<span class="title">QRCode Outlet</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([4], $configs))
						@if(MyHelper::hasAccess([34], $grantedFeature))
						<li class="nav-item {{($submenu_active == 'outlet-holiday') ? 'active open' : ''}}">
							<a href="{{url('outlet/holiday')}}" class="nav-link ">
								<span class="title">Outlet Holiday Setting</span>
							</a>
						</li>
						@endif
					@endif
				</ul>
			</li>
			@endif
			
			@if(MyHelper::hasAccess([43,45,48,50,56,57], $grantedFeature))
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
					<li class="nav-item {{($submenu_active == 'product-tag-list') ? 'active open' : ''}}">
						<a href="{{url('product/tag')}}" class="nav-link ">
							<span class="title">Tag List</span>
						</a>
					</li>
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
						<li class="nav-item {{($submenu_active == 'product-import') ? 'active open' : ''}}">
							<a href="{{url('product/import')}}" class="nav-link ">
								<span class="title">Export & Import Product</span>
							</a>
						</li>
						@endif
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list') ? 'active open' : ''}}">
						<a href="{{url('product')}}" class="nav-link ">
							<span class="title">Product List</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-visible') ? 'active open' : ''}}">
						<a href="{{url('product/visible')}}" class="nav-link ">
							<span class="title">Product List Visible</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([48], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'product-list-hidden') ? 'active open' : ''}}">
						<a href="{{url('product/hidden')}}" class="nav-link ">
							<span class="title">Product List Hidden</span>
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
				</ul>
			</li>
			@endif
			
			
		@endif
		
		@if(MyHelper::hasAccess([58,59,60,61,62,63,64,66,69,71], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Order</h3>
			</li>
			
			@if(MyHelper::hasAccess([69], $grantedFeature))
			<li class="nav-item {{($menu_active == 'transaction') ? 'active' : ''}}">
				<a href="javascript:;" class="nav-link nav-toggle">
					<i class="fa fa-shopping-cart"></i>
					<span class="title">Product Transaction</span>
					<span class="arrow {{($menu_active == 'transaction') ? 'open' : ''}}"></span>
				</a>
				<ul class="sub-menu">
					@if(MyHelper::hasAccess([13], $configs)) 
					<li class="nav-item {{($submenu_active == 'transaction-delivery') ? 'active open' : ''}}">
						<a href="{{url('transaction/delivery/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Delivery</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'transaction-offline') ? 'active open' : ''}}">
						<a href="{{url('transaction/offline/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Offline</span>
						</a>
					</li>
					@if(MyHelper::hasAccess([12], $configs)) 
					<li class="nav-item {{($submenu_active == 'transaction-pickup order') ? 'active open' : ''}}">
						<a href="{{url('transaction/pickup order/'.date('YmdHis'))}}" class="nav-link ">
							<span class="title">Pickup Order</span>
						</a>
					</li>
					@endif
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-transaction-success') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/transaction-success')}}" class="nav-link ">
							<span class="title">[Response] Transaction Success</span>
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
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-ready') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-taken')}}" class="nav-link ">
							<span class="title">[Response] Order Taken</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-order-reject') ? 'active open' : ''}}">
						<a href="{{url('transaction/autoresponse/order-reject')}}" class="nav-link ">
							<span class="title">[Response] Order Rejected</span>
						</a>
					</li>
					<li class="nav-item {{($submenu_active == 'transaction-autoresponse-topup-success') ? 'active open' : ''}}">
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
					</li>
				</ul>
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
						<span class="title">Kopi Point Log History</span>
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
					@if(MyHelper::hasAccess([58], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-processing') ? 'active open' : ''}}">
						<a href="{{url('setting/processing_time')}}" class="nav-link ">
							<span class="title">Processing Time</span>
						</a>
					</li>
					@endif
					@if(MyHelper::hasAccess([58,59,60,62], $grantedFeature))
					<li class="nav-item {{($submenu_active == 'transaction-setting') ? 'active open' : ''}}">
						<a href="{{url('transaction/setting/cashback')}}" class="nav-link ">
							<span class="title">Setting Cashback</span>
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
		@endif

		@if(MyHelper::hasAccess([25], $configs) || MyHelper::hasAccess([26], $configs))
			@if(MyHelper::hasAccess([72,73,74,75,76,77,78,79,80,81,95], $grantedFeature))
				<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
					<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Promo</h3>
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
							@if(MyHelper::hasAccess([49], $configs))
								@if(MyHelper::hasAccess([95], $grantedFeature))
									<li class="nav-item {{($submenu_active == 'user-autoresponse-deals') ? 'active open' : ''}}">
										<a href="{{url('user/autoresponse/deals')}}" class="nav-link ">
											<span class="title">Auto Response Deals</span>
										</a>
									</li>
								@endif
							@endif
						</ul>
					</li>
					@endif
				@endif


				@if(MyHelper::hasAccess([139,140,141,142,143], $grantedFeature))
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
				@endif
				

				@if(MyHelper::hasAccess([26], $configs))
					@if(MyHelper::hasAccess([77,78,79,80,81], $grantedFeature))
					<li class="nav-item {{($menu_active == 'hidden-deals') ? 'active open' : ''}}">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-birthday-cake"></i>
							<span class="title">Hidden Deals</span>
							<span class="arrow {{($menu_active == 'hidden-deals') ? 'open' : ''}}"></span>
						</a>
						<ul class="sub-menu">
							@if(MyHelper::hasAccess([79], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'hidden-deals-create') ? 'active open' : ''}}">
								<a href="{{url('hidden-deals/create')}}" class="nav-link ">
									<span class="title">New Hidden Deals</span>
								</a>
							</li>
							@endif
							@if(MyHelper::hasAccess([77], $grantedFeature))
							<li class="nav-item {{($submenu_active == 'hidden-deals-list') ? 'active open' : ''}}">
								<a href="{{url('hidden-deals')}}" class="nav-link ">
									<span class="title">Hidden Deals List</span>
								</a>
							</li>
							@endif
						</ul>
					</li>
					@endif
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
		@endif
		
		@if(MyHelper::hasAccess([85,86,87,88,89,90,91,94], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">About</h3>
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
				</ul>
			</li>
			@endif
			@if(MyHelper::hasAccess([86], $grantedFeature))
			<li class="nav-item {{($menu_active == 'tos') ? 'active' : ''}}">
				<a href="{{url('setting/tos')}}" class="nav-link nav-toggle">
					<i class="icon-note"></i>
					<span class="title">TOS</span>
				</a>
			</li>
			@endif
			@if(MyHelper::hasAccess([87], $grantedFeature))
			<li class="nav-item {{($menu_active == 'contact') ? 'active' : ''}}">
				<a href="{{url('setting/contact')}}" class="nav-link nav-toggle">
					<i class="icon-call-in"></i>
					<span class="title">Contact Us</span>
				</a>
			</li>
			@endif

			@if(MyHelper::hasAccess([40], $configs))
				@if(MyHelper::hasAccess([94], $grantedFeature))
				<li class="nav-item {{($menu_active == 'about-autoresponse') ? 'active' : ''}}">
					<a href="{{url('autocrm')}}" class="nav-link nav-toggle">
						<i class="icon-action-undo"></i>
						<span class="title">Auto Response</span>
						<span class="arrow {{($menu_active == 'autocrm') ? 'open' : ''}}"></span>
					</a>
					<ul class="sub-menu">
						@if(MyHelper::hasAccess([46], $configs))
							<li class="nav-item {{($submenu_active == 'about-autoresponse-enquiry-question') ? 'active open' : ''}}">
								<a href="{{url('about/autoresponse/enquiry-question')}}" class="nav-link ">
									<span class="title">Enquiry Question</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([47], $configs))
							<li class="nav-item {{($submenu_active == 'about-autoresponse-enquiry-partnership') ? 'active open' : ''}}">
								<a href="{{url('about/autoresponse/enquiry-partnership')}}" class="nav-link ">
									<span class="title">Enquiry Partnership</span>
								</a>
							</li>
						@endif
						@if(MyHelper::hasAccess([48], $configs))
							<li class="nav-item {{($submenu_active == 'about-autoresponse-enquiry-complaint') ? 'active open' : ''}}">
								<a href="{{url('about/autoresponse/enquiry-complaint')}}" class="nav-link ">
									<span class="title">Enquiry Complaint</span>
								</a>
							</li>
						@endif
					</ul>
				</li>
				@endif
			@endif
		@endif
		
		@if(MyHelper::hasAccess([83,96,97,98,100,103,104,105,106,107,108,109,111], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">CRM</h3>
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
					<a href="{{url('enquiries')}}" class="nav-link nav-toggle">
						<i class="icon-envelope-open "></i>
						<span class="title">Enquiries</span>
					</a>
				</li>
				@endif
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
							@if(MyHelper::hasAccess([103], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-email-queue') ? 'active open' : ''}}">
									<a href="{{url('campaign/email/queue')}}" class="nav-link ">
										<span class="title">Email Queue</span>
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
							@if(MyHelper::hasAccess([105], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-sms-queue') ? 'active open' : ''}}">
									<a href="{{url('campaign/sms/queue')}}" class="nav-link ">
										<span class="title">SMS Queue</span>
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
							@if(MyHelper::hasAccess([107], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-push-queue') ? 'active open' : ''}}">
									<a href="{{url('campaign/push/queue')}}" class="nav-link ">
										<span class="title">Push Queue</span>
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
							@if(MyHelper::hasAccess([107], $grantedFeature))
								<li class="nav-item {{($submenu_active == 'campaign-whatsapp-queue') ? 'active open' : ''}}">
									<a href="{{url('campaign/whatsapp/queue')}}" class="nav-link ">
										<span class="title">WhatsApp Queue</span>
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
									   
			@if(MyHelper::hasAccess([55], $configs))
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
			@endif

		@endif
		
		@if(MyHelper::hasAccess([15,16,17,18,144,145,146,147,148], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Settings</h3>
			</li>
			<li class="nav-item {{($menu_active == 'setting-home') ? 'active' : ''}}">
				<a href="{{url('setting/home')}}" class="nav-link">
					<i class="icon-screen-tablet "></i>
					<span class="title">Mobile Apps Home</span>
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

		@if(MyHelper::hasAccess([124], $grantedFeature))
			<li class="nav-item {{($menu_active == 'fraud-detection') ? 'active' : ''}}">
				<a href="{{url('setting-fraud-detection')}}" class="nav-link">
					<i class="fa fa-exclamation"></i>
					<span class="title">Fraud Detection</span>
				</a>
			</li>
		@endif

		@if(MyHelper::hasAccess([125,126,127,128,129], $grantedFeature))
			<li class="heading" style="height: 50px;padding: 25px 15px 10px;">
				<h3 class="uppercase" style="color: #5C9ACF;font-weight: 600;">Report</h3>
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
		@endif

		@if(MyHelper::hasAccess([129], $grantedFeature))
		<li class="nav-item {{($menu_active == 'report-magic') ? 'active' : ''}}">
			<a href="{{url('report/magic')}}" class="nav-link nav-toggle">
				<i class="icon-graph"></i>
				<span class="title">Magic Report</span>
			</a>
		</li>
		@endif

	</ul>
	<!-- END SIDEBAR MENU -->
	<!-- END SIDEBAR MENU -->
<!-- END SIDEBAR -->