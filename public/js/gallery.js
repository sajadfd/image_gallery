$(function() {
 
    $('.thumbnail').on('click', function() {
        const imageHash = $(this).data('name');
        let sizes = ['mic', 'min', 'med', 'big'];

        if (isMobile) {
            sizes = sizes.filter(size => size !== 'big');
        } else {
            sizes = sizes.filter(size => size !== 'mic');
        }

        $('#sizeOptions').empty();

        sizes.forEach(function(size) {
            const button = $('<button>')
                .text(size.toUpperCase())
                .css({
                    'margin': '0 5px',
                    'padding': '5px 10px',
                    'cursor': 'pointer'
                })
                .on('click', function() {
                    const imageUrl = imageGeneratorUrl + "?name=" + imageHash + "&size=" + size;
                    $('#modalImage').attr('src', imageUrl);
                });
            $('#sizeOptions').append(button);
        });

        const initialSize = sizes[sizes.length - 1];
        const initialImageUrl = imageGeneratorUrl + "?name=" + imageHash + "&size=" + initialSize;
        $('#modalImage').attr('src', initialImageUrl);

        $('#imageModal').fadeIn();
    });

    $('.close').on('click', function() {
        $('#imageModal').fadeOut();
    });

    $('#imageModal').on('click', function(e) {
        if (e.target.id === 'imageModal') {
            $('#imageModal').fadeOut();
        }
    });
});
