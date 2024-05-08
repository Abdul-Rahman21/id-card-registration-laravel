<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="{{ url('register/js/color-modes.js') }}"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>ID Registration</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="{{ url('register/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ url('register/style.css') }}" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        @if (Session::has('message'))
        <div>
            <h3 style="color: green"> {{ Session::get('message') }}</h3>
        </div>
        @endif
        <form action="{{ url('do_register') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h1>ID Register for {{ Str::ucfirst($find_data->organisation_name) }}</h1>
            <input type="hidden" name="organisation_type" value="{{ $find_data->organisation_type }}">
            <input type="hidden" name="organisation" value="{{ $find_data->id }}">
            <div class="form-group">
                <label for="floatingInput">Name</label>
                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="floatingInput"
                    placeholder="Name" name="name" value="{{ old('name') }}" >
                @error('name')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="floatingPassword">Contact No.</label>
                <input type="text" class="form-control @error('contact_no') is-invalid @enderror"
                    id="floatingPassword" placeholder="Contact No." name="contact_no" value="{{ old('contact_no') }}"
                    >
                @error('contact_no')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Standard / Department</label>
                <select class="form-control @error('standard') is-invalid @enderror" id="exampleFormControlSelect1"
                     name="standard">
                    <option value="">Select Any</option>
                    @foreach ($standard_list as $std)
                        <option value="{{ $std->id }}" {{ (old("standard") == $std->id ? "selected":"") }}>{{ $std->standard }}</option>
                    @endforeach
                </select>
                @error('standard')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Section / Year</label>
                <select class="form-control  @error('section') is-invalid @enderror" id="exampleFormControlSelect1"
                     name="section">
                    <option value="">Select Any</option>
                    @foreach ($section_list as $sec)
                        <option value="{{ $sec->id }}"{{ (old("section") == $sec->id ? "selected":"") }}>{{ $sec->sections }}</option>
                    @endforeach
                </select>
                @error('section')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3"
                    name="address">{{ old('address') }}</textarea>
                @error('address')
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div class="form-group">
                <label for="exampleFormControlFile1">Photo</label><br>
                <input type="file" class="form-control-file" id="Photo" name="photo">
                @error('photo')
                    <br>
                    <div style="color: red">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">submit</button>
        </form>
    </main>
    <script src="{{ url('register/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
