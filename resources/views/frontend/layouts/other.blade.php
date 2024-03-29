<section class="related-product-area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-title">
                    <h1>Other Products</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore
                        magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @foreach ($assetRandom as $item)
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="{{ route('frontend.product.show', $item->id) }}">
                                    <div
                                        style="width: 60px;height: 60px; border-radius: 5px;background: black; overflow: hidden;background-size: contain;">
                                        <img src="{{ asset($item->picture) }}" alt=""
                                            style="width: 60px;height: 60px; background-size:contain; ">
                                    </div>
                                </a>
                                <div class="desc">
                                    <a href="#" class="title">{{ $item->name }}</a>
                                    <div class="price">
                                        <h6>RP{{ number_format($item->price, 2, ',', '.') }}</h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ctg-right">
                    <a href="#" target="_blank">
                        <img class="img-fluid d-block mx-auto" src="{{ asset('frontend') }}/img/category/c5.jpg"
                            alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End related-product Area -->
