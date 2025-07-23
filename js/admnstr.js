 // Populate modal with correct info
 $(document).on("click", ".editPolBtn", function() {
    let e = $(this).val();
    $.ajax({
      type: "GET",
      url: "action/updPol.php?id=" + e,
      success: function(e) {
        let a = jQuery.parseJSON(e);
        404 == a.status
          ? alert(a.message)
          : 200 == a.status &&
          ($("#id").val(a.data.id),
            $("#policy").val(a.data.policy),
            $("#descr").val(a.data.descr),
            $("#other").val(a.data.other),
            $("#polEditModal").modal("show"));
      },
    });
  }),
  // Update policy from modal
  $(document).on("submit", "#updatePol", function(e) {
    e.preventDefault();
    let a = new FormData(this);
    a.append("update_pol", !0),
      $.ajax({
        type: "POST",
        url: "action/updPol.php",
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
              $("#polTable").load(location.href + " #polTable"))
            : 200 == a.status
              ? ($("#errorMessageUpdate").addClass("d-none"),
                alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#polEditModal").modal("hide"),
                $("#updatePol")[0].reset(),
                $("#polTable").load(location.href + " #polTable"))
              : 500 == a.status && alertify.error(a.message);
        },
      });
  })
  // Add new policy from modal
  $(document).on("submit", "#addPol", function(e) {
    e.preventDefault();
    let a = new FormData(this);
    a.append("add_pol", !0),
      $.ajax({
        type: "POST",
        url: "action/updPol.php",
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
              $("#polTable").load(location.href + " #polTable"))
            : 200 == a.status
              ? ($("#errorMessageUpdate").addClass("d-none"),
                alertify.set("notifier", "position", "top-right"),
                alertify.success(a.message),
                $("#polAddModal").modal("hide"),
                $("#addPol")[0].reset(),
                $("#polTable").load(location.href + " #polTable"))
              : 500 == a.status && alertify.error(a.message);
        },
      });
  })