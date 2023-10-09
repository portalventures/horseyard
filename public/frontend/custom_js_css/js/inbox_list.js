
function remove_message(rowId)
   {
        var rowArray=[];
        if(rowId =="")
        {
            $(".rowCheckbox").each(function(){
                if($(this).prop("checked"))
                {
                    rowArray.push($(this).data("id"));
                }
            });
        }
        else
        {
            rowArray.push(rowId);
        }
        $.ajax({
            type: "POST",
            url: "remove_message",
            data: JSON.stringify({rowId:rowArray}),
            dataType: "json",
            contentType: "application/json; charset=UTF-i",
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(response) {
                if(response.error==0){
                    $.get( "inbox_list", function( data ) {
                        $("#dvInboxList").empty();
                        $("#dvInboxList").append( data );
                      });
                }
                else{
                    showError(response.message);
                }
            },
            error: function(xhr,txt,err ) {
                showError(err);
            }
        });
}

function showError(err)
{
    $(".errorMessage").text(err);
    setTimeout(() => {
        $(".errorMessage").text("");
    }, (10000));

}

    function checkBoxEvent(type)
    {
        $(".rowCheckbox").prop("checked",false);
        $("#selectInbox").prop("checked",false);
        $(".messageActions").addClass("d-none");
        if(type=="A")
        {
            $(".rowCheckbox").prop("checked",true);
            $(".messageActions").removeClass("d-none");
        }
        else if(type=="R")
        {
            $(".rowCheckbox").each(function(){
                if($(this).data('check')==1)
                {
                    $(this).prop("checked",true);
                }
            });
            $(".messageActions").removeClass("d-none");
        }
        else if(type=="U")
        {
            $(".rowCheckbox").each(function(){
                if($(this).data('check')==0)
                {
                    $(this).prop("checked",true);
                }
            });
            $(".messageActions").removeClass("d-none");
        }
    }


    function markMessage(type)
    {
        var checked_data=[];
        $(".rowCheckbox").each(function(){
            if($(this).prop("checked"))
            {
                checked_data.push($(this).data("id"));
            }
        });
        if(checked_data.length <=0)
        {
            return;
        }
        $.ajax({
            type: "POST",
            url: "change_message_status",
            data: JSON.stringify({checked_data:checked_data, action:type}),
            dataType: "json",
            contentType: "application/json; charset=UTF-i",
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(response) {
                if(response.error==0){
                    location.reload();
                }
                else{
                    showError(response.message);
                }
            },
            error: function(xhr,txt,err ) {
                showError(err);
            }
        });
    }
