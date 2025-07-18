
// Upload Client files
// $(document).on("click", ".upldClient", function (e) {
//   if (
//     (e.preventDefault(),
//     confirm("Would you like to upload the file?"))
//   ) {
//     let e = $(this).val();
//       // console.log(e);
//     $.ajax({
//       type: "POST",
//       url: "./action/upld.php",
//       data: { upld_client: !0, file: e },
//       success: function (e) {
//         let a = jQuery.parseJSON(e);
//         500 == a.status
//           ? alert(a.message)
//           : (alertify.set("notifier", "position", "top-right"),
//             alertify.success(a.message),
//             $("#fileTable").load(location.href + " #fileTable"));
//       },
//     });
//   }
// });
//
// Select all checkbox
$(function () {
     // add multiple select / deselect functionality
     $("#select_all").click(function () {
         $('.name').attr('checked', this.checked);
     });
     // if all checkbox are selected, then check the select all checkbox
     // and viceversa
     $(".name").click(function () {
         if ($(".name").length == $(".name:checked").length) {
             $("#select_all").attr("checked", "checked");
         } else {
             $("#select_all").removeAttr("checked");
         }
     });
 });

// Delete files
$(document).on("click", ".delFile", function (e) {
  if (
    (e.preventDefault(),
    confirm("CAUTION: Are you wanting to delete the file?"))
  ) {
    let e = $(this).val();
      // console.log(e);
    $.ajax({
      type: "POST",
      url: "./action/delall.php",
      data: { delete_file: !0, file: e },
      success: function (e) {
        let a = jQuery.parseJSON(e);
        500 == a.status
          ? alert(a.message)
          : (alertify.set("notifier", "position", "top-right"),
            alertify.success(a.message),
            $("#fileTable").load(location.href + " #fileTable"));
      },
    });
  }
});
// Delete Task
$(document).on("click", ".delTask", function (e) {
      if (
        (e.preventDefault(),
        confirm("CAUTION: Are you wanting to delete the task?"))
      ) {
        let e = $(this).val();
        $.ajax({
          type: "POST",
          url: "./action/delall.php",
          data: { delete_task: !0, task_id: e },
          success: function (e) {
            let a = jQuery.parseJSON(e);
            500 == a.status
              ? alert(a.message)
              : (alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#taskTable").load(location.href + " #taskTable"));
          },
        });
      }
    });
// Delete task Lists
$(document).on("click", ".delList", function (e) {
      if (
        (e.preventDefault(),
        confirm("CAUTION: Are you wanting to delete the task likst?"))
      ) {
        let e = $(this).val();
        $.ajax({
          type: "POST",
          url: "./action/delall.php",
          data: { delete_list: !0, id: e },
          success: function (e) {
            let a = jQuery.parseJSON(e);
            500 == a.status
              ? alert(a.message)
              : (alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#listTable").load(location.href + " #listTable"));
          },
        });
      }
});
// Delete Clients
$(document).on("click", ".delClient", function (e) {
  if (
    (e.preventDefault(),
    confirm("CAUTION: Are you wanting to delete this client?"))
  ) {
    let e = $(this).val();
    $.ajax({
      type: "POST",
      url: "./action/delall.php",
      data: { delete_client: !0, name: e },
      success: function (e) {
        let a = jQuery.parseJSON(e);
        500 == a.status
          ? alert(a.message)
          : (alertify.set("notifier", "position", "top-right"),
            alertify.success(a.message),
            $("#clientTable").load(location.href + " #clientTable"));
      },
    });
  }
});
// Delete Leads
$(document).on("click", ".delLead", function (e) {
  if (
    (e.preventDefault(),
    confirm("CAUTION: Are you wanting to delete this lead?"))
  ) {
    let e = $(this).val();
    $.ajax({
      type: "POST",
      url: "./action/delall.php",
      data: { delete_lead: !0, name: e },
      success: function (e) {
        let a = jQuery.parseJSON(e);
        500 == a.status
          ? alert(a.message)
          : (alertify.set("notifier", "position", "top-right"),
            alertify.success(a.message),
            $("#leadTable").load(location.href + " #leadTable"));
      },
    });
  }
});
