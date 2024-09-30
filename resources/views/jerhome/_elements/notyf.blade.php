<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Afficher les erreurs de validation
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                notyf.error("{{ $error }}");
            @endforeach
        @endif

        // Afficher les messages de session
        @if (session('success'))
            notyf.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            notyf.error("{{ session('error') }}");
        @endif

    });
</script>
