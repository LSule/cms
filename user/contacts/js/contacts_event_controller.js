//used to load latest contact list with out reloading whole site

function load_contact_list() {
  $.post(
    "contacts/controller/contacts_controller.php",
    { user_request: "fetch_all_contacts" },
    function (data) {
      var response = JSON.parse(data);
      console.log("Refresh contacts: " + response.status);
      if (response.status == "success") {
        $("#user_contacts").html(response.view);
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.message,
        });
      }
    }
  );
}

$(document).ready(function () {
  //Sets up the table of Contacts
  load_contact_list();

  //Searches db
  $(document).on("keyup", "#search_contact", function () {
    var search_input = $(this).val();

    console.log("Searching for:", search_input);

    $.post(
      "contacts/controller/contacts_controller.php",
      { user_request: "search_user_contact", search_input: search_input },
      function (data) {
        var response = JSON.parse(data);
        console.log("Search: " + response.status);
        if (response.status == "success") {
          $("#user_contacts").html(response.view);
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );
  });

  //Hover Function for highlighting what mouse is over
  $(document)
    .on("mouseover", ".contact-label", function () {
      $(this).addClass("bg-info text-white");
    })
    .on("mouseout", ".contact-label", function () {
      $(this).removeClass("bg-info text-white");
    });

  //Gets Selected contact data and inserts it into modal
  $(document).on("click", ".contact-label", function () {
    var select_id = $(this).find("p").data("contactId");
    console.log(select_id);

    $.post(
      "contacts/controller/contacts_controller.php",
      { user_request: "load_contact_select", select_id: select_id },
      function (data) {
        var response = JSON.parse(data);
        console.log("Selected Modal Shown: " + response.status);
        if (response.status == "success") {
          $("#modal-placeholder").html(response.view);
          $("#modal-detail").modal("show");
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );
  });
  //Enables inputs to be edited

  $(document).on("click", "#edit_btn", function () {
    $(this).text("Done");
    $("#modal-detail input").prop("disabled", false);
    $("#btn-del-holder").show();

    $("#contact-info input")
      .removeClass("border-0")
      .addClass("btn-outline-dark");
    $("#delete-btn").removeClass("d-none");
    $(this).attr("id", "done_btn");
    console.log("EDIT");
  });

  //collects and sends updated inputs to change DB row
  $(document).on("click", "#done_btn", function () {
    $(this).text("Edit");
    $("#modal-detail input").prop("disabled", true);
    $("#contact-info input")
      .removeClass("btn-outline-dark")
      .addClass("border-0");
    $("#delete-btn").addClass("d-none");

    $.post(
      "contacts/controller/contacts_controller.php",
      {
        user_request: "edit_selected_contact",
        edit_id: $("#edit-name").data("id"),
        edit_name: $("#edit-name").val(),
        edit_mobile: $("#edit-mobile").val(),
        edit_email: $("#edit-email").val(),
        edit_company: $("#edit-company").val(),
      },
      function (data) {
        var response = JSON.parse(data);
        console.log("Edit Contact in DB :" + response.status);
        if (response.status == "success") {
          load_contact_list();
          $(".modal-backdrop").remove();
          $("#modal-placeholder").empty();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );

    $(this).attr("id", "edit_btn");
    console.log("Done");
  });
  //hides itself and shows other buttons
  $(document).on("click", "#delete-btn", function () {
    $("#btn-verification").show();
    $("#btn-del-holder").hide();
  });

  //actual delete button sends id to COntact_Queries to remove row from DB
  $(document).on("click", "#real-del-btn", function () {
    $.post(
      "contacts/controller/contacts_controller.php",
      {
        user_request: "delete_selected_contact",
        del_id: $("#edit-name").data("id"),
      },
      function (data) {
        var response = JSON.parse(data);
        console.log("Deleted contact:" + response.status);
        if (response.status == "success") {
          load_contact_list();
          $(".modal-backdrop").remove();
          $("#modal-placeholder").empty();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );
  });
  //hides cur btns and returns other cancel btn
  $(document).on("click", "#cancel-btn", function () {
    $("#btn-verification").hide();
    $("#btn-del-holder").show();
  });
  // true dismissal of modal
  $(document).on("dismiss.bs.modal", ".modal-detail", function () {
    $("#modal-placeholder").empty();
  });
  $(document).on("click", "#close-modal", function () {
    $("#modal-placeholder").empty();
  });

  //Opens modal to create new contact
  $(document).on("click", "#create-contact-btn", function () {
    $.post(
      "contacts/controller/contacts_controller.php",
      {
        user_request: "open_empty_contact_modal",
      },
      function (data) {
        var response = JSON.parse(data);
        console.log("Open Empty modal: " + response.status);
        if (response.status == "success") {
          $("#modal-placeholder").html(response.view);
          $("#empty-modal-detail").modal("show");
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );
  });

  //creates new contacts

  $(document).on("click", "#add_btn", function () {
    $.post(
      "contacts/controller/contacts_controller.php",
      {
        user_request: "add_contact",
        add_name: $("#add-name").val(),
        add_mobile: $("#add-mobile").val(),
        add_email: $("#add-email").val(),
        add_company: $("#add-company").val(),
      },
      function (data) {
        var response = JSON.parse(data);
        console.log("Contact created: " + response.status);
        if (response.status == "success") {
          console.log("Added");
          load_contact_list();
          $(".modal-backdrop").remove();
          $("#modal-placeholder").empty();
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      }
    );
  });
});
