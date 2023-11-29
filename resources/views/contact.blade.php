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

<body>
    @include("navbar")

    <div class="container py-4">
        <form action="/contact" method="post">
            @csrf
            <div>
                <h2 class="mb-4">Contact</h2>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" name="message" id="message" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" name="Send" class="btn btn-primary my-3">Send</button>
            </div>
        </form>
    </div>

    @isset($success)
    <script>
        alert("Your'e message successfully sent")
    </script>
    @endisset

    <!-- CONTACT ME SECTION START -->
    <!-- <section id="contact">
        <div class="container">
            <form action="/form" method="post">
                @csrf
                <div class="contact-wrapper">
                    <h3>Contact</h3>
                    <h2>Contact Me</h2>
                    <h4>Contact me for a new project or hire me via email below.</h4>
                </div>
                <div class="form-wrapper">
                    <div>
                        <label for="name">Name
                        </label>
                        <input type="text" name="name" id="name" />
                        <label for="email">Email
                        </label>
                        <input type="email" name="email" id="email" />
                        <label for="message">Message
                        </label>
                        <textarea type="text" name="message" id="message"></textarea>
                        <button type="submit" name="send">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </section> -->
    <!-- CONTACT ME SECTION END -->

</body>

</html>