function open_memeber(button) {
  let row = $(button).closest("tr");
  let pageid = $(button).data("pageid");
  // console.log(pageid);
  loadSelection(row, pageid, "new_form" + pageid, "modal");
}

function tracking_prepare(ths) {
  toggledateel(ths);
}

function toggledate(ths) {
  toggledateel(ths);
}
function toggledateel(ths) {
  let pageData = $(ths).data();
  const dateelement = $(`#date_created${pageData.pageid}`);

  // if it's a "create new" form
  if ($(ths).is(":checked")) {
    $(dateelement).attr({ disabled: false, required: false }).closest(".input-field").removeClass("hide");
  } else {
    $(dateelement).attr({ disabled: true, required: false }).closest(".input-field").addClass("hide");
  }
}
