@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col">
                <a href="{{ route('type.create') }}" class="btn btn-primary btn-sm">Add <i class="fa fa-plus"></i></a>
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
                                <th>Created By</th>
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
    @include('module.core.navigation')
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
                    url: "{{ route('type.json') }}",
                    dataType: "json",
                    type: "GET",
                },
                columns: [{
                        data: "no"
                    }, {
                        data: "name"
                    },
                    {
                        data: "created_by"
                    },
                    {
                        data: "options"
                    }
                ],
            })
        })
    </script>
@endpush
