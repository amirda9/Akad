<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<!-- Brand Logo -->
		<a href="{{ route('panel.dashboard') }}" class="brand-link">
			<img src="{{ getImageSrc(getOption('site_information.favicon','images/admin-logo.png')) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
			<span class="brand-text font-weight-light">
					{{ getOption('site_information.website_name',config('settings.website_name')) }}
			</span>
		</a>

		<!-- Sidebar -->
		<div class="sidebar do-nicescroll">

			<!-- Sidebar Menu -->
			<nav class="mt-2">
				<ul class="nav d-block nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					<li class="nav-item">
						<a href="{{ route('panel.dashboard') }}" class="nav-link {{ checkActive(['panel.dashboard']) ? 'active' : '' }}">
							<i class="nav-icon fad fa-tachometer-alt"></i>
							<p>پیشخوان</p>
						</a>
					</li>


					@can('view users')
						<li class="nav-item">
							<a href="{{ route('panel.users.index') }}" class="nav-link {{ checkActive([
									'panel/users*',
									]) ? 'active' : '' }}">
								<i class="nav-icon fad fa-users"></i>
								<p>مدیریت کاربران</p>
							</a>
						</li>
					@endcan

					@can('view permissions')
					<li class="nav-item">
						<a href="{{ route('panel.roles.index') }}" class="nav-link {{ checkActive([
								'panel/roles*',
								'panel/permission*',
								]) ? 'active' : '' }}">
							<i class="nav-icon fad fa-shield-alt"></i>
							<p>مدیریت دسترسی ها</p>
						</a>
					</li>
					@endcan


					@can('view pages')
					<li class="nav-item">
						<a href="{{ route('panel.pages.index') }}" class="nav-link {{ checkActive([
								'panel/pages*',
								]) ? 'active' : '' }}">
							<i class="nav-icon fad fa-file"></i>
							<p>مدیریت صفحات ثابت</p>
						</a>
					</li>
					@endcan

                    @canany(['view rates','view comments'])
                        <li class="nav-item has-treeview {{ checkActive([
									'panel/rates',
									'panel/rates/*',
									'panel/comments',
									'panel/comments/*',
									]) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ checkActive([
                                        'panel/rates',
                                        'panel/rates/*',
                                        'panel/comments',
                                        'panel/comments/*',
									]) ? 'active' : '' }}">
                                <i class="nav-icon fad fa-box"></i>
                                <p>
                                    نظرات و امتیازها
                                    <i class="left fad fa-angle-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview p-0">
                                @canany(['view rates'])
                                    <li class="nav-item">
                                        <a class="nav-link {{ checkActive([
									'panel/rates',
									'panel/rates/*',
									]) ? 'active' : '' }}" href="{{ route('panel.rates.index') }}">
                                            <i class="nav-icon fad fa-star fa-fw"></i>
                                            امتیازها
                                        </a>
                                    </li>
                                @endcan
                                @canany(['view comments'])
                                    <li class="nav-item">
                                        <a class="nav-link {{ checkActive([
									'panel/comments',
									'panel/comments/*',
									]) ? 'active' : '' }}" href="{{ route('panel.comments.index') }}">
                                            <i class="nav-icon fad fa-comments fa-fw"></i>
                                            نظرات
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

					<li class="my-2 border-top border-gray-700" />

					@canany(['view articles','view article categories'])
						<li class="nav-item has-treeview {{ checkActive([
									'panel/posts/*'
									]) ? 'menu-open' : '' }}">
							<a href="#" class="nav-link {{ checkActive([
										'panel/posts/*'
									]) ? 'active' : '' }}">
								<i class="nav-icon fad fa-box"></i>
								<p>
									مدیریت مقالات
									<i class="left fad fa-angle-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview p-0">
								<li class="nav-item">
									<a class="nav-link {{ checkActive([
									'panel/posts/articles',
									'panel/posts/articles/*',
									]) ? 'active' : '' }}" href="{{ route('panel.posts.articles.index') }}">
										<i class="nav-icon fad fa-fw"></i>
										مقالات
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link {{ checkActive([
									'panel/posts/categories',
									'panel/posts/categories/*',
									]) ? 'active' : '' }}" href="{{ route('panel.posts.categories.index') }}">
										<i class="nav-icon fad fa-fw"></i>
										دسته بندی ها
									</a>
								</li>

							</ul>
						</li>
					@endcan

                    <li class="my-2 border-top border-gray-700" />

                    @can('view orders')
                        <li class="nav-item">
                            <a href="{{ route('panel.orders.index') }}" class="nav-link {{ checkActive([
								'panel/orders*',
								]) ? 'active' : '' }}">
                                <i class="nav-icon fad fa-shopping-basket"></i>
                                <p>مدیریت سفارشات</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('panel.reports.index') }}" class="nav-link {{ checkActive([
								'panel/reports*',
								]) ? 'active' : '' }}">
                                <i class="nav-icon fad fa-chart-area"></i>
                                <p>گزارشات</p>
                            </a>
                        </li>
                    @endcan

                    @canany(['view products','view product categories','view brands','view attributes'])
                        <li class="nav-item has-treeview {{ checkActive([
									'panel/product*',
									'panel/brands*',
									'panel/attribute*',
									'panel/tags*',
									'panel/coupons*',
									'panel/couponLimit',
									]) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ checkActive([
									'panel/product*',
									'panel/brands*',
									'panel/attribute*',
									'panel/tags*',
									'panel/coupons*',
									'panel/couponLimit*',
									]) ? 'active' : '' }}">
                                <i class="nav-icon fad fa-box"></i>
                                <p>
                                    مدیریت محصولات
                                    <i class="left fad fa-angle-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview p-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/products*',
									]) ? 'active' : '' }}" href="{{ route('panel.products.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        محصولات
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/productCategories*',
									]) ? 'active' : '' }}" href="{{ route('panel.productCategories.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        دسته بندی ها
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/brands*',
									]) ? 'active' : '' }}" href="{{ route('panel.brands.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        برند ها
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/coupons*',
									'panel/couponLimit*',
									]) ? 'active' : '' }}" href="{{ route('panel.coupons.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        کوپن تخفیف
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/attribute*',
									]) ? 'active' : '' }}" href="{{ route('panel.attributeGroups.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        ویژگی ها
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ checkActive([
									'panel/tags*',
									]) ? 'active' : '' }}" href="{{ route('panel.tags.index') }}">
                                        <i class="nav-icon fad fa-fw"></i>
                                        برچسب ها
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    <li class="my-2 border-top border-gray-700" />

					@can('view slides')
					<li class="nav-item">
						<a href="{{ route('panel.slides.index') }}" class="nav-link {{ checkActive([
								'panel/slides*',
								]) ? 'active' : '' }}">
							<i class="nav-icon fad fa-image"></i>
							<p>مدیریت اسلایدها</p>
						</a>
					</li>
					@endcan

					@can('view menus')
					<li class="nav-item">
						<a href="{{ route('panel.menus.index') }}" class="nav-link {{ checkActive([
								'panel/menus*',
								]) ? 'active' : '' }}">
							<i class="nav-icon fad fa-compass"></i>
							<p>مدیریت منوها</p>
						</a>
					</li>
					@endcan

					@can('view file manager')
					<li class="nav-item">
						<a href="{{ route('unisharp.lfm.show') }}" target="_blank" class="nav-link {{ checkActive([
								'unisharp.lfm.show',
								]) ? 'active' : '' }}">
							<i class="nav-icon fad fa-folder-open"></i>
							<p>مدیریت فایل ها</p>
						</a>
					</li>
					@endcan

					@can('view contacts')
						<li class="nav-item">
							<a href="{{ route('panel.contacts.index') }}" class="nav-link {{ checkActive([
									'panel.contacts.index',
									'panel.contacts.show',
									]) ? 'active' : '' }}">
								<i class="nav-icon fad fa-envelope"></i>
								<p>مدیریت تماس ها</p>
							</a>
						</li>
					@endcan

					@can('view options')
						<li class="nav-item has-treeview {{ checkActive([
									'panel.options.index',
									'panel.widgets.index',
									]) ? 'menu-open' : '' }}">
							<a href="#" class="nav-link {{ checkActive([
									'panel.options.index',
									'panel.widgets.index',
									]) ? 'active' : '' }}">
								<i class="nav-icon fad fa-cogs"></i>
								<p>
									تنظیمات
									<i class="left fad fa-angle-right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview p-0">
								<li class="nav-item">
									<a class="nav-link {{ checkActive([
									'panel.options.index',
									]) ? 'active' : '' }}" href="{{ route('panel.options.index') }}">
										<i class="nav-icon fad fa-circle-notch"></i>
										عمومی
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link {{ checkActive([
									'panel.widgets.index',
									]) ? 'active' : '' }}" href="{{ route('panel.widgets.index') }}">
										<i class="nav-icon fad fa-circle-notch"></i>
										ابزارک ها
									</a>
								</li>
							</ul>
						</li>
					@endcan



				</ul>
			</nav>
			<!-- /.sidebar-menu -->
		</div>
		<!-- /.sidebar -->
	</aside>
