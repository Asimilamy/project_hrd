<?php
defined('BASEPATH') or exit('No direct script access allowed!');
if (ENVIRONMENT == 'development') :
	$this->m_menu->register_session($_SESSION['user']['master_type_kd']);
endif;
?>

<div class="container body">
	<div class="main_container">
		<div class="col-md-3 left_col">
			<div class="left_col scroll-view">
				<div class="navbar nav_title" style="border: 0;">
					<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
				</div>

				<div class="clearfix"></div>

				<!-- menu profile quick info -->
				<div class="profile clearfix">
					<div class="profile_pic">
						<img src="<?php echo base_url().'assets/admin_assets/'; ?>images/img.jpg" alt="..." class="img-circle profile_img">
					</div>
					<div class="profile_info">
						<span>Welcome,</span>
						<h2>John Doe</h2>
					</div>
					<div class="clearfix"></div>
				</div>
				<!-- /menu profile quick info -->

				<br />

				<!-- sidebar menu -->
				<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					<div class="menu_section">
						<h3>Test Menu</h3>
						<ul class="nav side-menu">
							<?php
							$user_menu = '';
							if (isset($_SESSION['user']['menus']['one'])) :
								foreach ($_SESSION['user']['menus']['one'] as $menu) :
									$kd_menus[] = $menu->kd_menu;
									if ($menu->menu_link == '#') :
										$user_menu .= open_parent_menu($menu->menu_title, $menu->menu_icon, $menu->menu_nm, 'parent');
										if (isset($_SESSION['user']['menus']['two'])) :
											foreach ($_SESSION['user']['menus']['two'] as $submenu) :
												if ($submenu->menu_parent == $menu->kd_menu) :
													if ($submenu->menu_link == '#') :
														$user_menu .= open_parent_menu($submenu->menu_title, '', $submenu->menu_nm, 'child');
														if (isset($_SESSION['user']['menus']['three'])) :
															foreach ($_SESSION['user']['menus']['three'] as $subsubmenu) :
																if ($subsubmenu->menu_parent == $submenu->kd_menu) :
																	$user_menu .= render_child_menu($menu->menu_modul.'/'.url_title($menu->menu_title, '_', TRUE).'/'.url_title($submenu->menu_title, '_', TRUE).'/'.$subsubmenu->menu_link, $subsubmenu->menu_title, $subsubmenu->menu_nm);
																endif;
															endforeach;
														endif;
														$user_menu .= close_parent_menu();
													else :
														$user_menu .= render_child_menu($menu->menu_modul.'/'.url_title($menu->menu_title, '_', TRUE).'/'.$submenu->menu_link, $submenu->menu_title, $submenu->menu_nm);
													endif;
												endif;
											endforeach;
										endif;
										$user_menu .= close_parent_menu();
									else :
										$user_menu .= render_individual_menu($menu->menu_modul.'/'.$menu->menu_link, $menu->menu_title, $menu->menu_icon, $menu->menu_nm);
									endif;
								endforeach;
							endif;

							echo $user_menu;
							?>
						</ul>
					</div>
				</div>
				<!-- /sidebar menu -->

				<!-- /menu footer buttons -->
				<div class="sidebar-footer hidden-small">
					<a data-toggle="tooltip" data-placement="top" title="Settings">
						<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="FullScreen">
						<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Lock">
						<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
					</a>
					<a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url('administrator/auth/logout'); ?>">
						<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					</a>
				</div>
				<!-- /menu footer buttons -->
			</div>
		</div>