function mediaTinyMce(callback, value, meta)
{
    var id = tinymce.activeEditor.settings.id,
        md = $('[data-frame-id=' + id + ']');
        iframe = $('<iframe src="' + md.data('frame-src') + '" frameborder="0" role="media-frame"></iframe>');
        iframe.on('load', function(e) {
            $(this).contents().find(".dashboard").on("click", "#insert-btn", function(e){
                    var originalUrl = $(this).siblings("#media-original-url").val();
                    //这里的localhost:8080会被转化成相对路径
                    callback(originalUrl , {alt: '图片'});
                    md.modal('hide');
            });
        })

        md.find(".modal-body").html(iframe)
        md.modal('show');
}