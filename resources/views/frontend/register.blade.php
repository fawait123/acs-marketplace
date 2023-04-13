@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.breadcrumb')
    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ asset('img/bg-3.jpg') }}" alt="">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of this
                                is the</p>
                            <a class="primary-btn" href="{{ route('customer.auth.login') }}">Login</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Register</h3>
                        <form class="row login_form" action="{{ route('customer.auth.register.action') }}" method="post"
                            id="contactForm" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Name" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Name'" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <select name="gender" id="gender"
                                    class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">select</option>
                                    <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki Laki
                                    </option>
                                    <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="name" name="username" placeholder="Username" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Username'" value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Password'">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="name" name="email" placeholder="Email" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Email'" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                    id="name" name="telp" placeholder="Telp" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Telp'" value="{{ old('telp') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="file" class="form-control @error('picture') is-invalid @enderror"
                                    id="name" data-allowed-file-extensions="png jpg jpeg jfif svg" name="picture"
                                    placeholder="Picture" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Picture'">
                                @error('picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="file" class="form-control @error('ktp') is-invalid @enderror" id="name"
                                    name="ktp" data-allowed-file-extensions="png jpg jpeg jfif svg" placeholder="KTP"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'KTP'">
                                @error('ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="primary-btn">Register</button>
                                <a href="{{ route('customer.auth.login') }}">Already account ? login?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->
@endsection
@push('customjs')
    <script>
        $(document).ready(function() {
            let drEvent = $("input[name=picture]").dropify({
                error: {
                    'fileSize': 'The file size is too big.',
                    'minWidth': 'The image width is too small.',
                    'maxWidth': 'The image width is too big.',
                    'minHeight': 'The image height is too small.',
                    'maxHeight': 'The image height is too big.',
                    'imageFormat': 'The image format is not allowed.'
                }
            });

            drEvent.on('dropify.errors', function(event, element) {
                alert('Has Errors!');
            });

            let drKtp = $("input[name=ktp]").dropify({
                error: {
                    'fileSize': 'The file size is too big.',
                    'minWidth': 'The image width is too small.',
                    'maxWidth': 'The image width is too big.',
                    'minHeight': 'The image height is too small.',
                    'maxHeight': 'The image height is too big.',
                    'imageFormat': 'The image format is not allowed.'
                }
            });

            drKtp.on('dropify.errors', function(event, element) {
                alert('Has Errors!');
            });
        })
    </script>
@endpush

@error('picture')
    @push('customjs')
        <script>
            $(document).ready(function() {
                $("input[name=picture]").parent().addClass('has-error')
                $("input[name=picture]").parent().find('.dropify-errors-container').html(`<ul>
                    <li>{{ $message }}</li>
                </ul>`)
            })
        </script>
    @endpush
@enderror

@error('ktp')
    @push('customjs')
        <script>
            $(document).ready(function() {
                $("input[name=ktp]").parent().addClass('has-error')
                $("input[name=ktp]").parent().find('.dropify-errors-container').html(`<ul>
                    <li>{{ $message }}</li>
                </ul>`)
            })
        </script>
    @endpush
@enderror
