@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.breadcrumb')
    <!-- End Banner Area -->
    <div class="container">
        <section class="lattest-product-area pb-40 category-list">
            <div class="row">
                @if (count($products) > 0)
                    @foreach ($products as $item)
                        <!-- single product -->
                        <div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <img class="img-fluid" src="{{ asset($item->picture) }}" alt="">
                                <div class="product-details">
                                    <h6>{{ $item->name }}</h6>
                                    <div class="price">
                                        <h6>RP{{ number_format($item->price, 2, ',', '.') }}</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                    <div class="prd-bottom">

                                        <a href="" class="social-info">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-sync"></span>
                                            <p class="hover-text">compare</p>
                                        </a>
                                        <a href="{{ route('frontend.product.show', $item->id) }}" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h1 class="text-center m-5">No data found</h1>
                @endif
            </div>
        </section>
    </div>
@endsection
