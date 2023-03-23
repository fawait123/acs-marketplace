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
                        <label for="role">Role</label>
                        <input type="text" class="form-control @error('role') is-invalid @enderror" placeholder="Role"
                            name="role" value="{{ $role->name }}" readonly>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <h3>Permission</h3>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h6 class="text-bold">Core</h6>
                        <br>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($permissions->where('prefix', 'core') as $item)
                            @php
                                $checked = $permission->where('name', $item->name)->first();
                            @endphp
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" {{ $checked ? 'checked' : '' }} value="{{ $item->name }}"
                                        class="custom-control-input" id="customSwitch{{ $no }}">
                                    <label class="custom-control-label"
                                        for="customSwitch{{ $no }}">{{ $item->display_name }}</label>
                                </div>
                            </div>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </div>
                    <div class="col-6">
                        <h6 class="text-bold">Back Office</h6>
                        <br>
                        @foreach ($permissions->where('prefix', 'back office') as $item)
                            @php
                                $checked = $permission->where('name', $item->name)->first();
                            @endphp
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" {{ $checked ? 'checked' : '' }} value="{{ $item->name }}"
                                        class="custom-control-input" id="customSwitch{{ $no }}">
                                    <label class="custom-control-label"
                                        for="customSwitch{{ $no }}">{{ $item->display_name }}</label>
                                </div>
                            </div>
                            @php
                                $no++;
                            @endphp
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customnavigation')
    @include('module.core.navigation')
@endpush


@push('customjs')
    <script>
        function getMessage(title, message, type) {
            $(document).Toasts('create', {
                title: title,
                body: message +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                class: 'bg-' + type
            })
        }
        $(document).ready(function() {
            $("input[type=checkbox]").on('change', function() {
                let permission = $("input[type=checkbox]:checked")
                let dataPermission = []
                permission = permission.each(function() {
                    let value = $(this).val()
                    dataPermission.push(value)
                })
                $.ajax({
                    url: '{{ route('role.permission.sync') }}',
                    type: 'get',
                    data: {
                        permission: dataPermission,
                        role: $("input[name=role]").val()
                    },
                    success: function(res, status, xhr) {
                        getMessage('Successfuly', 'Sync Permission has been updated', 'info')
                    },
                    error: function(err) {
                        let error = err.responseJSON
                        getMessage('Error', error.message, 'danger')
                    }
                })
            })
        })
    </script>
@endpush
