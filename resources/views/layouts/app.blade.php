<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'E-COMMERCE STORE' }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href={{ url('css/app.css') }}>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('partials.navbar')
        <main class="py-4">
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ url('js/parsley.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>

    </script>
    <script>
        $('#checkout-form').parsley();
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            if($('#search').val() === ''){
                $('#search_btn').attr('disabled',true);
            }
            if($('#min').val() !== '' && $('#max').val() !== ''){
                $('#apply_price').attr('disabled',false);
            }
            $('#search').on('keyup',function() {
                const query = $(this).val();
                if (query.length >= 3){
                    $('#search_btn').attr('disabled',false);
                    $.ajax({
                        url:"{{ route('search') }}",
                        type:"GET",
                        data:{'search':query},
                        success:function (data) {
                            $('#products_list').html(data);
                        }
                    })
                }
                else {
                    $('#products_list').html("");
                }

            });

            $(document).on('click', '.list-group-item', function(){
                var value = $(this).text();
                $('#search').val(value);
                $('#products_list').html("");
            });

        });
    </script>
</body>
</html>
