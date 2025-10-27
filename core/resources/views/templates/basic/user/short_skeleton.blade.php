<div id="skeleton-loader" class="d-none">
    <div class="row g-3">
        @for ($i = 0; $i < 12; $i++)
            <div class="col-6 col-md-2">
                <div class="skeleton-card">
                    <div class="skeleton-thumb placeholder-glow">
                        <span class="placeholder w-100 h-100"></span>
                    </div>
                    <div class="skeleton-body">
                        <div class="placeholder-glow mb-2 d-flex align-items-center gap-2">
                            <div class="thumb skeleton-avatar"></div>
                            <span class="placeholder col-8"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>


@push('style')
    <style>
        .skeleton-card {
            background: #111;
            border-radius: 8px;
            overflow: hidden;
        }

        .skeleton-thumb {
            width: 171px;
            height: 313px;
            margin: 0 auto;
            border-radius: 6px;
            background: #222;
        }

        .skeleton-body {
            padding: 6px;
        }

        .placeholder {
            background-color: #2c2c2c !important;
        }

        .placeholder-glow .placeholder {
            background: linear-gradient(90deg, #2c2c2c 25%, #3a3a3a 50%, #2c2c2c 75%);
            background-size: 200% 100%;
            animation: placeholder-shimmer 1.5s infinite;
        }

        .skeleton-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #2c2c2c;
        }

        .placeholder-glow .skeleton-avatar {
            background: linear-gradient(90deg,
                    #2c2c2c 25%,
                    #3a3a3a 50%,
                    #2c2c2c 75%);
            background-size: 200% 100%;
            animation: placeholder-shimmer 1.5s infinite;
        }


        @keyframes placeholder-shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>
@endpush