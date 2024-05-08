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
                <!--<small>Optional description</small>-->
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
                            <form action="{{ url('set-org-value') }}" method="post">
                                @csrf
                                <input type="hidden" name="org_type" value="{{ $org_type }}">
                                <input type="hidden" name="id" value="{{ optional($find_data)->id }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">{{ $name }}</label>
                                        <input type="text"
                                            class="form-control @error('organisation_name') is-invalid @enderror"
                                            name="organisation_name" id="organisation_name"
                                            value="{{ old('organisation_name', optional($find_data)->organisation_name) }}"
                                            required />
                                        @error('organisation_name')
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
                                        <label class=" control-label">{{ $standard }}</label>
                                        <select class="form-control select2 @error('standard') is-invalid @enderror"
                                            multiple="multiple" data-placeholder="Select a {{ $standard }}"
                                            style="width: 100%;" name="standard[]">
                                            @foreach ($standard_list as $std)
                                            <?php
                                                $values = optional($find_data)->standard;
                                                $array_value = [];
                                                if ($values) {
                                                    $array_value = explode(',', $values);
                                                }
                                            ?>
                                                <option value="{{ $std->id }}"
                                                    @if (in_array($std->id, $array_value)) selected = "selected"; @endif>
                                                    {{ $std->standard }}</option>
                                            @endforeach
                                        </select>
                                        @error('standard')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class=" control-label">{{ $section }}</label>
                                        <select class="form-control select2 @error('section') is-invalid @enderror"
                                            multiple="multiple" data-placeholder="Select a {{ $section }}"
                                            style="width: 100%;" name="section[]">
                                            @foreach ($section_list as $sec)
                                               <?php
                                                $value = optional($find_data)->sections;
                                                $array_value = [];
                                                if ($value) {
                                                    $array_value = explode(',', $value);
                                                }
                                                ?>

                                                <option value="{{ $sec->id }}"
                                                    @if (in_array($sec->id, $array_value)) selected = "selected"; @endif>
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
                                            name="address" required> {{ old('address', optional($find_data)->location) }} </textarea>
                                        @error('address')
                                            <div style="color: red">{{ $message }}</div>
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
