		<?php
		$app_title = $this->m_setting->get_setting('app_title');
		?>
		<!-- footer content -->
		<footer>
			<div class="pull-right">
				<a href="<?php echo base_url(); ?>"><?php echo $app_title; ?></a>
				<?php
				echo ' - CV. Ali Insan Jaya - V '.$_SERVER['APP_VERSION'];
				if (ENVIRONMENT == 'development') {
					echo '<center"> | Page rendered in <strong>' . $this->benchmark->elapsed_time() .'</strong></center>';
				}
				?>
			</div>
			<div class="clearfix"></div>
		</footer>
		<!-- /footer content -->
	</div>
</div>