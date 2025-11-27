<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script src="{{ asset('/js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/js/flowbite.min.js') }}"></script>

<script src="{{ asset('/js/tailwindjs.17') }}"></script>
<script src="{{ asset('/js/sweetalert2.js') }}"></script>
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-141734189-6"></script>
<script src="{{ asset('/js/dataTables.min.js') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-141734189-6');
</script>


<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-THQTXJ7');</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        // $(document).on('click', '.close-modals-btn', function () {
        //     const modalElement = $(this).closest('[id$="-modal"]')[0];
        //     if (modalElement) {
        //         modal.hide();
        //     }
        // });


            const session_notification = @json(session('notification'));

            if (session_notification && session_notification.message) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: session_notification.icon,
            title: session_notification.message,
            message: session_notification.message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        }

    });
</script>
@yield('scripts')
