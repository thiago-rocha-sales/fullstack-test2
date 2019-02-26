$(function(){
    $('a.delete').on('click', function(event) {
        event.preventDefault();

        var form = $('#delete-post-form');
        var href = $(this).attr('href');
        var id = parseInt(href.replace('#', '')); 

        form.append(
            $('<input>').attr('type', 'text')
                        .attr('name', 'id')
                        .attr('value', id)
        );

        form.submit();
    });

    $('a.edit').on('click', function(event) {
        event.preventDefault();

        var href = $(this).attr('href');

        $.get(href, function(data, status) {
            var obj = JSON.parse(data);
            
            $('#title').val(obj.data.title);
            $('#body').val(obj.data.body);
            $('#published').val(obj.data.published);
            $('#author_id').val(obj.data.author_id);
            $('#id').val(obj.data.id);

        });

    });
});