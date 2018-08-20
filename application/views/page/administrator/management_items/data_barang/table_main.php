<?php
defined('BASEPATH') or exit('No direct script access allowed!');
?>
<style type="text/css">
	td.dt-center { text-align: center; }
	td.dt-right { text-align: right; }
	td.dt-left { text-align: left; }
</style>

<table id="idTable" class="table table-striped table-bordered" style="width:100%;">
	<thead>
	<tr>
		<th style="width:1%; text-align:center;" class="all">No.</th>
		<th style="width:4%; text-align:center;" class="all">Opsi</th>
		<th style="width:5%; text-align:center;">Barcode</th>
		<th style="width:15%; text-align:left;">Nama Barang</th>
		<th style="width:75%; text-align:left;">Deskripsi</th>
	</tr>
	</thead>
</table>

<script type="text/javascript">
	$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
		return {
			"iStart": oSettings._iDisplayStart,
			"iEnd": oSettings.fnDisplayEnd(),
			"iLength": oSettings._iDisplayLength,
			"iTotal": oSettings.fnRecordsTotal(),
			"iFilteredTotal": oSettings.fnRecordsDisplay(),
			"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
			"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
		};
	};
	var table = $('#idTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ordering" : true,
		"ajax": "<?php echo base_url($class_link).'/table_data'; ?>",
		"language" : {
			"lengthMenu" : "Tampilkan _MENU_ data",
			"zeroRecords" : "Maaf tidak ada data yang ditampilkan",
			"info" : "Menampilkan data _START_ sampai _END_ dari _TOTAL_ data",
			"infoFiltered": "",
			"infoEmpty" : "Tidak ada data yang ditampilkan",
			"search" : "Cari :",
			"loadingRecords": "Memuat Data...",
			"processing":     "Sedang Memproses...",
			"paginate": {
				"first":      '<span class="glyphicon glyphicon-fast-backward"></span>',
				"last":       '<span class="glyphicon glyphicon-fast-forward"></span>',
				"next":       '<span class="glyphicon glyphicon-forward"></span>',
				"previous":   '<span class="glyphicon glyphicon-backward"></span>'
			}
		},
		"columnDefs": [
			{"data": null, "searchable": false, "orderable": false, "className": "dt-center", "targets": 0},
			{"searchable": false, "orderable": false, "targets": 1},
			{"className": "dt-center", "targets": 2},
		],
		"order":[2, 'asc'],
		"rowCallback": function (row, data, iDisplayIndex) {
			var info = this.fnPagingInfo();
			var page = info.iPage;
			var length = info.iLength;
			var index = page * length + (iDisplayIndex + 1);
			$('td:eq(0)', row).html(index);
		}
	});
</script>