@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($id) ? route('customer.update', $id) : route('customer.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($id))
                        @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                            name="name" value="{{ isset($id) ? $customer->name : old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Username" name="username"
                            value="{{ isset($id) ? $customer->username : old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                            name="email" value="{{ isset($id) ? $customer->email : old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telp">Telp</label>
                        <input type="text" class="form-control @error('telp') is-invalid @enderror" placeholder="Telp"
                            name="telp" value="{{ isset($id) ? $customer->telp : old('telp') }}">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">select</option>
                            <option value="laki-laki"
                                {{ isset($id) ? (($customer->gender == 'laki-laki' ? 'selected' : old('gender') == 'laki-laki') ? 'selected' : '') : '' }}>
                                Laki Laki</option>
                            <option value="perempuan"
                                {{ isset($id) ? (($customer->gender == 'perempuan' ? 'selected' : old('gender') == 'perempuan') ? 'selected' : '') : '' }}>
                                Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ktp">KTP</label>
                        <input type="file" class="form-control @error('ktp') is-invalid @enderror" placeholder="KTP"
                            name="ktp" data-id="{{ isset($id) ? $customer->id : '' }}"
                            data-uri="{{ isset($id) ? $customer->ktp : '' }}"
                            data-default-file="{{ isset($id) ? ($customer->ktp == null ? '' : asset($customer->ktp)) : '' }}">
                        @error('ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Picture</label>
                        <input type="file" class="form-control @error('picture') is-invalid @enderror"
                            placeholder="Picture" data-id="{{ isset($id) ? $customer->id : '' }}"
                            data-uri="{{ isset($id) ? $customer->picture : '' }}" name="picture"
                            data-allowed-file-extensions="png jpg jpeg jfif svg"
                            data-default-file="{{ isset($id) ? ($customer->picture == null ? '' : asset($customer->picture)) : '' }}">
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Save &nbsp;&nbsp;<i
                                class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customnavigation')
    @include('module.core.navigation')
@endpush


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
                console.log(event)
                console.log(element)
                alert('Has Errors!');
            });
            drEvent.on('dropify.beforeClear', function(event, element) {
                let isTrue = confirm("Do you really want to delete \"" + element.filename + "\" ?");
                if (isTrue) {
                    let target = element.element
                    let id = $(target).data('id')
                    let uri = $(target).data('uri')
                    $.ajax({
                        url: '{{ route('customer.remove.image') }}',
                        type: 'get',
                        data: {
                            id: id,
                            uri: uri,
                            type: 'picture'
                        },
                        success: function(res) {
                            console.log(res)
                        }
                    })
                }
            });


            // drktp
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
                console.log(event)
                console.log(element)
                alert('Has Errors!');
            });
            drKtp.on('dropify.beforeClear', function(event, element) {
                let isTrue = confirm("Do you really want to delete \"" + element.filename + "\" ?");
                if (isTrue) {
                    let target = element.element
                    let id = $(target).data('id')
                    let uri = $(target).data('uri')
                    $.ajax({
                        url: '{{ route('customer.remove.image') }}',
                        type: 'get',
                        data: {
                            id: id,
                            uri: uri,
                            type: 'ktp'
                        },
                        success: function(res) {
                            console.log(res)
                        }
                    })
                }
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
