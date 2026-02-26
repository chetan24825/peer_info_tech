<div class="col-md-12">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-left border-success" role="alert" id="autoHideAlert">
        <strong>✔ Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-left border-danger" role="alert" id="autoHideAlert">
        <strong>⚠ Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

</div>
<script>
    setTimeout(function () {
        let alerts = document.querySelectorAll('#autoHideAlert');
        alerts.forEach(function(alert){
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300); // remove element after fade
        });
    }, 3000); // auto hide after 3 seconds
</script>
