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
// Delet task Lists
$(document).on("click", ".delList", function (e) {
      if (
        (e.preventDefault(),
        confirm("CAUTION: Are you wanting to delete the task likst?"))
      ) {
        let e = $(this).val();
        $.ajax({
          type: "POST",
          url: "./action/delall.php",
          data: { delete_list: !0, list_id: e },
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
// Delet Clients
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
// Delet Leads
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
