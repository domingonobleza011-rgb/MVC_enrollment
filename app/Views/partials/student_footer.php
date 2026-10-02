<?php
/**
 * Shared student footer include.
 * Edit this file to change the footer on every page that includes it.
 */
?>
<style>
    /* Sticky footer: keeps the footer pinned to the bottom of the viewport
       when the page content is shorter than the screen (e.g. zoomed out). */
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .footer-custom {
        margin-top: auto;
    }
</style>
<footer class="footer-custom">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-12">
                <i class="fas fa-school me-2"></i> Eusebia Paz Arroyo Memorial National High School
            </div>
        </div>
    </div>
</footer>

<script>
(function () {
    // Auto-uppercase the Learner / Father's / Mother's name fields on every
    // grade-level enrollment form (Grade 7–12 all share these field names),
    // as the student types. The database also uppercases on save as a
    // backstop, but doing it live here means the student sees exactly what
    // gets submitted.
    var upperFieldNames = ['lname', 'fname', 'mi', 'ffname', 'flname', 'fmi', 'mfname', 'mlname', 'mmi'];

    upperFieldNames.forEach(function (name) {
        document.querySelectorAll('input[name="' + name + '"]').forEach(function (el) {
            el.style.textTransform = 'uppercase';
            el.addEventListener('input', function () {
                var pos = el.selectionStart;
                el.value = el.value.toUpperCase();
                if (pos !== null && el.setSelectionRange) el.setSelectionRange(pos, pos);
            });
        });
    });
})();
</script>