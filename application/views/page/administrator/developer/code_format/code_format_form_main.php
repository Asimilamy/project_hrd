<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>

<div class="form-group">
	<label class="col-sm-2 control-label">Code Format : </label>
</div>

<?php
if (!empty($code_format_parts)) :
	$no = 0;
	foreach($code_format_parts as $row) :
		$no++;
		$btn = $no == 1?'plus':'minus';
		echo render_form_codeformat($row->code_part, $row->code_unique, $row->code_separator, $btn);
	endforeach;
else :
	echo render_form_codeformat('', '', '', 'plus');
endif;
