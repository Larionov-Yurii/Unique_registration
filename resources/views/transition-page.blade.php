<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Unique Page</title>
    <link href="css/transition-page.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <section class="vh-100 gradient-custom">
    <div class="card-body p-5 text-center">
      <h1>To go to special page A, click on the button that contains a unique link to go</h1>
      <a href="{{ route('user.transition-via-click') }}" class="btn btn-primary btn-lg" role="button">Link Button</a>
    </div>
  </section>
</body>
</html>
