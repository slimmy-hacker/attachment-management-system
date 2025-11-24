{{-- resources/views/layouts/partials/styles.blade.php --}}

{{-- -------------------------------
  Fonts
----------------------------------}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link
    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap"
    rel="stylesheet"
/>

{{-- -------------------------------
  Tailwind & JS via Vite
  Make sure "npm run dev" (for development)
  or "npm run build" (for production) is running
----------------------------------}}


{{-- -------------------------------
  External Libraries (optional)
  These load AFTER Tailwind so they can override specific styles
----------------------------------}}
<link
    href="{{ asset('/css/select2.min.css') }}"
    rel="stylesheet"
/>
<link
    href="{{ asset('/css/dataTables.dataTables.min.css')}}"
    rel="stylesheet"
/>

<style>
    .required::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
     .loading-dots::after {
         content: '';
         animation: dots 1.5s steps(5, end) infinite;
     }

    @keyframes dots {
        0%, 20% { content: ''; }
        40% { content: '.'; }
        60% { content: '..'; }
        80%, 100% { content: '...'; }
    }
</style>
