$(function() {
    $("#drop-area").dmUploader({
        url: 'do.php',
        multiple: false,
        queue: false,
        dataType: 'text',

        onDragEnter: function() {
            // Happens when dragging something over the DnD area
            this.addClass('active');
        },
        onDragLeave: function() {
            // Happens when dragging something OUT of the DnD area
            this.removeClass('active');
        },
        onBeforeUpload: function() {
            $("#drop-area").hide();
            $("#result").html("Грузим, немножечко подождите...");
        },
        onUploadError: function(id, xhr, status, errorThrown) {
            $("#result").text("something went wrong: " + status + ": " + errorThrown);
        },
        onUploadSuccess: function(id, data) {
            ht=/<body[\s\S]*>([\s\S]*)<\/body>/gmu.exec(data);
            if (ht)
                $("#result").html(ht[0]);
            else
                $("#result").html(data);
        }
    });
});