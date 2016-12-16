<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'language' => config('app.locale')
    ]) !!}
</script>