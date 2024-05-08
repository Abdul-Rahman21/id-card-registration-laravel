@extends('admin-layout.theme')

@section('csslink')

<link rel="stylesheet" href="{{ url('assest/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('assest/bower_components/select2/dist/css/select2.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ url('assest/dist/css/AdminLTE.min.css') }}">

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Student List
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
                            <div id="form" class="panel panel-warning" style="display: block;">
                                <div class="panel-body">
                                    <form action="{{ url('student-list') }}">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class=" control-label">Organisation</label>
                                                    <select class="form-control select2" data-placeholder="Select a Organisation"
                                                        style="width: 100%;" name="org">
                                                        <option value="">Select Any</option>
                                                        @foreach ($org_list as $org)
                                                            <option value="{{ $org->id }}"
                                                                @if ($org->id == $filter_org) selected = "selected"; @endif>
                                                                {{ $org->organisation_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class=" control-label">Standard / Department</label>
                                                    <select class="form-control select2" data-placeholder="Select a Standard / Department"
                                                        style="width: 100%;" name="standard">
                                                        <option value="">Select Any</option>
                                                        @foreach ($standard_list as $std)
                                                            <option value="{{ $std->id }}"
                                                                @if ($std->id == $filter_std) selected = "selected"; @endif>
                                                                {{ $std->standard }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class=" control-label">Section / Year</label>
                                                    <select class="form-control select2" data-placeholder="Select a Section / Year"
                                                        style="width: 100%;" name="section">
                                                        <option value="">Select Any</option>
                                                        @foreach ($section_list as $sec)
                                                            <option value="{{ $sec->id }}"
                                                                @if ($sec->id == $filter_sec) selected = "selected"; @endif>
                                                                {{ $sec->sections }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <button style="margin-top: 25px;" type="submit"
                                                    class="btn btn-primary">Submit</button>
                                                <a style="margin-top: 25px;" href="{{ url('student-list')}}"
                                                    class="btn btn-default">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Standard / Department</th>
                                        <th>Section / Year</th>
                                        <th>Contact No.</th>
                                        <th>Address</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list)
                                        @foreach ($list as $key => $datas)
                                        <tr>
                                            <td>{{ ($key+1); }}</td>
                                            <td>{{ $datas->name; }}</td>
                                            <td>{{ getColumnvalue('standard','standards',"WHERE id = '$datas->standard'")->standard; }}</td>
                                            <td>{{ getColumnvalue('sections','sections',"WHERE id = '$datas->section'")->sections; }}</td>
                                            <td>{{ getColumnvalue('organisation_name','organisations',"WHERE id = '$datas->organisation'")->organisation_name; }}</td>
                                            <td>{{ $datas->address; }}</td>
                                            <td>
                                                <a href="{{ url('image/'.$datas->photo) }}" target="_blank"><img src="{{ url('image/'.$datas->photo)}}" alt="Studend-image"  width="200px" height="100px"></a>
                                            </td>
                                            <td>
                                                <a href="{{ url('student-edit/'.$datas->id) }}" class="btn btn-primary">View</i></a>
                                                <a class="btn btn-danger delete_student" data-id="{{ $datas->id }}" data-name="{{ $datas->name}}">Delete</a>
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
@endsection

@section('script')

<script src="{{ url('assest/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
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

$('.select2').select2()

</script>
<script>
    $('.delete_student').on('click',function(){
      var id = $(this).data('id');
      var name = $(this).data('name');
      if(id && confirm("Are you sure, You want to delete " + name +" ?"))
      {
        $.ajax({
          url: 'delete-student',
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
              window.location.href = "{{ url('student-list')}}";
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
