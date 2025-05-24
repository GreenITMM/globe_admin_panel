$(document).ready(function() {
    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/order-management/confirmed-order-list',
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


})
