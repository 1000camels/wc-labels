<!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8 wp-toolbar"  lang="en-AU">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" class="wp-toolbar"  lang="en-AU">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>QZ Test</title>
<style>
</style>
<script type='text/javascript' src='/wp-admin/load-scripts.php?c=0&amp;load%5B%5D=jquery-core,jquery-migrate,utils,moxiejs,plupload&amp;ver=4.9.8'></script>
<script type='text/javascript' src='/wp-content/plugins/wc-labels/admin/js/qz-tray/dependencies/rsvp-3.1.0.min.js'></script>
<script type='text/javascript' src='/wp-content/plugins/wc-labels/admin/js/qz-tray/dependencies/sha-256.min.js'></script>
<script type='text/javascript' src='/wp-content/plugins/wc-labels/admin/js/qz-tray/qz-tray.js'></script>
<script type="text/javascript">

function printLabel() {

	qz.security.setCertificatePromise(function(resolve, reject) {
	    jQuery.ajax({ url: "/qz/digital-certificate.crt", cache: false, dataType: "text" }).then(resolve, reject);
	});

	// GET
	// qz.security.setSignaturePromise(function(toSign) {
	// 	return function(resolve, reject) {
	// 		jQuery.ajax("/qz/sign-message.php?request=" + toSign).then(resolve, reject);
	// 	};
	// });

	// POST
	qz.security.setSignaturePromise(function(toSign) {
		return function(resolve, reject) {
		 	jQuery.post("/qz/sign-message.php", {request: toSign}).then(resolve, reject);
		};
	});

	var zpl_data = jQuery('#raw_zpl').val().split('\n');
	qz.websocket.connect().then(function() { 
	   	return qz.printers.find(jQuery('#printer_name').val());      			// Pass the printer name into the next Promise
	}).then(function(printer) {
		var config = qz.configs.create(printer);
		var data = zpl_data;
	   return qz.print(config, data);
	}).then(function() {
		qz.websocket.disconnect();
	}).catch(function(e) { console.error(e); });

}

</script>
</head>
<body>

<label for="printer_name">Printer:</label>
<input type="text" id="printer_name" name="printer_name" value="GK420" /><br/>
<label for="raw_zpl">ZPL:</label><br/>
<textarea id="raw_zpl" name="raw_zpl" rows="25" cols="80"><?php echo file_get_contents('example.zpl'); ?></textarea><br/>
<a href="javascript:printLabel()">Print Label</a><br/>

</body>
</html>