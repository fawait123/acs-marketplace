@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($id) ? route('user.update', $id) : route('user.store') }}" method="post">
                    @csrf
                    @if (isset($id))
                        @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                            name="name" value="{{ isset($id) ? $user->name : old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            placeholder="Username" name="username"
                            value="{{ isset($id) ? $user->username : old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                            name="email" value="{{ isset($id) ? $user->email : old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                            <option value="">select</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->name }}"
                                    {{ isset($id) ? ($user->roles->pluck('name')[0] == $item->name ? 'selected' : '') : '' }}>
                                    {{ $item->display_name }}</option>
                            @endforeach
                        </select>
                        @error('role')
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
        $(document).ready(function() {})
    </script>
@endpush
