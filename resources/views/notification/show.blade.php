@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Read Notification</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h5>{{ $notif->title }}</h5>
                    </div>
                    <div class="mailbox-read-message">
                        <p>Hello {{ $notif->userTo->name }},</p>
                        {{ $notif->body }}
                        <br>
                        <br>
                        <br>
                        @if ($notif->userFrom->is_active == 0)
                            <form action="{{ route('user.status', $notif->userFrom->id) }}" method="post">
                                @csrf
                                <button class="btn btn-primary btn-sm">Active Account</button>
                            </form>
                        @else
                            <p>Status Account, <span class="badge bg-primary">Active</span></p>
                        @endif
                        <br>
                        <br>
                        <br>

                        <p>Thanks,<br>{{ $notif->userFrom->name }}</p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-footer -->
                <div class="card-footer">
                    <button type="button" data-toggle="modal" data-target="#modal-destroy-notification"
                        data-uri="{{ route('notification.destroy', $notif->id) }}" class="btn btn-default"><i
                            class="far fa-trash-alt"></i> Delete</button>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
