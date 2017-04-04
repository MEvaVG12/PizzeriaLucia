@extends('layouts.master')

@section('content')


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
 

    <div class="page-header">
      <h1>Stocks</h1>
    </div>


    <div class="panel-body" >
      <table class="table table-bordered" id='stockTable'  >
        <thead>
           <th>Ingrediente</th>
            <th>Cantidad</th>
        </thead>
      </table>
    </div>



        <!-- Javascripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script><script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script><script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>



    <script>
    $(document).ready(function(){
      $('#stockTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "api/stocks",
        "columns":[
          {data:'name', name: 'ingredients.name'},
          {data:'amount', name: 'stocks.amount'},
        ]
      });
    });
    </script>


@stop
