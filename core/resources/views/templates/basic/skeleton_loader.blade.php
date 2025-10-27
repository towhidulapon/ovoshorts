<div class="skeleton-loader">
    <div class="row g-3">
        @for ($i = 0; $i < 12; $i++)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="skeleton-card">
                    <div class="skeleton-thumb placeholder-glow">
                        <span class="placeholder w-100 h-100"></span>
                    </div>
                    <div class="skeleton-body">
                        <div class="placeholder-glow mb-2">
                            <span class="placeholder col-8"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>