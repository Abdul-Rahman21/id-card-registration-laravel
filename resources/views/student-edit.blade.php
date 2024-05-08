@extends('admin-layout.theme')

@section('csslink')
    <link rel="stylesheet" href="{{ url('assest/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assest/dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Add Organisation
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-default">
                @if (Session::has('message'))
                    <div style="margin-left:100px;">
                        <h3 style="color: green"> {{ Session::get('message') }}</h3>
                    </div>
                @endif
                <div class="box-header with-border">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <form action="{{ url('set-std-value') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ optional($find_data)->id }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name"
                                            value="{{ old('name', optional($find_data)->name) }}"
                                            required />
                                        @error('name')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label">Contact No.</label>
                                        <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                                            name="contact_no" id="contact_no"
                                            value="{{ old('contact_no', optional($find_data)->contact_no) }}" required>
                                        @error('contact_no')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label">Standard / Department</label>
                                        <select class="form-control select2 @error('standard') is-invalid @enderror" data-placeholder="Select a Standard / Department"
                                            style="width: 100%;" name="standard">
                                            @foreach ($standard_list as $std)
                                            <?php $values = optional($find_data)->standard; ?>
                                                <option value="{{ $std->id }}"
                                                    @if ($std->id == $values) selected = "selected"; @endif>
                                                    {{ $std->standard }}</option>
                                            @endforeach
                                        </select>
                                        @error('standard')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label">Section / Year</label>
                                        <select class="form-control select2 @error('section') is-invalid @enderror" data-placeholder="Select a Section / Year"
                                            style="width: 100%;" name="section">
                                            @foreach ($section_list as $sec)
                                               <?php $value = optional($find_data)->section; ?>
                                                <option value="{{ $sec->id }}"
                                                    @if ($sec->id == $value) selected = "selected"; @endif>
                                                    {{ $sec->sections }}</option>
                                            @endforeach
                                        </select>
                                        @error('section')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" rows="3" placeholder="address"
                                            name="address" required> {{ old('address', optional($find_data)->address) }} </textarea>
                                        @error('address')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Photo</label>
                                        <img src="{{ url('image/'.optional($find_data)->photo) }}" alt="" width="200px" height="100px">
                                        <input type="file" id="exampleInputFile" name="photo" class="@error('photo') is-invalid @enderror">
                                        @error('photo')
                                            <br><div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary pressbutton">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <!--Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
                                      the plugin.-->
                    </div>
                </div>
                <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script src="{{ url('assest/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2()
    </script>
@endsection
