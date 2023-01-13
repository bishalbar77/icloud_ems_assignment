@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Laravel Fee Assignment</div>
                <div class="card-body">
                    <form action="{{ route('import') }}"
                          method="POST"
                          enctype="multipart/form-data" style="padding: 20px;">
                        @csrf
                        <input type="file" name="file"
                               class="form-control">
                        <br>
                        <button class="btn btn-success" style="float: right;">
                              Import Fee Data
                           </button>
                    </form>
                </div>
                <div class="panel-body" style="padding-top: 50px;">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Roll No</th>
                                <th>Due Amount</th>
                                <th>Paid Amount</th>
                                <th>Refund Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascripts')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(function () {

          var table = $('.yajra-datatable').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: "{{ route('data') }}",
                  columns: [
                      {data: 'date', name: 'date'},
                      {data: 'roll_no', name: 'roll_no'},
                      {data: 'due_amount', name: 'due_amount'},
                      {data: 'paid_amount', name: 'paid_amount'},
                      {data: 'refund_amount', name: 'refund_amount'},
                  ]
              });

        });
      </script>
@endsection
