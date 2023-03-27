@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Notification</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                @if (count($notif) > 0)
                                    @foreach ($notif as $item)
                                        <tr>
                                            <td class="mailbox-star"><a href="{{ route('notification.show', $item->id) }}"><i
                                                        class="fas fa-star text-{{ $item->is_read == 1 ? 'secondary' : 'warning' }}"></i></a>
                                            </td>
                                            <td class="mailbox-name"><a
                                                    href="{{ route('notification.show', $item->id) }}">{{ $item->userFrom->name }}</a>
                                            </td>
                                            <td class="mailbox-subject"><b>{{ $item->title }}</b> - {{ $item->body }}
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">{{ $item->created_at->diffForHumans() }}</td>
                                            <td><a href="#" class="text-secondary" data-toggle="modal"
                                                    data-target="#modal-destroy-notification"
                                                    data-uri="{{ route('notification.destroy', $item->id) }}"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" align="center">Notification not found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection


@push('customjs')
    <script>
        $(document).ready(function() {
            $("#modal-destroy-notification").on('show.bs.modal', function(event) {
                let target = event.relatedTarget
                let uri = $(target).data('uri')
                $("#form-delete-notification").attr('action', uri)
            })
        })
    </script>
@endpush
