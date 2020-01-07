<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODO</title>
</head>
<body>
    <div>
        <form action="/" method="post">
            @csrf
            <input type="text" id="todo" maxlength="100">
            <button type="button" id="add" disabled>Add Todo</button><br>
            <small id="help">Type in a new todo...</small>
        </form>
        <div>
            <ul id="todos"></ul>
            <button type="button" id="delete">Delete Selected</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script>
        $(function() {
            var todo;
            var i=0;

            // Handle todo input
            $('#todo').keyup(function() {
                todo = $(this).val();

                if ( todo !== '') {
                    $('#add').prop('disabled', false);
                    $('#help').text('Typing: ' + todo);
                } else {
                    $('#add').prop('disabled', true);
                    $('#help').text('Type in a new todo...');
                }
            });

            // Handle add todo button
            $('#add').click(function() {
                i++;
                $('#todos').append('<li><input type="checkbox" data-id="' + i + '">' + todo + '&nbsp;<a href="/" data-id="' + i + '">[X]</a></li>');
                $('#todo').val('');
                $('#add').prop('disabled', true);
                $('#help').text('Type in a new todo...');
            });

            // Handle delete selected button
            $('#delete').click(function() {
                $('#todos>li>input[type=checkbox]:checked').closest('li').remove();
            });

            // Handle delete list item
            $('#todos').on('click', 'li>a', function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        });
    </script>
</body>
</html>
