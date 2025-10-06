var SweetAlert2Plugin = function () {

	var datatables = function () {
		$('.dt-btn').on('click', function(e) {
	        e.preventDefault();
	        var form = $(this).parents('form');
	        swal({
	            title: "Apakah anda yakin?",
	            text: $(this).data("swa-text"),
	            type: "warning",
	            showCancelButton: true
	        }).then(function() {

	            form.submit();
	        }).catch(swal.noop);
	    });
	}

	var simpan = function () {
		$("button:submit.simpan").on("click", function(e){
			e.preventDefault();
	        var form = $(this).parents('form');
	        swal({
	            title: "Apakah anda yakin?",
	            text: $(this).data("swa-text"),
	            type: "warning",
	            showCancelButton: true
	        }).then(function() {

	            form.submit();
	        }).catch(swal.noop);
		});
	}

	var ubah = function () {
		$("button:submit.ubah").on("click", function(e){
			e.preventDefault();
	        var form = $(this).parents('form');
	        swal({
	            title: "Apakah anda yakin?",
	            text: $(this).data("swa-text"),
	            type: "warning",
	            showCancelButton: true
	        }).then(function() {

	            form.submit();
	        }).catch(swal.noop);
		});
	}

    return {
        init: function () {
        	datatables();
        	simpan();
        	ubah();
        }
    };

}();

jQuery(document).ready(function() {
   SweetAlert2Plugin.init();
});
