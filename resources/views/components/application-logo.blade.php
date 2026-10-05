@if (file_exists(public_path('images/logo.jpeg')))
    <img src="{{ asset('images/logo.jpeg') }}" {{ $attributes }} alt="St. Peter's College logo">
@else
<svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" {{ $attributes }} aria-label="SPC Hub logo" role="img">
    <circle cx="40" cy="40" r="36" fill="#F7F1E8" stroke="#6B141A" stroke-width="3" />
    <path d="M40 11v8M40 61v8M11 40h8M61 40h8" stroke="#C7A25A" stroke-width="2" stroke-linecap="round" />
    <path d="M24 28h32v24H24z" fill="#6B141A" />
    <path d="M24 28l16-9 16 9" fill="none" stroke="#6B141A" stroke-width="3" stroke-linejoin="round" />
    <path d="M28 52c3-7 7-10 12-10s9 3 12 10" fill="none" stroke="#F7F1E8" stroke-width="2" stroke-linecap="round" />
    <circle cx="28" cy="35" r="3" fill="#2F5D3A" />
    <circle cx="52" cy="35" r="3" fill="#2F5D3A" />
    <text x="40" y="39" text-anchor="middle" fill="#F7F1E8" font-family="Georgia, serif" font-size="10" font-weight="700" letter-spacing="1">SPC</text>
    <path d="M31 59h18" stroke="#6B141A" stroke-width="2" stroke-linecap="round" />
</svg>
@endif
