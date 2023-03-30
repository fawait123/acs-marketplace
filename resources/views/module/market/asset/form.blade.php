@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ isset($id) ? route('asset.update', $id) : route('asset.store') }}" method="post">
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
                        <input type="text" class="form-control @error('color') is-invalid @enderror" placeholder="Color"
                            name="color" value="{{ isset($id) ? $asset->color : old('color') }}">
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
                        <input type="text" class="form-control @error('price') is-invalid @enderror" placeholder="price"
                            name="price" value="{{ isset($id) ? $asset->price : old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            cols="30" rows="10"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="file" name="picture" data-allowed-file-extensions="pdf png psd" class="form-control"
                            id="picture">
                    </div>
                    <div class="row">
                        @php
                            $count = isset($_GET['count']) ? $_GET['count'] : 2;
                        @endphp
                        @for ($i = 0; $i < $count; $i++)
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="file" name="asset[]" data-allowed-file-extensions="pdf png psd"
                                        class="form-control dropify" id="picture">
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
                return confirm("Do you really want to delete \"" + element.filename + "\" ?");
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
        })
    </script>
@endpush




{{-- <div class="dropify-wrapper has-error">
    <div class="dropify-message"><span class="file-icon">
            <p>Drag and drop a file here or click</p>
        </span>
        <p class="dropify-error">Ooops, something wrong appended.</p>
    </div>
    <div class="dropify-loader" style="display: none;"></div>
    <div class="dropify-errors-container">
        <ul>
            <li>The file is not allowed (pdf, png, psd only).</li>
        </ul>
    </div><input type="file" name="picture" data-allowed-file-extensions="pdf png psd" class="form-control"
        id="picture"><button type="button" class="dropify-clear">Remove</button>
    <div class="dropify-preview" style="display: none;"><span class="dropify-render"></span>
        <div class="dropify-infos">
            <div class="dropify-infos-inner">
                <p class="dropify-filename"><span class="file-icon"></span> <span
                        class="dropify-filename-inner"></span></p>
                <p class="dropify-infos-message">Drag and drop or click to replace</p>
            </div>
        </div>
    </div>
</div> --}}
