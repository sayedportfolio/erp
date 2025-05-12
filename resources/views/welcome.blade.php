<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clusterweb Solution | ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Application Style -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body>

    <div class="container-xxl">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center flex-column">
                    <h1 class="text-center">Welcome to Clusterweb Solution</h1>
                    <a href="{{ route('login') }}" class="btn btn-primary align-self-center">Get Start</a>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts

</body>

</html>