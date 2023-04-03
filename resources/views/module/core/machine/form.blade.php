@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($id) ? route('machine.update', $id) : route('machine.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($id))
                        @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                            name="name" value="{{ isset($id) ? $machine->name : old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="picture">Picture</label>
                        <input type="file" class="form-control @error('picture') is-invalid @enderror"
                            placeholder="Picture" name="picture" data-allowed-file-extensions="png jpg jpeg jfif svg"
                            data-default-file="{{ isset($id) ? ($machine->picture == null ? '' : asset($machine->picture)) : '' }}"
                            data-id="{{ isset($id) ? $machine->id : '' }}"
                            data-uri="{{ isset($id) ? $machine->picture : '' }}" data-source="Asset"
                            value="{{ isset($id) ? $machine->picture : old('picture') }}">
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
                        url: '{{ route('machine.remove.image') }}',
                        type: 'get',
                        data: {
                            id: id,
                            uri: uri,
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
