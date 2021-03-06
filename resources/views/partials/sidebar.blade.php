<section id='sidebar'>
  <i class='icon-align-justify icon-large' id='toggle'></i>
  <ul id='dock'>
    <li class='active launcher dropdown hover'>
      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
      <a href="{{ url('sale/index') }}">Ventas</a>
       <ul class='dropdown-menu'>
        <li>
          <a href="{{ url('sale/create') }}">Nueva</a>
        </li>
        <li>
          <a href="{{ url('sale/index') }}">Ver</a>
        </li>
      </ul>
    </li>
    <li class='launcher dropdown hover'>
      <i class="fa fa-gift" aria-hidden="true"></i>
      <a href="{{ url('promotion/index') }}">Promociones</a>
      <ul class='dropdown-menu'>
        <li>
          <a href="{{ url('promotion/create') }}">Nueva</a>
        </li>
        <li>
          <a href="{{ url('promotion/index') }}">Ver</a>
        </li>
      </ul>
    </li>
    <li class='launcher'>
      <i class="fa fa-cutlery" aria-hidden="true"></i>
      <a href="{{ url('product') }}">Productos</a>
    </li>
    <li class='launcher'>
      <i class="fa fa-book" aria-hidden="true"></i>
      <a href="{{ url('stock') }}">Stock</a>
    </li>
    <li class='launcher dropdown hover'>
      <i class="fa fa-pie-chart" aria-hidden="true"></i>
      <a href='#'>Reportes</a>
      <ul class='dropdown-menu'>
        <li class='dropdown-header'>Ver reportes de...</li>
        <li>
          <a href="{{ url('sale/index') }}">Ventas</a>
        </li>
        <li>
          <a href="{{ url('promotion/index') }}">Promociones</a>
        </li>
        <li>
          <a href="{{ url('product') }}">Productos</a>
        </li>
      </ul>
    </li>
    <li class='launcher dropdown hover'>
      <i class="fa fa-user" aria-hidden="true"></i>
      <a>Usuarios</a>
      <ul class='dropdown-menu'>
        <li>
          <a href="{{ route('register') }}">Nuevo</a>
        </li>
      </ul>
    </li>
  </ul>
  <div data-toggle='tooltip' id='beaker'></div>
</section>
