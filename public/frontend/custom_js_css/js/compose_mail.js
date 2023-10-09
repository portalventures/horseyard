$(document).ready(function () {
    $('#composeTo').select2(
        {
            minimumInputLength: 3,
            multiple: true,
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
                            return {
                                text: item.email,
                                id: item.id
                            }
                        })
                    };
                }
            }
       }
    ).change(function(){
        $("#errNm1").empty();
    });

    $(".inbox-form").validate({
        rules: {
            composeTo: {
            required: true
          },
          subject: {
            required: true,
          },
          message: {
            required: true,
          }
        },
        messages:{
            composeTo: {
                required:"Please select user"
              },
              subject: {
                required:"Please enter subject"
              },
              message: {
                required:"Please enter message"
              }
        },
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
              error.insertAfter(element);
            }
             $("#"+$(element).attr("name")+"-error").css("color","red");
          },

        submitHandler: function(form) {
          //form.submit();
        }
      });
      $(".inbox-form").submit(function(event){
          event.preventDefault();
          if($(this).valid())
          {
              $("#btnSubmit").attr('disabled',true);
              $("#mailTo").val($("#composeTo").val());

              $.ajax({
                type: "POST",
                url: "send_message",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                  },
                success: function(data) {
                   if(data==0)
                   {
                       location.assign("inbox");
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
      });
});

function resetForm()
{
    $("#composeTo").val("").trigger("change");
    $("#subject").val("");
    $("#message").val("");
}
