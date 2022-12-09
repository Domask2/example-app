<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top" style="border-bottom: 1px solid #ddd">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="color: #1890ff; font-weight: bold" >
            <img style="margin-top: -5px" src="/logo.png" width="25" /> {{ $appName }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <x-head-menu></x-head-menu>

    </div>
</nav>
