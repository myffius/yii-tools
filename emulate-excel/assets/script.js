jQuery(document).ready(function(){
    jQuery.fn.clearFormat = function(){
        this.removeClass('format-percent')
            .removeClass('format-number')
            .removeClass('format-text');
        return this;
    }

    jQuery('.excel-table td').click(function(){
        editabledCell = jQuery('.excel-table td.selected input');
        if (editabledCell.length > 0){
            editabledCell.parent('td').html('<div>' + jQuery(this).val() +'<span></span></div>')
        }
        jQuery('.excel-table td, .excel-table th').removeClass('selected');
        jQuery(this).addClass('selected').parent().children('th').addClass('selected');
        //$('.excel-table tr.evaluate-line input').val($(this).text());
    })

    jQuery('.excel-table td').dblclick(function(){
        text = $(this).text();
        jQuery(this).html('<div style="padding: 0; width: 86px;"><input style="position: relative;padding-left: 3px; top: 0; left: 0; border: none; outline: none; width: 74px" value="'+text+'" /></div>');
    })

    jQuery(document).keyup(function(eventObject){
        if (jQuery('.excel-table td.selected input').length > 0)
            return false;
        current = jQuery('.excel-table td.selected');
        if (eventObject.which == 39 && !current.next().is(':last'))
            current.removeClass('selected').next().addClass('selected');
        if (eventObject.which == 37 && !current.prev().is('th'))
            current.removeClass('selected').prev().addClass('selected');
    })
})
