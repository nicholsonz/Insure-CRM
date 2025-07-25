// Open and close sidebar ///////////////////////////////////////////////////////////////
let btnopen = document.getElementById("w3open");
btnopen.onclick = function w3open() {
  document.getElementById("mySidebar").style.display = "block";
}
let btnclose = document.getElementById("w3close");
btnclose.onclick = function w3close() {
  document.getElementById("mySidebar").style.display = "none";
}

// Upload Client files //////////////////////////////////////////////////////////////////
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

// Delete files /////////////////////////////////////////////////////////////////////////
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

// Table filter/search box //////////////////////////////////////////////////////////////
$(document).ready(function () {
	$("#tableSrch").on("keyup", function () {
	  let e = $(this).val().toLowerCase();
	  $("#tblSrch tr").filter(function () {
		$(this).toggle($(this).text().toLowerCase().indexOf(e) > -1);
	  });
	});
  })

// One placed to customize - The id value of the table tag.
let TableIDvalue = "srtTable";

//
//////////////////////////////////////
let TableLastSortedColumn = -1;
function SortTable() {
let sortColumn = parseInt(arguments[0]);
let type = arguments.length > 1 ? arguments[1] : 'T';
let dateformat = arguments.length > 2 ? arguments[2] : '';
let table = document.getElementById(TableIDvalue);
let tbody = table.getElementsByTagName("tbody")[0];
let rows = tbody.getElementsByTagName("tr");
let arrayOfRows = new Array();
type = type.toUpperCase();
dateformat = dateformat.toLowerCase();
for(let i=0, len=rows.length; i<len; i++) {
	arrayOfRows[i] = new Object;
	arrayOfRows[i].oldIndex = i;
	let celltext = rows[i].getElementsByTagName("td")[sortColumn].innerHTML.replace(/<[^>]*>/g,"");
	if( type=='D' ) { arrayOfRows[i].value = GetDateSortingKey(dateformat,celltext); }
	else {
		let re = type=="N" ? /[^\.\-\+\d]/g : /[^a-zA-Z0-9]/g;
		arrayOfRows[i].value = celltext.replace(re,"").substring(0,25).toLowerCase();
		}
	}
if (sortColumn == TableLastSortedColumn) { arrayOfRows.reverse(); }
else {
	TableLastSortedColumn = sortColumn;
	switch(type) {
		case "N" : arrayOfRows.sort(CompareRowOfNumbers); break;
		case "D" : arrayOfRows.sort(CompareRowOfNumbers); break;
		default  : arrayOfRows.sort(CompareRowOfText);
		}
	}
let newTableBody = document.createElement("tbody");
for(let i=0, len=arrayOfRows.length; i<len; i++) {
	newTableBody.appendChild(rows[arrayOfRows[i].oldIndex].cloneNode(true));
	}
table.replaceChild(newTableBody,tbody);
} // function SortTable()

function CompareRowOfText(a,b) {
let aval = a.value;
let bval = b.value;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfText()

function CompareRowOfNumbers(a,b) {
let aval = /\d/.test(a.value) ? parseFloat(a.value) : 0;
let bval = /\d/.test(b.value) ? parseFloat(b.value) : 0;
return( aval == bval ? 0 : (aval > bval ? 1 : -1) );
} // function CompareRowOfNumbers()

function GetDateSortingKey(format,text) {
if( format.length < 1 ) { return ""; }
format = format.toLowerCase();
text = text.toLowerCase();
text = text.replace(/^[^a-z0-9]*/,"");
text = text.replace(/[^a-z0-9]*$/,"");
if( text.length < 1 ) { return ""; }
text = text.replace(/[^a-z0-9]+/g,",");
let date = text.split(",");
if( date.length < 3 ) { return ""; }
let d=0, m=0, y=0;
for( let i=0; i<3; i++ ) {
	let ts = format.substr(i,1);
	if( ts == "d" ) { d = date[i]; }
	else if( ts == "m" ) { m = date[i]; }
	else if( ts == "y" ) { y = date[i]; }
	}
d = d.replace(/^0/,"");
if( d < 10 ) { d = "0" + d; }
if( /[a-z]/.test(m) ) {
	m = m.substr(0,3);
	switch(m) {
		case "jan" : m = String(1); break;
		case "feb" : m = String(2); break;
		case "mar" : m = String(3); break;
		case "apr" : m = String(4); break;
		case "may" : m = String(5); break;
		case "jun" : m = String(6); break;
		case "jul" : m = String(7); break;
		case "aug" : m = String(8); break;
		case "sep" : m = String(9); break;
		case "oct" : m = String(10); break;
		case "nov" : m = String(11); break;
		case "dec" : m = String(12); break;
		default    : m = String(0);
		}
	}
m = m.replace(/^0/,"");
if( m < 10 ) { m = "0" + m; }
y = parseInt(y);
if( y < 100 ) { y = parseInt(y) + 2000; }
return "" + String(y) + "" + String(m) + "" + String(d) + "";
} // function GetDateSortingKey()

