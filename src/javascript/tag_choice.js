


function removePendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/remove_pending_tag.php",
        data: {
            id:id,
        }
    }).done(removePendingTagDiv(id));

}

function addPendingTag(id) {

    $.ajax({
        method: "GET",
        url: "../../api/add_pending_tag.php",
        data: {
            id:id,
        }
    }).done(removePendingTagDiv(id));
}


function removePendingTagDiv(id) {

    $('div[data-tag-id=' + id + ']').remove();

}