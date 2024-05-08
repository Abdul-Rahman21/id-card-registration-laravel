@extends('admin-layout.theme')

@section('csslink')

<link rel="stylesheet" href="{{ url('assest/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Organisation List
                {{-- <a href="{{ url('add-organisation') }}" class="btn btn-success pull-right"></a> --}}
                <button onclick="view()"
                    class="btn btn-success pull-right">Add Organisation</button>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            @if (Session::has('message'))
                                <div style="margin-left:10px;">
                                    <h3 style="color: green"> {{ Session::get('message') }}</h3>
                                </div>
                            @endif
                        </div>
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Organisation</th>
                                        <th>Location</th>
                                        <th>Contact No.</th>
                                        <th>Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list)
                                        @foreach ($list as $key => $datas)
                                        <tr>
                                            <td>{{ ($key+1); }}</td>
                                            <td>{{ $datas->organisation_name; }}</td>
                                            <td>{{ $datas->location; }}</td>
                                            <td>{{ $datas->contact_no; }}</td>
                                            <td>
                                                <a href="{{ url('register/'.$datas->link) }}" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                                            </td>
                                            <td>
                                                <a href="{{ url('add-organisation/'.$datas->organisation_type.'/'.$datas->id) }}" class="btn btn-primary">View</i></a>
                                                <a class="btn btn-danger delete_item" data-id="{{ $datas->id}}" data-organisation_name="{{ $datas->organisation_name}}">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach

                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade in" id="view-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Select Organisation</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-8">
                            <a href="{{ url('add-organisation/college') }}" class="btn btn-primary">College</a>
                            <a href="{{ url('add-organisation/school') }}" class="btn btn-primary">School</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script src="{{ asset('assest/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assest/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script>
$(function() {
    $('#example2').DataTable()
    $('#example1').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
});

function view(id)
{
    $("#view-model").modal('show');
}
</script>
<script>
    $('.delete_item').on('click',function(){
      var id = $(this).data('id');
      var organisation_name = $(this).data('organisation_name');
      if(id && confirm("Are you sure, You want to delete " + organisation_name +" ?"))
      {
        $.ajax({
          url: 'delete-org',
          data: {
            "_token": "{{ csrf_token() }}",
            "id": id
            },
          type: 'post',
          success: function(response)
          {
            if(response == 'success')
            {
              alert('Deleted Successfully');
              window.location.href = "{{ url('organisation-list')}}";
            }else{
              alert("Something Went Wrong! please try again.");
            }
          }
        });

      }else{
        return false;
      }
    });
  </script>
@endsection
