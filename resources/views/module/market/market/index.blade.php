@extends('module.app')


@section('content')
    <div class="col-md-12">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">{{ $market->owner->name }}</h3>
                <h5 class="widget-user-desc">{{ $market->name }}</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{ asset($market->picture) }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">Transaction</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">Income</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">{{ count($market->assets) }}</h5>
                            <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.widget-user -->
    </div>

    @foreach ($market->assets as $item)
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                    {{ $item->type->name }}
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <div class="row">
                                <h2 class="lead"><b>{{ $item->name }}</b></h2>
                                <div class="card-color ml-3"
                                    style="background: {{ $item->color }};width:20px;height:20px;">
                                </div>
                                <div>
                                    <p class="text-muted text-sm"><b>Mesin: </b> {{ $item->machine->name }}
                                    </p>
                                    <p class="text-muted text-sm"><b>Tahun: </b> {{ $item->year }}
                                    </p>
                                    <p class="text-muted text-sm"><b>Kilometer: </b> {{ $item->km }}
                                    </p>
                                    <p class="text-muted text-sm"><b>Stok: </b> {{ $item->stok }}
                                    </p>
                                    <p class="text-muted text-sm"><b>Harga: </b>
                                        Rp. {{ number_format($item->price, 2, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fa fa-list"></i></span>
                                    {!! $item->description !!}
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <a href="#" data-toggle="modal"
                                data-target="#modal-detail-asset{{ $loop->iteration }}"><img
                                    style="width: 100px;height: 100px;" src="{{ asset($item->picture) }}" alt="user-avatar"
                                    class="img-circle img-fluid img-thumbnail"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="modal-detail-asset{{ $loop->iteration }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Asset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section class="splide" aria-label="Splide Basic HTML Example">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide">
                                        <img src="{{ asset($item->picture) }}" alt="asset-detail" class="img-fluid">
                                    </li>
                                    @foreach ($item->details as $row)
                                        <li class="splide__slide">
                                            <img src="{{ asset($row->picture) }}" alt="asset-detail" class="img-fluid">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection

@push('customnavigation')
    @include('module.market.navigation')
@endpush

@push('customjs')
    <script>
        $('.splide').each(function() {
            new Splide(this).mount()
        })
    </script>
@endpush
