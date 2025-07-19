 $(document).on("click", ".editUserBtn", function() {
    let e = $(this).val();
    $.ajax({
      type: "GET",
      url: "action/updUser.php?id=" + e,
      success: function(e) {
        let a = jQuery.parseJSON(e);
        404 == a.status
          ? alert(a.message)
          : 200 == a.status &&
          ($("#id").val(a.data.id),
            $("#username").val(a.data.username),
            $("#email").val(a.data.email),
            $("#acct_type").val(a.data.acct_type),
            $("#userEditModal").modal("show"));
      },
    });
  }),
  $(document).on("submit", "#updateUser", function(e) {
    e.preventDefault();
    let a = new FormData(this);
    a.append("update_user", !0),
      $.ajax({
        type: "POST",
        url: "action/updUser.php",
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
              $("#userTable").load(location.href + " #userTable"))
            : 200 == a.status
              ? ($("#errorMessageUpdate").addClass("d-none"),
                alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#userEditModal").modal("hide"),
                $("#updateUser")[0].reset(),
                $("#userTable").load(location.href + " #userTable"))
              : 500 == a.status && alertify.error(a.message);
        },
      });
  })