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

        .cancel_order {
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="bg-light modal-header">
                    <h1 class=" modal-title fs-5" id="exampleModalLabel">Successfully uploaded! ✅</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your payment receipt is successfully uploaded,
                    wait until it arrives at your home, thanks for your payment.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div style="max-width: 400px" class="container my-5 ">
        <div class=" border border-1 rounded">
            <div class="p-3">
                <div>
                    <div class="d-flex justify-content-between">
                        <p id="invoice">INV/{{ explode("-", $order->id)[0] }}/</p>
                        @isset($verified)
                        <p class="bg-success px-2 text-light rounded">Verified</p>
                        @endisset
                    </div>
                    <p>Transfer to the account number below</p>
                    <span class="fw-bold"><img style="width: 25px; margin-right: 0.25rem" src="img/BRI.png" alt="BRI">4440004051502</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                    </svg>
                    <p>Total payment
                        IDR <span>{{ $order->shopping_total }}</span>
                    </p>

                </div>
                <form method="POST" action="upload-resi/{{ $order->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="mb-2" for="payment_receipt">Upload payment receipt</label>
                        <input type="file" class="d-inline-block form-control-file" name="payment_receipt" id="payment_receipt" accept="image/*">
                    </div>
                    <input disabled id="upload_button" class="w-100 my-3 btn btn-primary" type="submit" value="Upload">
                </form>
                <form method="POST" action="cancel-order/{{ $order->id }}">
                    @csrf
                    <button @isset($verified) disabled @endisset id="cancel_order" class=" w-100 btn btn-outline-danger">Cancel order</button>
                </form>
            </div>
        </div>
    </div>


    <?php

    // if (isset($model["upload_success"])) {
    //     $modal = <<<MODAL
    //             <script>
    //                 let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
    //                 myModal.show();
    //             </script>
    //             MODAL;
    //     echo $modal;
    // }

    // if (isset($model["disabled_cancel"])) {
    //     $modal = <<<MODAL
    //             <script>
    //                 document.getElementById("cancel_order").setAttribute("disabled", "");
    //             </script>
    //             MODAL;
    //     echo $modal;
    // }

    ?>


    <div class="border-top fixed-bottom">
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-evenly justify-content-sm-between align-items-center py-3">

                <p class="nav col-md-4 mb-0 text-body-secondary">&copy;2023 Dhifa Collection</p>

                <ul class="nav">
                    <li class="nav-item"><a href="/" class="nav-link px-2 text-body-secondary">Home</a></li>
                    <li class="nav-item"><a href="cart" class="nav-link px-2 text-body-secondary">Cart</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Contact</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
                </ul>

            </footer>
        </div>
    </div>

    <script>
        let upload_button = document.getElementById("upload_button");
        let input_file = document.getElementById("payment_receipt");

        input_file.onchange = () => {
            upload_button.removeAttribute("disabled");
        }
    </script>

    <!-- <script>
        // =================================
        // CLEAN BASKET FUNCTION 
        // =================================

        const invoice = document.getElementById("invoice").textContent;

        const cancel_order_button = document.getElementById("cancel_order");
        cancel_order_button.onclick = () => {

            const sure_cancel_order = confirm("Do you really want to canel this order ?")

            if (sure_cancel_order == true) {

                window.location = "cancel_order";

            }
        }

        // =================================
        // ENABLE UPLOAD BUTTON
        // =================================
        let upload_button = document.getElementById("upload_button");
        let input_file = document.getElementById("payment_receipt");

        input_file.onchange = () => {
            upload_button.removeAttribute("disabled");
        }
    </script> -->
</body>

</html>