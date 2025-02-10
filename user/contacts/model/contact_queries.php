<?php
$query='';
function fetch_user_contacts($db,){
    //connection a base de dato
   
    $query = 'SELECT * FROM user_contacts';
    $statement = $db->prepare($query);
    $statement->execute();
    $query_results = $statement->fetchAll();
    $statement->closeCursor();
    return $query_results;
}

function  search_user_contact($db,$search_input){
   
    $query = 'SELECT * FROM user_contacts WHERE contact_fullname LIKE :search_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':search_name', "%".$search_input."%");
    $statement->execute();
    $query_results = $statement->fetchAll();
    $statement->closeCursor();
    return $query_results;
}

function  load_contact_select($db,$select_id){
   
    $query = 'SELECT * FROM user_contacts WHERE contact_id = :search_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':search_id', $select_id, PDO::PARAM_INT);
    $statement->execute();
    $query_results = $statement->fetch();
    $statement->closeCursor();
    return $query_results;
}

function edit_selected_contact($db,$edit_id, $edit_name, $edit_mobile, $edit_email, $edit_company) {
   

    try {

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        $query = "UPDATE user_contacts SET 
                  contact_fullname = :edit_name,
                  contact_mobile = :edit_mobile,
                  contact_email = :edit_email,
                  contact_company = :edit_company
                  WHERE contact_id = :edit_id" ;
                //   +"SELECT contact_fullname
                //   FROM user_contacts
                //   ORDER BY contact_fullname ASC"

        $statement = $db->prepare($query);

        $statement->bindValue(':edit_name', $edit_name, PDO::PARAM_STR);
        $statement->bindValue(':edit_mobile', $edit_mobile, PDO::PARAM_INT);
        $statement->bindValue(':edit_email', $edit_email, PDO::PARAM_STR);
        $statement->bindValue(':edit_company', $edit_company, PDO::PARAM_STR);
        $statement->bindValue(':edit_id', $edit_id, PDO::PARAM_INT);
        $statement->execute();
        $rows_affected = $statement->rowCount(); 
        $statement->closeCursor();
        return $rows_affected;

    } catch (PDOException $e) {

        error_log("Database Error: " . $e->getMessage());
        return false; 
    }
}

function  del_contact_select($db,$del_id){
   
    // print_r('test');
    //connection a base de dato

    $query = 'DELETE FROM user_contacts WHERE contact_id = :search_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':search_id', $del_id, PDO::PARAM_INT);
    $statement->execute();
    $query_results = $statement->fetch();
    $statement->closeCursor();
    return $query_results;
}

function add_contact($db,$add_name, $add_mobile, $add_email, $add_company) {
   

    try {

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        $query = "INSERT INTO user_contacts 
                (contact_id, contact_fullname, contact_mobile, contact_email, contact_company) 
                VALUES (NULL, :add_name, :add_mobile, :add_email, :add_company)";

        $statement = $db->prepare($query);

        $statement->bindValue(':add_name', $add_name, PDO::PARAM_STR);
        $statement->bindValue(':add_mobile', $add_mobile, PDO::PARAM_INT);
        $statement->bindValue(':add_email', $add_email, PDO::PARAM_STR);
        $statement->bindValue(':add_company', $add_company, PDO::PARAM_STR);
    
        $statement->execute();
        $rows_affected = $statement->rowCount(); 
        $statement->closeCursor();

        return $rows_affected;

    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false; 
    }
}
?>