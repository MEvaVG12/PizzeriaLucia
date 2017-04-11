<!DOCTYPE html>
<html class='no-js' lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <title>Pizzería Lucía</title>
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="{{url('assets/css/application-a07755f5.css')}}" rel="stylesheet" type="text/css" />
    @yield('links')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/images/Pizza-icon.ico')}}" rel="icon" type="image/ico" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

  </head>
  <body class='main page'>
    <!-- Navbar -->
    @include('partials.navbar')
    <div id='wrapper'>
      <!-- Sidebar -->
      @include('partials.sidebar')
      <!-- Tools -->
      @include('partials.tools')
      <!-- Content -->
      <div id='content'>
        {{--@notification()--}}
        @yield('content')
      </div>
    </div>
    <!-- Footer -->
    <!-- Javascripts -->
    @yield('javascript')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script>
    <script src="{{url('assets/js/application-985b892b.js')}}"" type="text/javascript"></script>
    <!-- Google Analytics -->
    <script>
      var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
      (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
  </body>
</html>
