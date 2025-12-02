<div class="explore-section">

    @include('Template::user.short_skeleton')

    <div class="explore-item-wrapper explore-shorts">

        @forelse ($collection as $item)

            @php
                info($collection->count());
            @endphp
            @include('Template::user.video_item', [
                'short' => $item->short ?? $item,
                'fileUrl' => $item->fileUrl,
                'extension' => $item->extension,
            ])
        @empty
            @if(request()->input('page', 1) == 1)

                 <x-empty-message message="No shorts found" />

            @endif
        @endforelse
    </div>
</div>