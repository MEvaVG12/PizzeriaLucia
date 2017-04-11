<div class='navbar navbar-default' id='navbar'>
  <a class='navbar-brand' href='#'>
    <img src="{{url('assets/images/pizza.png')}}" alt="Pizzería Lucía">
    Pizzería Lucía
  </a>
  <ul class='nav navbar-nav pull-right'>
    <li class='dropdown user'>
      <a class='dropdown-toggle' data-toggle='dropdown'>
        <i class="fa fa-user" aria-hidden="true"></i>
        <strong>{{Auth::user()->name}}</strong>
        <b class='caret'></b>
      </a>
      <ul class='dropdown-menu'>
        <li>
          <a href="{{url('logout')}}">
            <i class="fa fa-power-off" aria-hidden="true"></i>
            Cerrar Sesión
          </a>
        </li>
      </ul>
    </li>
  </ul>
</div>
