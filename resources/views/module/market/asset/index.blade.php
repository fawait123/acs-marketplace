@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col">
                <a href="{{ route('asset.create') }}" class="btn btn-primary btn-sm">Add <i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatables">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Machine</th>
                                <th>Type</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            // datatable
            console.log('okeee')
            $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('asset.json') }}",
                    dataType: "json",
                    type: "GET",
                },
                columns: [{
                        data: "no"
                    }, {
                        data: "name"
                    },
                    {
                        data: "machine"
                    },
                    {
                        data: "type"
                    },
                    {
                        data: "color"
                    },
                    {
                        data: "price"
                    },
                    {
                        data: "year"
                    },
                    {
                        data: "options"
                    }
                ],
            })
        })
    </script>
@endpush
