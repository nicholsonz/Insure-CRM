 $(document).on("click", ".editTaskBtn", function() {
    let e = $(this).val();
    $.ajax({
      type: "GET",
      url: "action/updtask.php?task_id=" + e,
      success: function(e) {
        let a = jQuery.parseJSON(e);
        404 == a.status
          ? alert(a.message)
          : 200 == a.status &&
          ($("#task_id").val(a.data.task_id),
            $("#acct_id").val(a.data.acct_id),
            $("#object").val(a.data.object),
            $("#details").val(a.data.details),
            $("#list_id").val(a.data.list_id),
            $("#priority").val(a.data.priority),
            $("#deadline").val(a.data.deadline),
            $("#type").val(a.data.type),
            $("#taskEditModal").modal("show"));
      },
    });
  }),
  $(document).on("submit", "#updateTask", function(e) {
    e.preventDefault();
    let a = new FormData(this);
    a.append("update_task", !0),
      $.ajax({
        type: "POST",
        url: "action/updtask.php",
        data: a,
        processData: !1,
        contentType: !1,
        success: function(e) {
          let a = jQuery.parseJSON(e);
          422 == a.status
            ? ($("#errorMessageUpdate").removeClass("d-none"),
              $("#errorMessageUpdate").text(a.message),
              alertify.set("notifier", "position", "top-right"),
              alertify.error(a.message),
              $("#taskTable").load(location.href + " #taskTable"))
            : 200 == a.status
              ? ($("#errorMessageUpdate").addClass("d-none"),
                alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#taskEditModal").modal("hide"),
                $("#updateTask")[0].reset(),
                $("#taskTable").load(location.href + " #taskTable"))
              : 500 == a.status && alertify.error(a.message);
        },
      });
  })