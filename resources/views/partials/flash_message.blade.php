@if (session('flash_message'))
    <script type="text/javascript">
        new PNotify({
            title: 'Watch out!',
            text: '{{ session('flash_message') }}'
        });
    </script>
@endif
