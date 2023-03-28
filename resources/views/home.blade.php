@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-4 mt-3" onclick="window.location.href='{{ route('user.index') }}'">
            <div class="card-custom">
                <i class="fa fa-cog icons"></i>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-compass icons"></i>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-home icons"></i>
            </div>
        </div>
        <div class="col-lg-4 mt-3" onclick="window.location.href='{{ route('market.index') }}'">
            <div class="card-custom">
                <i class="fa fa-store icons"></i>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-server icons"></i>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card-custom">
                <i class="fa fa-tags icons"></i>
            </div>
        </div>
    </div>
@endsection
