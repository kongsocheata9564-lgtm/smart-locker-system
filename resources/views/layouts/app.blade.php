<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<div class="flex min-h-screen">
    @include('partials.sidebar')

    <main class="ml-[250px] flex-1 min-h-screen bg-gray-50">
        @include('partials.header')

        <div class="p-3">
            @yield('content')
        </div>
    </main>
</div>