(function( $ ) {
	'use strict';

    $(document).ready(function() {

		/**
		 * Capture print label links and redirect them to the print function
		 */
		$('a.print-label').click(function(event) { 
		    event.preventDefault(); 
		    console.log('printing '+$(this).attr('href'));
		    $.ajax({
		        url: $(this).attr('href'),
		        success: function(data) {
		            printLabel(data);
		        }
		    });
		    return false; // for good measure
		});

	});

})( jQuery );


/**
 * Pass ZPL directly to QZ Tray
 */
function printLabel(data) {

	qz.security.setCertificatePromise(function(resolve, reject) {
		console.log("../wp-content/plugins/wc-labels/lib/qz/digital-certificate.crt");
	    $.ajax({ url: "../wp-content/plugins/wc-labels/lib/qz/digital-certificate.crt", cache: false, dataType: "text" }).then(resolve, reject);
	});

	// POST
	qz.security.setSignaturePromise(function(toSign) {
		return function(resolve, reject) {
			console.log("../wp-content/plugins/wc-labels/lib/qz/sign-message.php");
		 	$.post("../wp-content/plugins/wc-labels/lib/qz/sign-message.php", {request: toSign}).then(resolve, reject);
		};
	});

	var zpl_data = data.split('\n');
	console.log(zpl_data);

	qz.websocket.connect().then(function() { 
	   	return qz.printers.find("GK420")      			// Pass the printer name into the next Promise
	}).then(function(printer) {
		var config = qz.configs.create(printer);
		var data = zpl_data;
	   return qz.print(config, data);
	}).then(function() {
		qz.websocket.disconnect();
	}).catch(function(e) { console.error(e); });

}

