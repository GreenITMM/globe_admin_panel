$(document).ready(function() {

    console.log(rate)
    // btn group when start
    if(rate == 0) {
        $('.update-group').addClass('d-none');
        $('.edit-group').addClass('d-none');
        $('.save-group').removeClass('d-none');
    } else if(rate > 0) {
        $('.update-group').addClass('d-none');
        $('.edit-group').removeClass('d-none');
        $('.save-group').addClass('d-none');
    }

    $(document).on('click', '.save-btn, .update-btn', function() {
        let mmk_amount = parseInt($('#mmk').val());

        if(mmk_amount <= 0) {
            warning_alert('MMK amount must be greater than 0');
            return;
        }

        ask_confirm('Are you sure to save ?').then(result => {
            if(result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: '/admin/currency-rates/',
                    data: {mmk_amount},
                    success: function(res) {
                        console.log(res)
                        if(res == 'success') {
                            location.reload();
                        }
                    }

                })
            }
        })

    })

    $(document).on('click', '.edit-btn', function() {
        $('.update-group').removeClass('d-none');
        $('.edit-group').addClass('d-none');
        $('.save-group').addClass('d-none');

        $('#mmk').attr('readonly', false);
    })

    $(document).on('click', '.cancel-btn', function() {
        $('.update-group').addClass('d-none');
        $('.edit-group').removeClass('d-none');
        $('.save-group').addClass('d-none');

        $('#mmk').val(rate);
        $('#mmk').attr('readonly', true);
    })
})
