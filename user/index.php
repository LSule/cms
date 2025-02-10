<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../utilities/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../utilities/sweetalert2/sweetalert2.min.css">
</head>


<body class="container d-flex flex-column px-4 py-3 ">


    <div class="row">
      <div class="col-8 fs-1 ">Contacts</div>
 <div class="col-4"><button id="create-contact-btn" class="btn btn-info btn-lg rounded-circle float-end" data-bs-toggle="modal" data-bs-target="#modal-detail"><i class='fas fa-plus text-white'></i></button>
</i></div>    
    </div>
    
    <input class="my-4 w-100"   type="text" id="search_contact" placeholder="Search.." autocomplete="off"/>

    <div class="px-3" id="user_contacts";></div>


        <div class="" id="modal-placeholder"></div>


    

    <script src="../utilities/js/jquery.js"></script>
    <script src="../utilities//bootstrap/bootstrap.min.js"></script>
    <script src="../utilities/fontawesome/all.min.js"></script>
    <script src="../utilities/sweetalert2/sweetalert2.min.js"></script>
    <script src="../utilities/evo-calendar/js/evo-calendar.js"></script>
    <script src="../utilities/Chart.js/chart.umd.js"></script>
    <script src="../utilities/Print.js/print.min.js"></script>
    <script src="../user/contacts/js/contacts_event_controller.js"></script>
</body>
</html>