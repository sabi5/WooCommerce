(function( $ ) {
	'use strict';

	
	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function(){

		// Get files name from selected options dropdown
		$('#product_list').on('change', function(){

			var file = $(this).val();
			// alert(file);
			// alert("hello");
			// console.log(boiler_ajax_url);
	
			$.ajax({
				url: boiler_ajax_url.ajax_url,
				type: 'post',
				data: {
					'action':'meta_ajax',
					file : file
				},
				success: function( response ) {
					// alert(response);
					$(".result").html(response);
				//    alert("updated successfully");
				},
			});
		});

		// Get sku value when click on import button
		$(document).on('click','.import', function(){

			var id = $(this).data("id");
			// alert(id);
			var file = $('#product_list').val();
			// alert(file);

			$.ajax({
				url: boiler_ajax_url.ajax_url,
				type: 'post',
				data: {
					'action':'import_ajax',
					file : file,
					id : id
				},
				success: function( response ) {
					alert(response);
					
				},
			});
			
		});

		// bulk import
		$(document).on('click','.save', function(){

			var product_id = $(this).val();
			// alert(product_id);
			// var arr = new Array();
			var count_check = $('.save:checked').length;
			// alert(count_check);
		
			// alert($import);
			$(document).on('click','#bulk-action-selector-top', function(){

				var import_click = $(this).val();
				// alert(import_click);

				var apply_click = $('#doaction').val();
				var file = $('#product_list').val();
				// alert(file);

				// alert(apply_click);
				
				$.ajax({
					url: boiler_ajax_url.ajax_url,
					type: 'post',
					data: {
						'action':'all_product_import',
						product_id : product_id,
						count_check : count_check,
						import_click : import_click,
						apply_click : apply_click,
						file : file
						
					},
					success: function( response ) {
						alert(response);
						
					},
				});

			
			});
			
			
		});
	});
	
})( jQuery );
