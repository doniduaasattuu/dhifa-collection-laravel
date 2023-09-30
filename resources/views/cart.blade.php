<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>{{ $title }}</title>
</head>

<style>
    #shopping_summary {
        width: 23rem;
    }

    @media (max-width: 576px) {
        #shopping_summary {
            width: 100%;
        }

        .clean_basket {
            margin-bottom: 1rem;
            width: 100%;
        }

        .checkout {
            width: 100%;
        }
    }
</style>

<body>

    @include("navbar")

    <!-- Modal -->
    <div class="modal fade" id="select_payment_method" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="bg-light modal-header">
                    <h1 class=" modal-title fs-5" id="exampleModalLabel">No payment method selected! ⚠️</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please select your payment method before transaction.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="briva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="bg-light modal-header">
                    <h1 class=" modal-title fs-5" id="exampleModalLabel">Sorry, this service is temporarily unavailable</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please select other payment method,</br>
                    Sorry for the inconvenience.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="m-1 d-flex justify-content-between align-items-baseline">
            <div>
                <h2><?php
                    $firstname = explode(" ", session()->get("user"));
                    echo $firstname[0];
                    ?>'s Cart</h2>
            </div>
            <div>
                <span class="invoice">INV/{{ explode("-", $order->id)[0] }}/</span>
            </div>
        </div>

        <table class="table my-3">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <!-- <th scope="col">Price</th> -->
                    <th scope="col">Qty</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($order_details as $order_detail)
                <tr>
                    <td class="align-middle">{{ $order_detail->product->name }}</td>
                    <!-- <td class="align-middle">IDR <span class="price">{{ $order_detail->price }}</span></td> -->
                    <td class="align-middle">
                        <button class="button_decrement btn btn-outline-primary btn-sm me-1">-</button>
                        <span class="text-center align-middle" style="width: 25px;" class="d-sm-inline-block">{{ $order_detail->qty }}</span>
                        <button class="button_increment btn btn-outline-primary btn-sm ms-1">+</button>
                    <td class="align-middle">IDR <span class="amount">{{ $order_detail->amount }}</span></td>
                    <td><button type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg></button></td>
                </tr>
                @endforeach


            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-sm">
                <button id="clean_basket" class="clean_basket mb-sm-0 btn btn-outline-danger">Delete basket</button>
            </div>
            <div class="col-sm">
                <div class="ms-auto card" id="shopping_summary">
                    <div class=" card-body">

                        <h5 class="fw-bold card-title mb-0">Cart details</h5>
                        <!-- <div class="d-flex justify-content-between align-items-baseline">
                            <button class="btn btn-primary">Verified</button>
                        </div> -->
                        <hr>

                        <!-- TOTAL AMOUNT {PRICE} -->
                        <p class="card-text">
                        <h6 class="fw-bold">Total price ({{ count($order_details) }} items)</h6>
                        IDR <span class="total_amount">{{ $order_details->sum("amount") }}</span></p>
                        <hr>

                        <!-- SHIPPING ADDRESS -->
                        <p class="card-text">
                        <h6 class="fw-bold">Shipping address</h6>
                        <span class="shipping_address text-secondary">Cikarang</span></p>

                        <!-- SHIPPING PRICE -->
                        <h6 class="fw-bold">Shipping price</h6>
                        IDR <span class="shipping_price">50</span>K</p>
                        <hr>

                        <!-- TOTAL PAYMENT -->
                        <p class="card-text">
                        <h6 class="fw-bold">Total payment</h6>
                        IDR <span class="total_payment">500</span>K</p>
                        <hr>

                        <div class="d-sm-flex d-block justify-content-between">
                            <select class="payment_method me-sm-4 form-select" aria-label="Default select example">
                                <option selected>Payment method</option>
                                <option value="ATM Transfer">ATM Transfer</option>
                                <option value="BRIVA">BRIVA</option>
                            </select>
                            <!-- <a href="#" class="checkout float-end mt-sm-0 mt-3 btn btn-primary">Checkout</a> -->
                            <button class="checkout float-end mt-sm-0 mt-3 btn btn-primary">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>


    @include("footer")

    <!-- <script>
        const button_decrement = document.getElementsByClassName("button_decrement");
        const button_increment = document.getElementsByClassName("button_increment");

        const price = document.getElementsByClassName("price");
        const amount = document.getElementsByClassName("amount");

        const total_amount = document.getElementsByClassName("total_amount")[0];
        const total_payment = document.getElementsByClassName("total_payment")[0];
        const shipping_price = document.getElementsByClassName("shipping_price")[0];

        const invoice = document.getElementsByClassName("invoice")[0];

        const checkout = document.getElementsByClassName("checkout")[0];
        const payment_method = document.getElementsByClassName("payment_method")[0];


        // PENGURANGAN KUANTITI
        for (let i = 0; i < button_decrement.length; i++) {
            button_decrement[i].onclick = () => {

                if (Number(button_decrement[i].nextElementSibling.textContent) > 1) {

                    let text_content = Number(button_decrement[i].nextElementSibling.textContent) - 1;
                    button_decrement[i].nextElementSibling.textContent = text_content;

                    let amount_update = Number(button_decrement[i].nextElementSibling.textContent) * Number(price[i].textContent)
                    amount[i].textContent = amount_update;

                    sum_total_amount();
                    sum_total_payment();

                    // =======================================
                    // UPDATE KUANTITI KE DATABASE MELALUI API
                    // =======================================
                    update_cart_quantity(button_decrement[i], "decrement", amount_update);

                }
            }
        }

        // PENAMBAHAN KUANTITI
        for (let i = 0; i < button_increment.length; i++) {

            button_increment[i].onclick = () => {

                let text_content = Number(button_increment[i].previousElementSibling.textContent) + 1;
                button_increment[i].previousElementSibling.textContent = text_content;

                let amount_update = Number(button_increment[i].previousElementSibling.textContent) * Number(price[i].textContent)
                amount[i].textContent = amount_update;

                sum_total_amount();
                sum_total_payment();

                // =======================================
                // UPDATE KUANTITI KE DATABASE MELALUI API
                // =======================================
                update_cart_quantity(button_increment[i], "increment", amount_update);

            }
        }


        // FUNCTION UPDATE KUANTITI KE DATABASE 
        function update_cart_quantity(button, method, amount) {
            const update_cart_quantity_api = new XMLHttpRequest();

            update_cart_quantity_api.open("POST", "update_cart_quantity");

            let product_id_to_update = button.getAttribute("product_id");

            update_cart_quantity_api.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            update_cart_quantity_api.send(`product_id=${product_id_to_update}&function=${method}&amount=${amount}`);
        }

        // SUM AMOUNT AS TOTAL AMOUNT
        function sum_total_amount() {

            let temp = 0;
            for (let i = 0; i < amount.length; i++) {

                let amount_temp = Number(amount[i].textContent);
                temp = temp + amount_temp;

                total_amount.textContent = temp;

            }
        }

        // SUM TOTAL PAYMMENT
        function sum_total_payment() {

            xhr = new XMLHttpRequest()
            xhr.open("POST", "total_payment");

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.send(`total_payment=${Number(total_amount.textContent) + Number(shipping_price.textContent)}&invoice=${invoice.textContent}`)

            total_payment.textContent = Number(total_amount.textContent) + Number(shipping_price.textContent);

        };

        // WINDOW ON LOAD
        window.onload = () => {

            sum_total_amount();
            sum_total_payment();

            let MyArray = ["Doni", "Darmawan"];
            let NewArray = new Array("Doni", "Darmawan");

        }

        // =================================
        // CLEAN BASKET FUNCTION 
        // =================================
        const clean_basket_button = document.getElementById("clean_basket");
        clean_basket_button.onclick = () => {

            const sure_delete_basket = confirm("Do you really want to delete ?")

            if (sure_delete_basket == true) {

                window.location = "clean_basket";

            }
        }


        // ====================
        // CHECKOUT
        // ====================

        checkout.onclick = () => {
            if (payment_method.value == "Payment method") {
                // alert("Select payment method first!")

                let myModal = new bootstrap.Modal(document.getElementById('select_payment_method'), {});
                myModal.show();

            } else {

                if (payment_method.value == "ATM Transfer") {

                    window.location = "update_status"

                } else if (payment_method.value == "BRIVA") {

                    let myModal = new bootstrap.Modal(document.getElementById('briva'), {});
                    myModal.show();

                } else {
                    console.info("Tidak diketahui")
                }
            }
        }
    </script> -->
</body>

</html>