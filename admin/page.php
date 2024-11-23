<?php 
    $do = '';
    if(isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ; 
    
        if($do == 'Manage'){
            echo "Category Page";
            echo '<a href="?do=Add"> Add new category +</a>';
        } elseif($do == 'Add') {
            echo "you are in Add category page";
        } elseif($do == 'Insert') {
            echo "in Insert page";
        } else {
            echo "No pages like that";
        }
?>

