<script type="text/javascript">
jQuery(document).ready(function() {
	// init component / plugin
	$('#tgl_lahir').datetimepicker({
		pickTime: false,
		format: 'DD/MM/YYYY'
	});
	// init value
	<?php if(isset($data['id'])) { ?>
	$('#id').val('<?=$data['id']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#alamat_ktp').val('<?=$data['alamat_ktp']?>');
	$('#alamat_domisili').val('<?=$data['alamat_domisili']?>');
	$('#no_ktp').val('<?=$data['no_ktp']?>');
	$('#no_kk').val('<?=$data['no_kk']?>');
	$('#tempat_lahir').val('<?=$data['tempat_lahir']?>');
	$('#tgl_lahir').val('<?=$data['tgl_lahir']?>');
	$('#email').val('<?=$data['email']?>');
	$('#kodepos').val('<?=$data['kodepos']?>');
	$('#telp').val('<?=$data['telp']?>');
	$('#hp').val('<?=$data['hp']?>');
	$('#fax').val('<?=$data['fax']?>');
	$('#nama_perusahaan').val('<?=$data['nama_perusahaan']?>');
	$('#alamat_perusahaan').val('<?=$data['alamat_perusahaan']?>');
	$('#kota_perusahaan').val('<?=$data['kota_perusahaan']?>');
	$('#kodepos_perusahaan').val('<?=$data['kodepos_perusahaan']?>');
	$('#telp_perusahaan').val('<?=$data['telp_perusahaan']?>');
	$('#fax_perusahaan').val('<?=$data['fax_perusahaan']?>');
	$('#jenis_pekerjaan').val('<?=$data['jenis_pekerjaan']?>');
	$('#status_pekerjaan').val('<?=$data['status_pekerjaan']?>');
	$('#lama_bekerja').val('<?=$data['lama_bekerja']?>');
	$('#jenis_usaha').val('<?=$data['jenis_usaha']?>');
	$('#jabatan').val('<?=$data['jabatan']?>');
	$('#pendapatan').val('<?=$data['pendapatan']?>');
	$('#sumber_pendapatan_tambahan').val('<?=$data['sumber_pendapatan_tambahan']?>');
	$('#pendapatan_tambahan').val('<?=$data['pendapatan_tambahan']?>');
	<?php } ?>
});
</script>