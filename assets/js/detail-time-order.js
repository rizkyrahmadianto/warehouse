$(document).ready(function () {
	var interval = setInterval(function () {
		moment.locale();
		$('#datetime-part').html(moment().format('DD MMMM YYYY - HH:mm:ss'));
		// $('#time-part').html(moment().format('HH:mm:ss'));
	}, 100);
})
