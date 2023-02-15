<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Unique Page A</title>
    <link href="../css/unique-page.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <section class="vh-100 gradient-custom">
    <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <form action="{{ route('user.create-link') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-primary">Create a new Link</button>
        </form>
        <form action="{{ route('user.delete-link') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger ms-3">Deactivate a Link</button>
        </form>
        <div class="navbar-brand ms-auto">
          <form action="{{ route('user.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
          </form>
        </div>
      </div>
    </nav>

    <div class="card-body p-5 text-center">
      @if (session()->has('link-created'))
    <div class="d-flex justify-content-center">
    <div class="alert alert-success" role="alert">
       {{ session()->get('link-created') }}
    </div>
    </div>
      @endif
      <h1>Welcome to Unique Page A</h1>
        <form action="{{ route('user.post-event') }}" method="POST">
          @csrf
          <button type="submit"class="btn btn-primary ">Imfeelinglucky</button>
        </form>
          @isset($result_event)
            @foreach ($result_event as $event)
              <div class="random-number">Random Number: {{ $event->random_number }}</div>
              <div class="text-result">Text Result: {{ $event->info_text }}</div>
              <div class="winning-summ">Winning Summ: {{ $event->winning_amount }}</div>
            @endforeach
          @endisset
    </div>

    <div class="card-body p-5 text-center">
      <form action="{{ route('user.get-history') }}" method="GET">
        <button type="submit" class="btn btn-primary">History</button>
      </form>
         @isset($get_actions)
           <div class="container-fluid">
             <div class="table-responsive p-lg-3">
               <table class="table table-dark  table-striped table-bordered mx-auto" style="width:70%">
                 <thead>
                   <tr class="table-active">
                     <th>Random Number</th>
                     <th>Info Text</th>
                     <th>Winning Amount</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($get_actions as $action)
                   <tr>
                     <td>{{ $action->random_number }}</td>
                     <td>{{ $action->info_text }}</td>
                     <td>{{ $action->winning_amount }}</td>
                    </tr>
                   @endforeach
                 </tbody>
               </table>
             </div>
           </div>
         @endisset
    </div>
  </section>
</body>
</html>
