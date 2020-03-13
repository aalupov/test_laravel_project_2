var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function() {

	// Update record
	$(":button").click(function() {
		var product_id = this.id;
		var price = $('#' + product_id + '').val();

		if (price != '') {
			$.ajax({
				url : 'updatePrice',
				type : 'post',
				data : {
					_token : CSRF_TOKEN,
					price : price,
					product_id : product_id
				},
				success : function(response) {
					alert('Updated');
				}
			});
		} else {
			alert('Fill the price');
		}
	});
});
