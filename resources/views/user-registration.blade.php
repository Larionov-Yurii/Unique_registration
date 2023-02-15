<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Registration</title>
    <link href="css/user-registration.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Welcome to Registration</h2>
                  <form action="{{ route("user.sign-up") }}" method="POST">
                    @csrf
                       <div class="form-outline form-white mb-4">
                         <input type="text" name="name" id="name" class="form-control form-control-lg">
                         <label class="form-label">Write Name</label>
                       </div>
                       @error('name')
                       <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                       <div class="form-outline form-white mb-4">
                         <input type="text" name="phone_number" id="phone_number" class="form-control form-control-lg">
                         <label class="form-label">Write Phonenumber</label>
                       </div>
                       @error('phone_number')
                       <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                       <button class="btn btn-outline-light btn-lg px-5" type="submit">Registration</button>
                  </form>
                 </div>
               <div>
                  <p class="mb-0">Already have an account? <a href="{{ route('user.start-login') }}" class="text-white-50 fw-bold">Sign In</a></p>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
