		<!-- footer content -->
		<footer>
			<div class="pull-right">
				Template by <a href="https://colorlib.com">Colorlib</a>
				<?php
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