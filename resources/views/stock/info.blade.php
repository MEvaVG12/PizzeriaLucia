@extends('layouts.master')

@section('content')
      <div id='content'>
        <div class='panel panel-default grid'>
          <div class='panel-heading'>
            <i class='icon-table icon-large'></i>
            Default Table
            <div class='panel-tools'>
              <div class='btn-group'>
                <a class='btn' href='#'>
                  <i class='icon-wrench'></i>
                  Settings
                </a>
                <a class='btn' href='#'>
                  <i class='icon-filter'></i>
                  Filters
                </a>
                <a class='btn' data-toggle='toolbar-tooltip' href='#' title='Reload'>
                  <i class='icon-refresh'></i>
                </a>
              </div>
              <div class='badge'>3 record</div>
            </div>
          </div>
          <div class='panel-body filters'>
            <div class='row'>
              <div class='col-md-9'>
                Add your custom filters here...
              </div>
              <div class='col-md-3'>
                <div class='input-group'>
                  <input class='form-control' placeholder='Quick search...' type='text'>
                  <span class='input-group-btn'>
                    <button class='btn' type='button'>
                      <i class='icon-search'></i>
                    </button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <table class='table'>
            <thead>
              <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th class='actions'>
                  Actions
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class='success'>
                <td>1</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr class='danger'>
                <td>2</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr class='warning'>
                <td>3</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr class='active'>
                <td>4</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr class='disabled'>
                <td>5</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>9</td>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td>10</td>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td class='action'>
                  <a class='btn btn-success' data-toggle='tooltip' href='#' title='Zoom'>
                    <i class='icon-zoom-in'></i>
                  </a>
                  <a class='btn btn-info' href='#'>
                    <i class='icon-edit'></i>
                  </a>
                  <a class='btn btn-danger' href='#'>
                    <i class='icon-trash'></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
@endsection
