@extends('layouts.app')


@section('content')
    <div class="row">
        @if (!$market)
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Register Market</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="bs-stepper">
                            <div class="bs-stepper-header" role="tablist">
                                <!-- your steps here -->
                                <div class="step" data-target="#logins-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                                        id="logins-part-trigger">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">Company Info</span>
                                    </button>
                                </div>
                                <div class="line"></div>
                                <div class="step" data-target="#information-part">
                                    <button type="button" class="step-trigger" role="tab"
                                        aria-controls="information-part" id="information-part-trigger">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">Owner Info</span>
                                    </button>
                                </div>
                            </div>
                            <form action="{{ route('market.register.action') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="bs-stepper-content">
                                    <!-- company info -->
                                    <div id="logins-part" class="content" role="tabpanel"
                                        aria-labelledby="logins-part-trigger">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="market_name" value="{{ old('market_name') }}"
                                                class="form-control @error('market_name') is-invalid @enderror"
                                                id="name" placeholder="Enter Name">
                                            @error('market_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="telp">Telp</label>
                                            <input type="text" name="market_telp" value="{{ old('market_telp') }}"
                                                class="form-control @error('market_telp') is-invalid @enderror"
                                                id="telp" placeholder="Telp">
                                            @error('market_telp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="market_address" id="market_address" class="form-control @error('market_address') is-invalid @enderror"
                                                cols="30" rows="10">{{ old('market_address') }}</textarea>
                                            @error('market_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="picture">Picture</label>
                                            <input type="file" name="market_picture"
                                                class="form-control @error('market_picture') is-invalid @enderror"
                                                id="picture" placeholder="picture">
                                            @error('market_picture')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button class="btn btn-warning btn-sm text-white" type="button"
                                            onclick="stepper.next()">Next</button>
                                    </div>

                                    {{-- owner info --}}
                                    <div id="information-part" class="content" role="tabpanel"
                                        aria-labelledby="information-part-trigger">
                                        <div class="form-group">
                                            <label for="nik">NIK</label>
                                            <input type="text" name="nik"
                                                class="form-control @error('nik') is-invalid @enderror" id="nik"
                                                value="{{ old('nik') }}" placeholder="Nik">
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                value="{{ old('name') }}" placeholder="Name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender"
                                                class="form-control  @error('gender') is-invalid @enderror">
                                                <option value="">select</option>
                                                <option value="laki-laki"
                                                    {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>
                                                    Laki Laki</option>
                                                <option value="perempuan"
                                                    {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email"
                                                class="form-control  @error('email') is-invalid @enderror" id="email"
                                                value="{{ old('email') }}" placeholder="email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="telp">Telp.</label>
                                            <input type="text" name="telp"
                                                class="form-control  @error('telp') is-invalid @enderror" id="telp"
                                                value="{{ old('telp') }}" placeholder="Telp">
                                            @error('telp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" id="address" class="form-control  @error('address') is-invalid @enderror" cols="30"
                                                rows="10">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="ktp">KTP</label>
                                            <input type="file" name="ktp"
                                                class="form-control  @error('ktp') is-invalid @enderror" id="ktp"
                                                placeholder="ktp">
                                            @error('ktp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="picture">Picture</label>
                                            <input type="file" name="picture"
                                                class="form-control  @error('picture') is-invalid @enderror"
                                                id="picture" placeholder="picture">
                                            @error('picture')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button class="btn btn-warning btn-sm text-white" type="button"
                                            onclick="stepper.previous()">Previous</button>
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        @else
            <div class="col-12">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset($market->picture) }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $market->name }}</h3>

                        <p class="text-muted text-center">{{ $market->owner->name }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Telp</b> <a class="float-right">{{ $market->telp }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <a class="float-right">{{ $market->address }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Status Merchant</b> <a class="float-right"><span
                                        class="badge bg-{{ $market->status == 0 ? 'danger' : 'primary' }}">{{ $market->status == 0 ? 'Inactive' : 'Active' }}</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-12">
                <!-- About Me Box -->
                <div class="card card-primary card-outline">
                    <!-- /.card-header -->
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset($market->owner->picture) }}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $market->owner->name }}</h3>

                        <p class="text-muted text-center">
                            {{ $market->owner->gender == 'laki-laki' ? 'Laki Laki' : 'Perempuan' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>NIK</b> <a class="float-right">{{ $market->owner->nik }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{ $market->owner->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telp</b> <a class="float-right">{{ $market->owner->telp }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <a class="float-right">{{ $market->owner->address }}</a>
                            </li>
                            <li class="list-group-item">
                                <img src="{{ asset($market->owner->ktp) }}" class="img-fluid img-thumbnail"
                                    alt="" width="200px">
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        @endif
    </div>
    <!-- /.row -->
@endsection


@push('customjs')
    <script>
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })
    </script>
@endpush
