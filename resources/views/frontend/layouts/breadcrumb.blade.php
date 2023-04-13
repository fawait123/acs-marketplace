@php
    $path = Request::path();
    $path = explode('/', $path);
@endphp
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb mb-5">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Shop Category page</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('welcome') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    @foreach ($path as $index => $value)
                        <a href="#">{{ $value }}
                            @if (count($path) - 1 != $index)
                                <span class="lnr lnr-arrow-right"></span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</section>
