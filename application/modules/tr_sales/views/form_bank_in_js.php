<script type="text/javascript">
jQuery(document).ready(function() {
	$('.chosen-select').chosen({
		width: '100%',
		allow_single_deselect: true
	});
	$('#tanggal').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	
	$('.input-numeric').autoNumeric('init');
	$('#rp').autoNumeric('set','0');
	$('#datatable').dataTable({
		"bServerSide":true,
		"bProcessing":true,
		"sPaginationType": "full_numbers",
		"bFilter":true,
		"sServerMethod": "POST",
		"sAjaxSource": "<?=base_url()?>index.php/bank-in/DT",
	});
	$('body').on('click', '.row-data', function() {
		
		if(confirm('Merubah data ini?')) {
			$('#idbank').val($(this).attr('data-id'));
			$('#tanggal').val($(this).attr('data-tanggal'));
			//$('#kode_nasabah option[value="'+$(this).attr('data-kdns')+'"]').attr('selected',true);
			//$('#kode_bank option[value="'+$(this).attr('data-kdbank')+'"]').attr('selected',true);
			$('#kode_nasabah').val($(this).attr('data-kdns')).trigger('chosen:updated');
			$('#kode_bank').val($(this).attr('data-kdbank')).trigger('chosen:updated');
			$('#keterangan').val($(this).attr('data-ket'));
			$('#rp').val($(this).attr('data-rp'));
			
			if($(this).attr('data-tr') == "BM")
				$("#jenis1").attr('checked', 'checked');
			else
				$("#jenis2").attr('checked', 'checked');
			$('#btnsimpan').hide();
			$('#btnupdate').show();
		}
	});
	$('#btn-submit-pay').click(function() {
		$(this).addClass('disabled');
		sErr = '';
		if($('#kode_nasabah').val()==='') {
			sErr += "\n- Debitor Harus Di isi";
		}
		if($('#tanggal').val()==='') {
			sErr += "\n- Tanggal Harus Di isi";
		}
		if($('#kode_bank').val()==='') {
			sErr += "\n- Bank Harus Di isi";
		}
		if(parseFloat($('#rp').autoNumeric('get'))<1) {
			sErr += "\n- Nominal Bayar harus lebih dari 0 (nol)!";
		}
		if(sErr==='') {
			$.post(
				'<?=base_url()?>index.php/bank-in/save',
				$('#form-bank-in').serialize(),
				function(respon) {
					if(respon!=='') {
						alert('Data berhasil disimpan!');
						location.href = '<?=base_url() ?>index.php/bank-in';
					}
				}
			);
		} else {
			alert("Terjadi kesalahan, mohon diperiksa: "+sErr);
		}
		$(this).removeClass('disabled');
	});
	$('#btn-update-pay').click(function() {
		$(this).addClass('disabled');
		sErr = '';
		if($('#kode_nasabah').val()==='') {
			sErr += "\n- Debitor Harus Di isi";
		}
		if($('#tanggal').val()==='') {
			sErr += "\n- Tanggal Harus Di isi";
		}
		if($('#kode_bank').val()==='') {
			sErr += "\n- Bank Harus Di isi";
		}
		if(parseFloat($('#rp').autoNumeric('get'))<1) {
			sErr += "\n- Nominal Bayar harus lebih dari 0 (nol)!";
		}
		if(sErr==='') {
			$.post(
				'<?=base_url()?>index.php/bank-in/update',
				$('#form-bank-in').serialize(),
				function(respon) {
					if(respon!=='') {
						alert('Data berhasil diupdate!');
						location.href = '<?=base_url() ?>index.php/bank-in';
					}
				}
			);
		} else {
			alert("Terjadi kesalahan, mohon diperiksa: "+sErr);
		}
		$(this).removeClass('disabled');
	});
});
</script>