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

    $(document).on('click', 'li', function(){
        var value = $(this).text();
        $('#search').val(value);
        $('#products_list').html("");
    });
});