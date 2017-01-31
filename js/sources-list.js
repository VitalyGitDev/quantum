var length = -1,
    row_html = '';

$(document).ready(function(){
    for (source in sources) {
        fill(sources[source].container, $('#' + source + '-list'));
    }
    WINDOW_FACTORY.createModal($('body'), RESOURCE_MODEL);
});

//TODO: REDRAW CUBE-CATEGORY SIDE AFTER SUCCESSFULL SAVING!!!!!!!!
$(document).on('click', '.plus-block', function(){
    $('.window_background').show();
    WINDOW_FACTORY.get('resourceCreation', $(this).parents('.container').attr('category'));
});

function fill(list, container) {
    //TODO: Check if list is empty or null, and make it as Template treatment.
    length = list.length;
    while(length > -1) {
        row_html += '<div class="row margin-top-30">';
        for(var i = 0; i<4; i++) {
            length--;
            if (length == -1) {
                break;
            }
            row_html += '<div class="three columns list-item">';
            row_html += '<div class="iframe-wrapper row"> <iframe src=\"';
            row_html += list[length].url + '\">' + '</iframe><div class=\"iframe-overlay\"></div></div>';
            row_html += '<div class=\"row\"><h5>' + list[length].name + '</h5></div>';
            row_html += '<div class=\"row\">' + '<a href=\"' + list[length].url + '\" target=\"_blank\" class=\"button\">Visit</a></div>';
            row_html += '<div class=\"row list-item-menu\"><div class=\"list-menu-entry\"><i class="fi-refresh"></i></div><div class=\"list-menu-entry\"><i class="fi-widget"></i></div><div class=\"list-menu-entry\"><i class="fi-download"></i></div></div>';
            row_html += '</div>';
        }

        if (! (length > -1)) {
            row_html += addPlusBlock();
        }

        row_html += '</div>';
        container.append(row_html);
        row_html = '';
    }

}
function addPlusBlock() {
    var plusBlock = "";
    plusBlock += '<div class="three columns list-item plus-block"><div><i class="fi-plus"></i></div></div>';

    return plusBlock;
}
