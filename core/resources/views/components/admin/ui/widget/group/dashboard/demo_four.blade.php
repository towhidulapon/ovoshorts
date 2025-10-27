@props(['widget'])
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.six url="{{ route('admin.short.index') }}" variant="primary" title="Total Shorts" :value="$widget['total_shorts']"
            icon="las la-video" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.six url="{{ route('admin.short.public') }}" variant="success" title="Public Shorts" :value="$widget['public_shorts']" icon="las la-play-circle" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.six url="{{ route('admin.short.private') }}" variant="danger" title="Private Shorts" :value="$widget['private_shorts']"
            icon="las la-film" />
    </div>
    <div class="col-xxl-3 col-sm-6">
        <x-admin.ui.widget.six url="{{ route('admin.short.draft') }}" variant="warning" title="Draft Shorts" :value="$widget['draft_shorts']"
            icon="las la-file-video" />
    </div>
</div>
