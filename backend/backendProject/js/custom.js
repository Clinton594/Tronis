function open_memeber(button) {
  let row = $(button).closest("tr");
  let pageid = $(button).data("pageid");
  // console.log(pageid);
  loadSelection(row, pageid, "new_form" + pageid, "modal");
}

function waybill_prepare(ths) {
  let pageData = $(ths).data();
  const primaryKey = $(`#id${pageData.pageid}`);
  const member = $(`#user_id${pageData.pageid}`);
  const tx_no = $(`#tx_no${pageData.pageid}`);
  const notify = $(`#notify${pageData.pageid}`);

  // if it's a "create new" form
  if (!primaryKey.val()) {
    if ($(`#hidden${pageData.pageid}`).length) $(`#hidden${pageData.pageid}`).remove();
    $(tx_no).attr({ disabled: true }).closest(".input-field").addClass("hide");
    $(notify).attr({ disabled: false }).closest(".input-field").removeClass("hide");
    $(member).attr({ disabled: false });
  } else {
    if (!$(`#hidden${pageData.pageid}`).length)
      primaryKey.after(
        $("<input>")
          .attr({ id: `hidden${pageData.pageid}`, value: $(member).val(), type: "hidden", name: "user_id" })
          .val($(member).val())
      );
    else $(`#hidden${pageData.pageid}`).val($(member).val());
    $(tx_no).attr({ disabled: false }).closest(".input-field").removeClass("hide");
    $(notify).attr({ disabled: true }).closest(".input-field").addClass("hide");
    $(member).attr({ disabled: true });
  }
}
