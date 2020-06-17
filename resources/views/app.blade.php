<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">

    @yield('styles')
    <title>@yield('title')</title>
  </head>
  <body>
    <div class="d-flex" id="wrapper">

      <!-- Sidebar -->
      <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">{{ env('APP_NAME') }}</div>
        <div class="list-group list-group-flush">
          <a href="{{route('calendar.index')}}" class="list-group-item list-group-item-action bg-light">Записи</a>
          <a href="{{route('schedule.index')}}" class="list-group-item list-group-item-action bg-light">График</a>
          <a href="{{route('client.index')}}" class="list-group-item list-group-item-action bg-light">Клиенты</a>
          <a href="{{route('record.index')}}" class="list-group-item list-group-item-action bg-light">Записать</a>
          <a href="{{route('closed.index')}}" class="list-group-item list-group-item-action bg-light">Смена</a>
          {{-- <a href="{{route('place.index')}}" class="list-group-item list-group-item-action bg-light">Места</a> --}}
          <a href="{{route('logout')}}" class="list-group-item list-group-item-action bg-light">Выход</a>
        </div>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">

        <nav class="navbar  navbar-light bg-light border-bottom">
          <button class="btn btn-outline-primary" id="menu-toggle">Меню</button>
          @yield('extend-menu')
        </nav>

        <div class="container-fluid p-0 pl-3 pr-3">
          @yield('content')
        </div>
      </div>
      <!-- /#page-content-wrapper -->
    </div>
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
