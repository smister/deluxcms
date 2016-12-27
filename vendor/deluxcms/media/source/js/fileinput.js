$(function(){
	$(".media-launch").click(function(){
		var inputId = $(this).data('input-id');
		var md = $('[data-frame-id=' + inputId + ']');
		iframe = $('<iframe data-input-id="' + inputId + '" src="' + md.data('frame-src') + '&mode=modal" id="' + md.attr("data-frame-id") + '" frameborder="0" role="media-frame"></iframe>');
		iframe.on('load', function(e) {
			 var modal = $(this).parents('[role="media-modal"]'),
				 input = $(this).parents().find("#" + iframe.data("input-id"))
				 thumbnailContainer = input.parents('.file-input').find(".thumbnail");

			$(this).contents().find(".dashboard").on("click", "#insert-btn", function(e){
					 input.val($(this).siblings("#media-input-filename").val());
					 thumbnailContainer.html('<img src="' + $(this).siblings("#media-input-thumbnail").val() + '" />')
					 md.modal('hide');
			});
		})
		md.find(".modal-body").html(iframe)
		md.modal('show');
	})

	$(".media-reset").click(function(){
		var parent = $(this).parents('.file-input');
		thumbnail = parent.find('.thumbnail');
		thumbnail.html('<img src="' + thumbnail.data('no-image') + '" alt="" width="100px" />');
		parent.find('.upload-input').val('');
	})
})