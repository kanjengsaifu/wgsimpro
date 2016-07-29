<script type="text/javascript">
	// init action fn
	var action = function(act, id) {
		if(act==='detailid') {
			location.href = "<?=base_url()?>index.php/notifikasi/"+id;
		} else if(act==='email') {
			if(confirm("Anda yakin mengirimkan ulang Email Pemberitahuan?")) {
				$.post("<?=base_url()?>index.php/mail/brcs/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Email akan segera dikirimkan.');
						location.href = "<?=base_url()?>index.php/notifikasi";
					} else {
						alert('Terkirim.');
					}
				});
			}
		} else if(act==='emailid') {
			if(confirm("Anda yakin mengirimkan ulang Email Pemberitahuan?")) {
				$.post("<?=base_url()?>index.php/mail/send/"+id,function(ev) {
					if(ev.response==='1') {
						alert('Email akan segera dikirimkan.');
						location.href = "<?=base_url()?>index.php/notifikasi";
					} else {
						alert('Terkirim.');
					}
				});
			}
		}else{
			if(confirm("Anda yakin mengirimkan ulang SMS Pemberitahuan?")) {
				$.post("<?=base_url()?>index.php/sms/send/"+id,function(ev) {
					if(ev.response==='1') {
						alert('SMS akan segera dikirimkan.');
						location.href = "<?=base_url()?>index.php/notifikasi";
					} else {
						alert('Terkirim.');
					}
				});
			}
		}
	}; 
</script>
