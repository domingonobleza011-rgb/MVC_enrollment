
<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_start.php'); ?>

<style>
    .input-icons i { position: absolute; }
    .input-icons { width: 30%; margin-bottom: 10px; margin-left: 34%; }
    .icon { padding: 10px; min-width: 40px; }
    .form-control { text-align: center; }
</style>

<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 grade-page-head">
        <div>
            <h4 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-users mr-2 text-ink"></i>Grade 10 — Student List
            </h4>
            <small class="text-muted">
                All enrollees &nbsp;|&nbsp; <?= is_array($view) ? count($view) : 0 ?> student(s)
            </small>
        </div>
        <div class="grade-page-actions">
            <?php
                $grade = 'ten'; $gradeNumber = '10'; $hasCourse = true; $courseLabel = 'Course';
                $courseOptions = [
                    'ICT'        => 'ICT - Computer Programming',
                    'Animation'  => 'ICT - Animation',
                    'Cookery'    => 'Home Economics - Cookery',
                    'BAP'        => 'Home Economics - Bread and Pastry',
                    'Automotive' => 'Industrial Arts - Automotive',
                    'Welding'    => 'Industrial Arts - Welding (SMAW)',
                ];
                include(VIEWS_PATH . '/partials/admn_add_enrollee_modal.php');
            ?>
            <a href="admn_classlist.php?grade=ten" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-print mr-1"></i> Class List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php include(VIEWS_PATH . '/partials/admn_ten_search.php'); ?>
        </div>
    </div>

</div>

<?php if (!empty($_SESSION['swal'])):
    $swal = $_SESSION['swal'];
    unset($_SESSION['swal']);
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon:  '<?= $swal['icon'] ?>',
            title: '<?= addslashes($swal['title']) ?>',
            text:  '<?= addslashes($swal['text'] ?? '') ?>'
        });
    });
</script>
<?php endif; ?>

<?php include(VIEWS_PATH . '/partials/dashboard_sidebar_end.php'); ?>