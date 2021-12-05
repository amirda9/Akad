@if($notification->read_at)
    <div class="alert bg-gray-100 text-gray-500 notification-alert">
        <strong>{{ $notification->data['title'] ?? '' }}</strong>
        <p>{{$notification->data['content']}}</p>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a class="btn btn-sm btn-gray-200 text-gray-500" href="{{ route('user.notifications.show',$notification) }}">
                <small>مشاهده</small>
            </a>
            <div>
                <small>{{ jd($notification->created_at) }}</small>
                <a class="btn-remove-notification text-gray-400 mx-1 px-1" href="{{route('user.notifications.delete',$notification->id)}}" title="حذف">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info notification-alert">
        <strong>{{ $notification->data['title'] ?? '' }}</strong>
        <p>{{ $notification->data['content'] ?? '' }}</p>
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a class="btn btn-sm btn-primary" href="{{ route('user.notifications.show',$notification) }}">
                <small>مشاهده</small>
            </a>
            <div>
                <small>{{ jd($notification->created_at) }}</small>
                <a class="btn-mark-as-read-notification mx-1 px-1" href="{{route('user.notifications.read',$notification->id)}}" title="خواندم">
                    <i class="fa fa-check"></i>
                </a>
                <a class="btn-remove-notification mx-1 px-1" href="{{route('user.notifications.delete',$notification->id)}}" title="حذف">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
@endif
