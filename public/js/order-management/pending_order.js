$(document).ready(function() {
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/order-management/pending-order-list',
        columns: [{
                data: 'plus-icon',
                name: 'plus-icon'
            },
            {
                data: 'order_code',
                name: 'order_code'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'city_id',
                name: 'city_id'
            },
            {
                data: 'payment_method',
                name: 'payment_method'
            },
            {
                data: 'total_item_qty',
                name: 'total_item_qty'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
        columnDefs: [{
            targets: 'no-sort',
            sortable: false,
            searchable: false
        }, {
            targets: [0],
            class: 'control'
        }]
    })

    $(document).on('click', '.confirm-order-btn', function() {
        let order_id = $('#order_id').val();

        if(order_id) {
            ask_confirm('Are you sure to confirm this order ?').then(result => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/admin/order-management/confirm-order/'+order_id,
                        success: function(response) {
                            if(response  == 'success') {
                                location.href = '/admin/order-management/pending-orders';
                            }
                        }
                    })
                }
            })
        }
    })

    $(document).on('click', '.cancel-order-btn', function() {
        let order_id = $('#order_id').val();

        if(order_id) {
            ask_confirm('Are you sure to cancel this order ?').then(result => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/admin/order-management/cancel-order/'+order_id,
                        success: function(response) {
                            if(response  == 'success') {
                                location.href = '/admin/order-management/pending-orders';
                            }
                        }
                    })
                }
            })
        }
    })

})
