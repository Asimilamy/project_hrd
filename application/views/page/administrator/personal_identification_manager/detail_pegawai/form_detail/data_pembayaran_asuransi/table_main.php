<?php
defined('BASEPATH') or exit('No direct script access allowed!');
$data['class_link'] = $class_link;
$data['page_name'] = $page_name;
?>
<style type="text/css">
	td.dt-center { text-align: center; }
	td.dt-right { text-align: right; }
	td.dt-left { text-align: left; }
</style>

<div class="row" style="margin-bottom: 15px;">
	<div class="col-xs-2">
		<button type="button" name="btnAsuransi" id="idBtnAsuransi" class="btn btn-warning btn-flat pull-left btn-back-asuransi" title="Kembali ke Data Asuransi">
			<i class="fa fa-arrow-left"></i> Kembali
		</button>
	</div>
	<div class="col-xs-8"></div>
	<div class="col-xs-2">
		<button type="button" name="btnAdd" id="idBtnAdd" class="btn btn-primary btn-flat pull-right btn-add-asuransi-pembayaran" title="Tambah Data Pembayaran Asuransi">
			<i class="fa fa-plus"></i> Tambah Data
		</button>
	</div>
</div>
<table id="idTable" class="table table-striped table-bordered" style="width:100%;">
	<thead>
	<tr>
		<th style="width:1%; text-align:center;" class="all">No.</th>
		<th style="width:4%; text-align:center;" class="all">Opsi</th>
		<th style="width:1%; text-align:center;">Kode</th>
		<th style="width:40%; text-align:left;">Nama Asuransi</th>
		<th style="width:10%; text-align:left;">Penanggung Jawab</th>
		<th style="width:25%; text-align:left;">Nomer Asuransi</th>
		<th style="width:10%; text-align:left;">Tanggal Bayar</th>
		<th style="width:9%; text-align:left;">Jumlah Bayar</th>
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
		"searching": false,
		"ajax": {
			"url": "<?php echo base_url($class_link).'/table_detail_data'; ?>",
			"data": {"page_name" : "<?php echo $page_name; ?>"}
		},
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
			{"searchable": false, "orderable": false, "className": "dt-center", "targets": 1},
			{"searchable": false, "visible": false, "targets": 2},
		],
		"order":[2, 'desc'],
		"rowCallback": function (row, data, iDisplayIndex) {
			var info = this.fnPagingInfo();
			var page = info.iPage;
			var length = info.iLength;
			var index = page * length + (iDisplayIndex + 1);
			$('td:eq(0)', row).html(index);
		}
	});
</script>
