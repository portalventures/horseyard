$(document).ready(function(){
    $(".inbox-form").submit(function(event){
        event.preventDefault();
    });
})

function submitForm()
{
        if($("#message").val()!="")
        {
            $("#btnSubmit").text("Sending Mail...").attr("disabled","disabled");
            $.ajax({
              type: "POST",
              url: window.location.origin+"/send_message",
              data: new FormData($(".inbox-form")[0]),
              dataType: "json",
              processData: false,
              contentType: false,
              beforeSend: function (request) {
                  return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
              success: function(data) {
                  if(data==0)
                 {
                    var rowId= $("#parentMailId").val();
                    var userId=$("#mailTo").val();
                    $.get( window.location.origin+"/message/message_detail_partial/"+rowId+"/"+userId, function( response ) {
                        $(".inbox-right").empty();
                        $(".inbox-right").append( response);
                      });
                 }
                 else{
                  $("#errorSubmit").text("Unable to send message.");
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
            $("#lblError").text("Please enter message")
        }
}
function downloadFile(filename,generatedname)
{
    $.ajax({
        type: "post",
        url: window.location.origin+"/download_file",
        data: JSON.stringify({"generatedName":generatedname, "fileName":filename}),
        processData:false,
        contentType:"application/json; charset=utf-8",
        beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
        success: function (res) {
            const data = res;
            const link = document.createElement('a');
            link.setAttribute('href', data);
            link.setAttribute('download', filename); // Need to modify filename ...
            link.click();
        },
        error: function(response)
        {
          console.log(response.responseJSON.message);
        }
    });
}

function blockUser(userId)
{
    swal({
        title: "Are you sure you want to block user?",
        type: "warning",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "",
            closeModal: true,
          },
          confirm: {
            text: "Yes",
            value: true,
            visible: true,
            className: "",
            closeModal: true
          }
        }
      }).then(function(isConfirm)
      {
        if (isConfirm)
        {
            $.ajax({
                type: "post",
                url: window.location.origin+"/block_user",
                data: JSON.stringify({"blockUserId":userId}),
                processData:false,
                contentType:"application/json; charset=utf-8",
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (res) {
                    if(res.error==0)
                    {
                        location.href=window.location.origin+"/inbox";
                    }
                    else{
                        swal("Oops!", "Something went wrong.");
                        console.log(res.message);
                    }
                },
                error: function(response)
                {
                    swal("Oops!",response.responseJSON.message);
                }
            });
        }else
        {
        }
      })
}
