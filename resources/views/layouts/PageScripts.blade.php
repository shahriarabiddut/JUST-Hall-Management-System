<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}" defer></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}" defer></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}" defer></script>

<!-- Page level plugins -->
<script defer src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script defer src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script defer src="{{ asset('js/demo/datatables-demo.js') }}"></script>
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<script>
    // Disable once click submit
    document.addEventListener('DOMContentLoaded', function() {
    let forms = document.getElementsByTagName('form');
    
    for (let i = 0; i < 1; i++) {
        forms[i].addEventListener('submit', function() {
            let submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
        });
    }
});

</script>
@include('../layouts/validateinput')