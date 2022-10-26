<x-guest-layout>

    <x-slot name="extra_css">
        <style>
            .section .section-lead {
                margin-left: 0px!important;
            }
            .main-wrapper.container {
                width: 100%;
                max-width: 100%;
                padding: 0px;
            }
        </style>
    </x-slot>

    <div class="main-content">
        <section class="section">
            <div class="section-header"></div>
            <div class="section-body"></div>
        </section>
    </div>

    <x-slot name="extra_js">
        <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js') }}"></script>
        <script>
            swal({
                title: "Verifikasi Email Berhasil!",
                icon: "success",
                button: "Close!",
                closeOnClickOutside: false,
            })
            .then(willDelete => {
                window.location.replace("{{ route('profile.index') }}");
            });
        </script>
    </x-slot>
    
</x-guest-layout>