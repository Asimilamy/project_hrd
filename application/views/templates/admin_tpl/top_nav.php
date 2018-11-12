<?php
$default_user_img = $this->m_setting->get_setting('default_user_img');
?>

<!-- top navigation -->
<div class="top_nav">
	<div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<?php
						if (!empty($_SESSION['user']['user_img']) && file_exists('assets/admin_assets/images/users/'.$_SESSION['user']['user_img'])) :
							?>
							<img src="<?php echo base_url('assets/admin_assets/images/users/'.$_SESSION['user']['user_img']); ?>" alt="<?php echo $_SESSION['user']['user_name']; ?>">
							<?php
						else :
							?>
							<img src="<?php echo base_url('assets/admin_assets/images/settings/'.$default_user_img); ?>" alt="<?php echo $_SESSION['user']['user_name']; ?>">
							<?php
						endif;
						?>
						<?php echo $_SESSION['user']['user_name']; ?>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu pull-right">
						<li>
							<a href="javascript:;"> Profile</a>
						</li>
						<!-- <li>
							<a href="javascript:;">
								<span class="badge bg-red pull-right">50%</span>
								<span>Settings</span>
							</a>
						</li>
						<li><a href="javascript:;">Help</a></li> -->
						<li><a href="<?php echo base_url('administrator/auth/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					</ul>
				</li>

				<!-- <li role="presentation" class="dropdown">
					<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-envelope-o"></i>
						<span class="badge bg-green">6</span>
					</a>
					<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
						<li>
							<a>
								<span class="image"><img src="<?php echo base_url().'assets/admin_assets/'; ?>images/img.jpg" alt="Profile Image" /></span>
								<span>
									<span>John Smith</span>
									<span class="time">3 mins ago</span>
								</span>
								<span class="message">
									Film festivals used to be do-or-die moments for movie makers. They were where...
								</span>
							</a>
						</li>
						<li>
							<a>
								<span class="image"><img src="<?php echo base_url().'assets/admin_assets/'; ?>images/img.jpg" alt="Profile Image" /></span>
								<span>
									<span>John Smith</span>
									<span class="time">3 mins ago</span>
								</span>
								<span class="message">
									Film festivals used to be do-or-die moments for movie makers. They were where...
								</span>
							</a>
						</li>
						<li>
							<a>
								<span class="image"><img src="<?php echo base_url().'assets/admin_assets/'; ?>images/img.jpg" alt="Profile Image" /></span>
								<span>
									<span>John Smith</span>
									<span class="time">3 mins ago</span>
								</span>
								<span class="message">
									Film festivals used to be do-or-die moments for movie makers. They were where...
								</span>
							</a>
						</li>
						<li>
							<a>
								<span class="image"><img src="<?php echo base_url().'assets/admin_assets/'; ?>images/img.jpg" alt="Profile Image" /></span>
								<span>
									<span>John Smith</span>
									<span class="time">3 mins ago</span>
								</span>
								<span class="message">
									Film festivals used to be do-or-die moments for movie makers. They were where...
								</span>
							</a>
						</li>
						<li>
							<div class="text-center">
								<a>
									<strong>See All Alerts</strong>
									<i class="fa fa-angle-right"></i>
								</a>
							</div>
						</li>
					</ul>
				</li> -->
			</ul>
		</nav>
	</div>
</div>
<!-- /top navigation -->