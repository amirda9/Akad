<div class="toast bg-{{ $type ?? 'secondary' }} text-white" data-autohide="false"
     style="position: fixed; left: 20px; bottom: 20px; z-index: 11;">
    <div class="toast-header bg-{{ $type ?? 'secondary' }} text-white">
        <strong class="ml-auto">{{ $title ?? 'پیام' }}</strong>
        <button type="button" class="mr-2 mt-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        @if($message ?? false)
            {{ $message }}
        @endif
        @if($messages ?? false)
            <ul class="list-unstyled m-0">
                @foreach ($messages as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>