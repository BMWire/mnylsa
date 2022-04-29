// Create paypal buttons
paypal.Buttons({
    style: {
        layout: 'vertical',
        color: 'blue',
        shape: 'rect',
        label: 'paypal',
        tagline: false
    },
    createOrder: function (data, actions)
    {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: "<?php echo ${art_order['piece_price']}; ?>"
                }
            }]
        });
    },
    onApprove: function (data, actions)
    {
        return actions.order.capture().then(function (details)
        {
            // Call your server to save the transaction
            return fetch('/paypal-transaction-complete', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            });
        });
    },
    onCancel: function (data)
    {
        // Return to orders page
        window.location.href = '/orders.php';
    },
    onError: function (err)
    {
        console.log(err);
    }
}).render('#paypal-button-container');


