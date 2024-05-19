@extends('admin.layouts.app')

@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Tokenfield CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css" rel="stylesheet" />

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Website Setting</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Settings</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('site-settings.create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" class="form-control" placeholder="website name" name="id" value="{{ isset($website) ? $website->id : '' }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Name:</label>
                                    <input type="text" class="form-control" placeholder="website name" name="name" value="{{ isset($website) ? $website->name : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quote</label>
                                    <input type="text" class="form-control" placeholder="Website quote" name="quote" value="{{ isset($website) ? $website->quote : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Website Email" name="email" value="{{ isset($website) ? $website->email : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" placeholder="Enter phone numbers" name="phone" id="phone" value="{{ isset($website) ? $website->phone : '' }}">
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" placeholder="Enter addresses" name="address" id="address" value="{{ isset($website) ? $website->address : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="text" class="form-control" placeholder="Website Facebook" name="facebook" value="{{ isset($website) ? $website->facebook : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Instagram</label>
                                    <input type="text" class="form-control" placeholder="Website Instagram" name="instagram" value="{{ isset($website) ? $website->instagram : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="text" class="form-control" placeholder="Website Twitter" name="twitter" value="{{ isset($website) ? $website->twitter : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Youtube</label>
                                    <input type="text" class="form-control" placeholder="Website YouTube" name="youtube" value="{{ isset($website) ? $website->youtube : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Linkedin</label>
                                    <input type="text" class="form-control" placeholder="Website LinkedIn" name="linkedin" value="{{ isset($website) ? $website->linkedin : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" class="form-control-file" name="logo">
                                    @php
                                        $defaultLogoUrl = asset('logo/d_logo.png'); // Path to your default logo
                                        $logoUrl = isset($website->logo) ? asset('logo/'.$website->logo) : $defaultLogoUrl;
                                    @endphp
                                    <img src="{{ $logoUrl }}" alt="" style="width: 100px; height: 100px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" placeholder="Enter Description" name="description">{{ isset($website) ? $website->description : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">{{ isset($website) && $website->id ? 'Update' : 'Create' }}</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('customJs')
    <!-- jQuery (necessary for Select2 and Tokenfield) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tokenfield JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Initialize tokenfield for phone and address fields -->
    <script>
        $(document).ready(function() {
            // Initialize tokenfield for phone and address inputs
            $('#phone').tokenfield({
                createTokensOnBlur: true,
                delimiter: [',', ' ']
            });

            $('#address').tokenfield({
                createTokensOnBlur: true,
                delimiter: [',', ' ']
            });

            // Initialize Select2 for all select inputs
            $('select').select2();
        });
    </script>
@endsection
