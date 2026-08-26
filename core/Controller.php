<?php
/**
 * core/Controller.php
 * ---------------------------------------------------------------------
 * Base class every Controller in app/Controllers extends.
 *
 * view() intentionally uses extract() + a plain require (not an
 * isolated/sandboxed render) because the original templates freely
 * reference model objects like $eusebia, $studenteusebia, $bmis and
 * $staffbmis inline (for sidebar badge counts, get_userdata(), etc).
 * Keeping the same variable-sharing behavior means every existing
 * view/partial keeps working unmodified after the split — only the
 * *file location* changed, not the execution model.
 */

class Controller
{
    /**
     * Render a view file from app/Views with the given data made
     * available as local variables inside it.
     *
     * @param string $__view Path relative to app/Views, without .php
     *                        e.g. 'pages/admn_seven' or 'partials/student_footer'
     * @param array  $__data Associative array extracted into the view's scope
     *
     * The parameters are named with a "__" prefix (instead of $view/$data)
     * on purpose: many controllers set a local variable literally called
     * $view (e.g. `$view = $eusebia->view_seven();`), and extract() would
     * silently overwrite this method's own $view/$data parameters with
     * that value if they were named the same thing — causing a "require
     * Array.php" fatal error. The "__" names can't collide with any real
     * page variable.
     */
    protected function view($__view, array $__data = [])
    {
        extract($__data);
        require VIEWS_PATH . '/' . $__view . '.php';
    }
}
