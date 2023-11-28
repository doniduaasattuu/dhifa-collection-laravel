<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>{{ $title }}</title>
</head>
<style>
</style>

<body>


    @include("navbar")

    <div class="container d-flex absolute mt-3">
        <div class="my-auto align-items-center mx-auto" style="min-width: 300px;">

            @isset($error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endisset

            <h2 class="mb-4">{{ $title }}</h2>
            <form action="/change-password" method="POST">
                @csrf
                <div class=" mb-3">
                    <label for="email" class="form-label -mb-5">Your Email</label>
                    <input type="email" id="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="current_password" class="form-label -mb-5">Current Password</label>
                    <input id="current_password" name="current_password" type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label -mb-5">New Password</label>
                    <input id="new_password" name="new_password" type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="confirm_new_password" class="form-label -mb-5">Confirm New Password</label>
                    <input id="confirm_new_password" name="confirm_new_password" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
                <div id="emailHelp" class="mt-2 form-text"><a class="text-decoration-none" href="/not-found">Forgot your password?</a></div>
            </form>
        </div>

    </div>

    @include("footer")
</body>

</html>