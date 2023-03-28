@extends('module.app')

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col">
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Add <i class="fa fa-plus"></i></a>
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
                                <th>Address</th>
                                <th>Telp</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
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

    {{-- modal delete --}}
    <div class="modal fade" id="modal-status">
        <div class="modal-dialog">
            <form action="{{ route('logout') }}" method="post" id="form-status">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Status Market</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure update status this market ?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@push('customnavigation')
    @include('module.core.navigation')
@endpush


@push('customjs')
    <script>
        $(document).ready(function() {
            // datatable
            $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('core.market.json') }}",
                    dataType: "json",
                    type: "GET",
                },
                columns: [{
                        data: "no"
                    }, {
                        data: "name"
                    },
                    {
                        data: "address"
                    },
                    {
                        data: "telp"
                    },
                    {
                        data: "owner"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "options"
                    }
                ],
            })


            // modal status
            $("#modal-status").on('show.bs.modal', function(event) {
                let target = event.relatedTarget;
                let uri = $(target).data('uri')
                $("#form-status").attr('action', uri)
            })
        })
    </script>
@endpush
