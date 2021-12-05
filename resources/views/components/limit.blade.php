<div class="p-5 text-center text-gray-400">
    <i class="{{ $icon ?? 'fad fa-info-circle' }} fa-5x mb-3"></i>
    <h5>{{ $text ?? 'کوپن شما بدون محدودیت است' }}</h5>
    {{ $slot ?? null }}
</div>
