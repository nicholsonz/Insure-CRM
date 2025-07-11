 $(document).on("click", ".editCliBtn", function() {
    let e = $(this).val();
    $.ajax({
      type: "GET",
      url: "updateclient.php?id=" + e,
      success: function(e) {
        let a = jQuery.parseJSON(e);
        404 == a.status
          ? alert(a.message)
          : 200 == a.status &&
          ($("#id").val(a.data.id),
            $("#birthdate").val(a.data.birthdate),
            $("#phone").val(a.data.phone),
            $("#policy").val(a.data.policy),
            $("#insurer").val(a.data.insurer),
            $("#appstatus").val(a.data.appstatus),
            $("#created").val(a.data.created),
            $("#cliEditModal").modal("show"));
      },
    });
  })