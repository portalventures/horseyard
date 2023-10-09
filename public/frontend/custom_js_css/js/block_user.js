$(document).ready(function () {
    $('#blockUserId').select2(
        {
            minimumInputLength: 3,
            ajax: {
                url: "search_user",
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (term) {
                    return {
                        term: term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            var name = item.first_name==null ? item.email:item.first_name +" "+item.last_name ;
                            return {
                                text: name,
                                id: item.id
                            }
                        })
                    };
                }
            }
       }
    ).change(function(){
        $("#errNm1").text("");
        $("#errorSubmit").text("");
    })

      $(".block-form").submit(function(event){
        event.preventDefault();
        $("#errorSubmit").text("");
        if($("#blockUserId").val()!="" && $("#blockUserId").val()!=null)
        {
            $("#btnSubmit").attr('disabled',true);

            $.ajax({
              type: "POST",
              url: "block_user",
              data: new FormData(this),
              dataType: "json",
              processData: false,
              contentType: false,
              beforeSend: function (request) {
                  return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
              success: function(data) {
                 if(data.error==0)
                 {
                     location.reload();
                 }
                 else{
                  $("#errorSubmit").text("Unable to block user.");
                 }
              },
              error: function(xhr,txt,err ) {
                  $("#errorSubmit").text(err);
              },
              complete:function(){
                  $("#btnSubmit").attr("disabled",null);
              }
          });

        }
        else{
            $("#errNm1").text("Please select user.").css('color','red');
        }
    });
});


function unblock_user(userId,obj)
{
    $(obj).closest("tr").hide();
    $.ajax({
        type: "POST",
        url: "unblock_user",
        data: JSON.stringify({userId:userId}),
        dataType: "json",
        contentType:"application/json; charset=UTF-8",
        beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
        success: function(data) {
           if(data.error==0)
           {
                $(obj).closest("tr").remove();
           }
           else{
            $(obj).closest("tr").show();
            $("#errorSubmit").text(data.message);
           }
        },
        error: function(xhr,txt,err ) {
            $("#errorSubmit").text(err);
        }
    });

}
