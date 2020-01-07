<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODO</title>
    <style>
        .done {
            text-decoration: line-through;
        }
    </style>
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
            <ul id="todos">
                @foreach ($todos as $todo)
                    <li>
                        <input type="checkbox" data-id="{{ $todo->id}}" @if($todo->done) checked @endif>
                        <span @if($todo->done) class="done" @endif>{{ $todo->title }}</span>
                        <a href="/" data-id="{{ $todo->id }}">[X]</a>
                    </li>
                @endforeach
            </ul>
            <button type="button" id="delete">Delete Selected</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                $.ajax({
                    method: 'POST',
                    url: '{{ url('todo') }}',
                    data: {_token: '{{ csrf_token() }}', title: todo}
                }).done(function(result) {
                    $('#todos').append('<li><input type="checkbox" data-id="' + result + '">&nbsp;<span>' + todo + '</span>&nbsp;<a href="/" data-id="' + result + '">[X]</a></li>');
                    $('#todo').val('');
                    $('#add').prop('disabled', true);
                    $('#help').text('Type in a new todo...');
                });
            });

            // Handle checkbox
            $('#todos').on('click', 'li>input[type=checkbox]', function() {
                var id = $(this).data('id');
                var el = $(this).next('span');

                $.ajax({
                    method: 'PATCH',
                    url: '{{ url('todo') }}' + '/' + id,
                    data: {_token: '{{ csrf_token() }}'}
                }).done(function(result) {
                    if (result === 'true') {
                        el.addClass('done');
                    } else {
                        el.removeClass('done');
                    }
                });
            });

            // Handle delete selected button
            $('#delete').click(function() {
                var datas = $('#todos>li>input[type=checkbox]:checked');
                var ids = [];

                for (var i = 0; i < datas.length; i++) {
                    var el = datas[i];
                    ids.push($(el).attr('data-id'));
                }

                console.log(ids);

                $.ajax({
                    method: 'POST',
                    url: '{{ url('todo/delete') }}',
                    data: {_token: '{{ csrf_token() }}', ids: ids}
                }).done(function(result) {
                    if (result === 'deleted') {
                        datas.closest('li').remove();
                    }
                });
            });

            // Handle delete list item
            $('#todos').on('click', 'li>a', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var el = $(this).closest('li');

                $.ajax({
                    method: 'DELETE',
                    url: '{{ url('todo') }}' + '/' + id,
                    data: {_token: '{{ csrf_token() }}', id: id}
                }).done(function(result) {
                    if (result === 'deleted') {
                        el.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>
