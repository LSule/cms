<?php
require "../model/contact_queries.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_request = filter_input(INPUT_POST, 'user_request');
} else {
    $user_request = filter_input(INPUT_GET, 'user_request');
    
}

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if ($errno === E_WARNING) {
        // Convert warning to an exception
        throw new ErrorException("Warning: $errstr in $errfile on line $errline", 0, $errno, $errfile, $errline);
    }
    // For other error types, use the default handler
    return false;
});






switch($user_request) {
    //! Fetch all contacts
        case 'open_empty_contact_modal':
            try{
                //? incluir la conexión a la base de datos
                include '../../../utilities/db_conn.php';
                 //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
                $content = '';
                ob_start();
                include "../components/create_contact_modal_view.php";
                $content = ob_get_clean();

                echo json_encode(['status' => 'success', 'view' => $content]);
            } catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }

            break;
        case 'fetch_all_contacts':
            try{
                //? incluir la conexión a la base de datos
                include '../../../utilities/db_conn.php';
                //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
                $user_contacts = fetch_user_contacts($db);
                $content = '';
                ob_start();
                    foreach($user_contacts as $contact):
                        //Making variable
                        $contact_id = $contact['contact_id'];
                        $contact_fullname = $contact['contact_fullname'];
                        //call view x3 once per row
                        include "../components/row_view.php";
                    endforeach; 
                $content = ob_get_clean();
                echo json_encode(['status' => 'success', 'view' => $content, 'variable_data' => $contact]);
            } catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }

            break;
        case 'search_user_contact':

            try{
            //? incluir la conexión a la base de datos
            include '../../../utilities/db_conn.php';
             //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
    

            $search_input = filter_input(INPUT_POST, 'search_input');
            
            if($search_input !=" " ){
                $search_contact=search_user_contact($db, $search_input);  
                //print_r($search_contact);    
                if (!empty($search_contact)) { 
                    //! Generar la vista
                    $content = '';
                    ob_start();
                    foreach ($search_contact as $contact): 
                        $contact_fullname = $contact['contact_fullname'];
                        $contact_id = $contact['contact_id'];
                        include  "../components/row_view.php";
                    endforeach;
                    $content .= ob_get_clean();
                }
            }else{
                $content = "No Contacts";
            }
                //? Hacer eco para manejar en javascript
                echo json_encode(['status' => 'success', 'view' => $content, 'variable_data' => $search_contact]);
            } catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }


            

            break;    
        case 'load_contact_select':
            try{
            //? incluir la conexión a la base de datos
            include '../../../utilities/db_conn.php';
             //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
            $select_id = filter_input(INPUT_POST, 'select_id', FILTER_SANITIZE_NUMBER_INT);
            $contact = load_contact_select($db, $select_id); 

            //! Generar la vista
            $content = '';
            ob_start();
            $contact_id = $contact['contact_id'];
            $contact_fullname = $contact['contact_fullname'];
            $contact_mobile = $contact['contact_mobile'];
            $contact_email = $contact['contact_email'];
            $contact_company = $contact['contact_company'];
            include  "../components/contact_modal_view.php";
            $content = ob_get_clean();

            //? Hacer eco para manejar en javascript
            echo json_encode(['status' => 'success', 'view' => $content, 'variable_data' => $contact]);
        } catch (PDOException $e) {
            //? Ocurre cuando hay un error en la base datos o en el modelo
            error_log('Database Error: ' . $e->getMessage());
            $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        } catch (ErrorException $e) {
            //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
            error_log('Warning converted to Exception: ' . $e->getMessage());
            $message = $development_mode ? $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        } catch (Exception $e) {
            //? Ocurre cuando hay un error fatal 
            error_log('Error: ' . $e->getMessage());
            $message = $development_mode ?  $e->getMessage() : $user_message;
            echo json_encode(['status' => 'error', 'message' => $message]);
        }
            break;


        case 'edit_selected_contact':
            try{
                //? incluir la conexión a la base de datos
                include '../../../utilities/db_conn.php';
                //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
                //! Iniciar la transición
                $db->beginTransaction();

                $edit_id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_NUMBER_INT);
                $edit_name = filter_input(INPUT_POST, 'edit_name');
                $edit_mobile = filter_input(INPUT_POST, 'edit_mobile', FILTER_SANITIZE_NUMBER_INT);
                $edit_email = filter_input(INPUT_POST, 'edit_email', FILTER_SANITIZE_EMAIL);
                $edit_company = filter_input(INPUT_POST, 'edit_company');
                $edit_contacts = edit_selected_contact($db, $edit_id, $edit_name, $edit_mobile, $edit_email, $edit_company, $edit_company);

                 //! Commit y terminar la transición
                $db->commit();

                //? Hacer eco para manejar en javascript
                echo json_encode(['status' => 'success',  'message' => 'Successfully']);

            }catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }
        break;



        case 'delete_selected_contact':

            try{
                //? incluir la conexión a la base de datos
                include '../../../utilities/db_conn.php';
                //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
                //! Iniciar la transición
                $db->beginTransaction();

                $del_id = filter_input(INPUT_POST, 'del_id', FILTER_SANITIZE_NUMBER_INT);
                $user_contacts = del_contact_select($db, $del_id); 

            
                 //! Commit y terminar la transición
                $db->commit();

                //? Hacer eco para manejar en javascript
                echo json_encode(['status' => 'success',  'message' => 'Successfully']);

            }catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }

            break;
        case 'add_contact':
            try{
                //? incluir la conexión a la base de datos
                include '../../../utilities/db_conn.php';
                //? crear el objeto PDO
                $db = new PDO($dsn, $username, $password);
                //! Iniciar la transición
                $db->beginTransaction();
                $add_name = filter_input(INPUT_POST, 'add_name');

                $add_mobile = filter_input(INPUT_POST, 'add_mobile', FILTER_SANITIZE_NUMBER_INT); 

                $add_email = filter_input(INPUT_POST, 'add_email', FILTER_SANITIZE_EMAIL);
                
                $add_company = filter_input(INPUT_POST, 'add_company');

                $add_contacts = add_contact($db, $add_name, $add_mobile, $add_email, $add_company);

                
                
                 //! Commit y terminar la transición
                $db->commit();

                //? Hacer eco para manejar en javascript
                echo json_encode(['status' => 'success',  'message' => 'Successfully']);

            }catch (PDOException $e) {
                //? Ocurre cuando hay un error en la base datos o en el modelo
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Database Error: ' . $e->getMessage());
                $message = $development_mode ? 'Database error occurred: ' . $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (ErrorException $e) {
                //? Ocurre cuando convertimos un Warning a excepción, normal mente estos warnings php los ignora
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Warning converted to Exception: ' . $e->getMessage());
                $message = $development_mode ? $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            } catch (Exception $e) {
                //? Ocurre cuando hay un error fatal 
                if (isset($db)) {
                    $db->rollBack(); //! Rollback deshace cualquier cambio que se hizo durante la transición
                }
                error_log('Error: ' . $e->getMessage());
                $message = $development_mode ?  $e->getMessage() : $user_message;
                echo json_encode(['status' => 'error', 'message' => $message]);
            }
            break;

}


?>