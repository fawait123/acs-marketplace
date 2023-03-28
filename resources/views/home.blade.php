@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-4 mt-3" onclick="window.location.href='{{ route('user.index') }}'">
            <div class="card-custom">
                <i class="fa fa-cog icons"></i>
                <h5 class="card-title-custom">Core</h5>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-compass icons"></i>
                <h5 class="card-title-custom">Back Office</h5>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-home icons"></i>
                <h5 class="card-title-custom">Dashboard</h5>
            </div>
        </div>
        <div class="col-lg-4 mt-3" onclick="window.location.href='{{ route('market.index') }}'">
            <div class="card-custom">
                <i class="fa fa-store icons"></i>
                <h5 class="card-title-custom">Merchant</h5>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-server icons"></i>
                <h5 class="card-title-custom">Database</h5>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-tags icons"></i>
                <h5 class="card-title-custom">Lain Lain</h5>
            </div>
        </div>
    </div>
@endsection
