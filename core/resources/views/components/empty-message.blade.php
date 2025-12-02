@props(['message' => $emptyMessage, 'class' => ''])
<div class="empty-message {{ $class }} d-flex flex-column justify-content-center align-items-center">
    <img src="{{ asset($activeTemplateTrue . 'images/empty.gif') }}" alt="" class="mb-3" >
    <p class="fs-5 text-muted">
        {{ __($message) }}
    </p>
</div>