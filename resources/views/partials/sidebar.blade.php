<section id='sidebar'>
  <i class='icon-align-justify icon-large' id='toggle'></i>
  <ul id='dock'>
    <li class='active launcher'>
      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
      <a href="dashboard.html">Ventas</a>
    </li>
    <li class='launcher'>
      <i class="fa fa-gift" aria-hidden="true"></i>
      <a href="forms.html">Promociones</a>
    </li>
    <li class='launcher'>
      <i class="fa fa-cutlery" aria-hidden="true"></i>
      <a href="tables.html">Productos</a>
    </li>
    <li class='launcher'>
      <i class="fa fa-book" aria-hidden="true"></i>
      <a href="tables.html">Stock</a>
    </li>
    <li class='launcher dropdown hover'>
      <i class="fa fa-pie-chart" aria-hidden="true"></i>
      <a href='#'>Reportes</a>
      <ul class='dropdown-menu'>
        <li class='dropdown-header'>Ver reportes de...</li>
        <li>
          <a href='#'>Ventas</a>
        </li>
        <li>
          <a href='#'>Promociones</a>
        </li>
        <li>
          <a href='#'>Productos</a>
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
