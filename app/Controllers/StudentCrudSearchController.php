<?php

class StudentCrudSearchController extends Controller
{
    public function index()
    {
 
    require(MODELS_PATH . '/student.class.php');

    $view = $studentbmis->view_household_list();
    $studentbmis->create_student();
    $studentbmis->update_student();
    $studentbmis->delete_student();

    //$lname = $_GET['lname'];

    $connection = $studentbmis->openConn();

    //$stmt = $connection->prepare("SELECT * from tbl_student 
    //WHERE lname LIKE '%$lname%'");
    //$stmt->execute();
    //$view = $stmt->fetch();
   

        $this->view('pages/student_crud_search', get_defined_vars());
    }
}
