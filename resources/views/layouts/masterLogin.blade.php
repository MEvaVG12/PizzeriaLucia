<!DOCTYPE html>
<html class='no-js' lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    @yield('title')

    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="{{ url('assets/css/application-a07755f5.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/images/Pizza-icon.ico')}}" rel="icon" type="image/ico" />

  </head>
  <body class='login'>
    <div class='wrapper'>
      <div class='row'>
        <div class='col-lg-12'>
          <div class='brand text-center'>
            <h1>
              <div class='logo-icon'>
                <img src="{{ url('assets/images/pizza.png') }}" alt="Pizzería Lucía">
              </div>
              Pizzería Lucía
            </h1>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class='col-lg-12'>
          <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo electrónico">

                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
              </div>
              @yield('content')
          </form>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <!-- Javascripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script>
    <script src="{{url('assets/js/application-985b892b.js')}}" type="text/javascript"></script>
    <!-- Google Analytics -->
    <script>
      var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
      (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
  </body>
</html>
