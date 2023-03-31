@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($id) ? route('asset.update', $id) : route('asset.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($id))
                        @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                            name="name" value="{{ isset($id) ? $asset->name : old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="machine">Machine</label>
                        <select name="machine_id" id="machine"
                            class="form-control @error('machine_id') is-invalid @enderror">
                            <option value="">select</option>
                            @foreach ($machine as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($id) ? ($item->id == $asset->machine_id ? 'selected' : '') : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('machine_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type_id" id="type" class="form-control @error('type_id') is-invalid @enderror">
                            <option value="">select</option>
                            @foreach ($type as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($id) ? ($item->id == $asset->type_id ? 'selected' : '') : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color">Color</label>
                        <div class="input-group my-colorpicker2">
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                placeholder="Color" name="color" value="{{ isset($id) ? $asset->color : old('color') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-square"
                                        style="{{ isset($id) ? 'color:' . $asset->color : '' }}"></i></span>
                            </div>
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="km">Kilometer</label>
                        <input type="text" class="form-control @error('km') is-invalid @enderror" placeholder="km"
                            name="km" value="{{ isset($id) ? $asset->km : old('km') }}">
                        @error('km')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" placeholder="year"
                            name="year" value="{{ isset($id) ? $asset->year : old('year') }}">
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control @error('stok') is-invalid @enderror" placeholder="stok"
                            name="stok" value="{{ isset($id) ? $asset->stok : old('stok') }}">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" id="price" class="form-control @error('price') is-invalid @enderror"
                            placeholder="price" name="price" value="{{ isset($id) ? $asset->price : old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            cols="30" rows="10">{{ isset($id) ? $asset->description : old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="file" name="picture"
                            data-default-file="{{ isset($id) ? asset($asset->picture) : '' }}"
                            data-id="{{ isset($id) ? $asset->id : '' }}"
                            data-uri="{{ isset($id) ? $asset->picture : '' }}"
                            data-allowed-file-extensions="png jpg jpeg jfif svg" class="form-control" id="picture">
                    </div>
                    <div class="row">
                        @php
                            $count = isset($_GET['count']) ? $_GET['count'] : 2;
                            $count = isset($id) ? count($asset->details) : $count;
                        @endphp
                        @for ($i = 0; $i < $count; $i++)
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="file" name="asset[]"
                                        data-id="{{ isset($id) ? $asset->details[$i]->id : '' }}"
                                        data-uri="{{ isset($id) ? $asset->details[$i]->picture : '' }}"
                                        data-default-file="{{ isset($id) ? asset($asset->details[$i]->picture) : '' }}"
                                        data-allowed-file-extensions="png jpg jpeg jfif svg" class="form-control dropify"
                                        id="picture">
                                </div>
                            </div>
                        @endfor

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
    @include('module.market.navigation')
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
                        url: '{{ route('asset.remove.image') }}',
                        type: 'get',
                        data: {
                            id: id,
                            uri: uri
                        },
                        success: function(res) {
                            console.log(res)
                        }
                    })
                }
            });

            let drAsset = $(".dropify").dropify({
                error: {
                    'fileSize': 'The file size is too big.',
                    'minWidth': 'The image width is too small.',
                    'maxWidth': 'The image width is too big.',
                    'minHeight': 'The image height is too small.',
                    'maxHeight': 'The image height is too big.',
                    'imageFormat': 'The image format is not allowed.'
                }
            });

            drAsset.on('dropify.errors', function(event, element) {
                console.log(event)
                console.log(element)
                alert('Has Errors!');
            });

            drAsset.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.filename + "\" ?");
            });



            // query string
            const urlParams = new URLSearchParams(window.location.search);
            const myParam = urlParams.get('count');

            // color picker
            $('.my-colorpicker2').colorpicker()
            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            // Summernote
            $('#description').summernote()

            // auto numeric
            new AutoNumeric(document.getElementById('price'), {
                decimalPlaces: 0
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

@for ($i = 0; $i < $count; $i++)
    @if ($errors->has('asset.' . $i))
        @push('customjs')
            <script>
                $(document).ready(function() {
                    let element = $(".dropify")[{{ $i }}];
                    $(element).parent().addClass('has-error')
                    $(element).parent().find('.dropify-errors-container').html(`<ul>
                    <li>{{ $errors->get('asset.' . $i)[0] }}</li>
                </ul>`)
                })
            </script>
        @endpush
    @endif
@endfor
