<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body>
    Hello {{ $user }}

    <!-- CONTACT ME SECTION START -->
    <section id="contact">
        <div class="container">
            <!-- <form action="mailto:doni.duaasattuu@gmail.com"> -->
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
    </section>
    <!-- CONTACT ME SECTION END -->

</body>

</html>