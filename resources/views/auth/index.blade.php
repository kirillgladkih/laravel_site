<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <style>
       .login-form{
            position: fixed; top: 50%; left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
       }
    </style>
    <title>@yield('title')</title>
  </head>
  <body>
    <div class="" id="wrapper">
      <div id="page-content-wrapper">
        <div class="container-fluid p-0 pl-3 pr-3">
            <div class="login-form d-flex justify-content-center col-12 ">
                  <form method="POST" class="col-12 col-md-6 bg-light" action="{{ route('login') }}">
                    @csrf
                    
                    {{-- <div class="alert-danger col-12 p-2 mt-3">
                      @foreach ($errors->all() as $value)
                          <h5 class="text-center">{{ $value }}</h5>
                      @endforeach
                    </div>
                    @endif --}}
                    <h2 class="text-center pt-3 pb-3" style="color:#66666">Авторизация</h2>
                    <div class="form-group">
                      <input type="text" class="form-control p-4"placeholder="телефон" name='phone' value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control p-4" placeholder="пароль" name="password" required>
                    </div>
                    <div class="form-group float-right pt-3 ">
                        <button class="btn btn-primary pl-5 pr-5" style="font-size : 1.2em">Вход</button>
                    </div>
                  </form>
            </div>
        </div>  
      </div>
      <!-- /#page-content-wrapper -->
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
    <!-- Menu Toggle Script -->
    <script>
      $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
 
    </script>
    @yield('scripts')
    </body>
</html>