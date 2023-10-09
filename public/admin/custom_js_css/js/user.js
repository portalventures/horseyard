$('.state_list').change(function(){
    var name = $(this);
    var state = name.val();
    $.ajax({
      url: "/admin/get_user_suburb_list",
      type: 'POST',
      data: {state : state},
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success : function (data)
      {
        $('.suburb_div').html(data);
        $(".card-content").find("select").select2({
          //minimumResultsForSearch: -1,
        })
      },
      error:function(){
        swal("Oops!", "Something went wrong.");
      }
    });
  });

$(".user_create_save_form").validate({
    rules: {
      first_name: {
        required: true
      },
      last_name: {
        required: true
      },
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      }
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).parent().find('.errorMessage');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form) {
      create_ad(form,"true");
    }
});

$(".user_update_form").validate({
  rules: {
    first_name: {
      required: true
    },
    company_name: {
      required: true
    },
    last_name: {
      required: true
    },
    address_line_1: {
      required: true
    },
    email: {
      required: true,
      email: true,
      pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
    },
    state: {
      required: true
    },
    phone_number: {
      required: true
    },
    suburb: {
      required: true
    },
    gender: {
      required: true
    },

    postal_code: {
      required: true
    }
  },
  errorElement: 'div',
  errorPlacement: function(error, element) {
    var placement = $(element).parent().find('.errorMessage');
    if (placement) {
      $(placement).append(error)
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function(form) {
    create_ad(form,"true");
  }
});
var email =  $("#email").val();
$(".admin_user_create_form").validate({
  rules: {
    first_name: {
      required: true
    },
    last_name: {
      required: true
    },
    email: {
      required: true,
      email: true,
      pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
    },
    phone_number: {
      required: true
    },
    gender: {
      required: true
    },
    country: {
      required: true
    },
    passwd: {
      required: true,
      minlength: 8,
      pattern: /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/
    },
    confpass: {
      required: true,
      minlength: 8,
      equalTo: "#passwd"
  },
},
  messages: {
      passwd: {
        pattern: "Must have atleast: 1 alphanumeric character, 1 special character, 1 uppercase character and 1 lowercase character"
      },
      confpass: {
        equalTo: "Password and Confirm password muct match"
      }
    },
  errorElement: 'div',
  errorPlacement: function(error, element) {
    var placement = $(element).parent().find('.errorMessage');
    if (placement) {
      $(placement).append(error)
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function(form) {
    create_ad(form,"true");
  }
});

$(".admin_user_update_form").validate({
  rules: {
    first_name: {
      required: true
    },
    last_name: {
      required: true
    },
    email: {
      required: true,
      email: true,
      pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
    },
    phone_number: {
      required: true
    },
    gender: {
      required: true
    },
    country: {
      required: true
    },
    passwd: {
      required: true,
      minlength: 8,
      pattern: /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/
    },
    confpass: {
      required: true,
      minlength: 8,
      equalTo: "#passwd"
    }
  },
  messages: {
      passwd: {
        pattern: "Must have atleast: 1 alphanumeric character, 1 special character, 1 uppercase character and 1 lowercase character"
      },
      confpass: {
        equalTo: "Password and Confirm password must match"
      }
    },
  errorElement: 'div',
  errorPlacement: function(error, element) {
    var placement = $(element).parent().find('.errorMessage');
    if (placement) {
      $(placement).append(error)
    } else {
      error.insertAfter(element);
    }
  },
  submitHandler: function(form) {
    create_ad(form,"true");
  }
});

$('.user_status_change').click(function(){
  var name = $(this);
  var user_id = name.attr('data-id');
  var status = name.val();
  var message = name.attr('data-msg');  
  
  if(message == '')
  if(name.is(":checked")){
    message = 'Active';
  }else{
    message = 'Inactive';
  }

  swal({
    title: message + " user",
    text: "Are you sure you want to " + message + "?",
    type: "warning",
    buttons: {
      cancel: {
        text: "Cancel",
        value: null,
        visible: true,
        className: "btn btn-secondary",
        closeModal: true
      },
      confirm: {
        text: "OK",
        value: true,
        visible: true,
        className: "btn btn-primary",
        closeModal: true
      }
    }
  }).then(function(isConfirm)
  {
    if (isConfirm)
    {
      $.ajax({
        url: "/admin/user_update_status",
        type: 'POST',
        data: {user_id : user_id,status : status},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: message + ' sucessfully!',
            allowOutsideClick: false,
            buttons: {
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
              }
            }
          }).then((result) =>
          {
            location.reload();
          })
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
    else
    {
      if(name.is(":checked")){
        name.prop('checked',false);
      }else{
        name.prop('checked',true);
      }
    }
  })
});

$('.delete_user_by_admin').click(function(){
  var name = $(this);
  var user_token = name.attr('data-id');

  swal({
    title: "Delete user?",
    text: "Are you sure you want to delete?",
    type: "warning",
    buttons: {
      cancel: {
        text: "Cancel",
        value: null,
        visible: true,
        className: "btn btn-secondary",
        closeModal: true
      },
      confirm: {
        text: "OK",
        value: true,
        visible: true,
        className: "btn btn-primary",
        closeModal: true
      }
    }
  }).then(function(isConfirm)
  {
    if (isConfirm)
    {
      $.ajax({
        url: "/admin/admin-delete-user",
        type: 'POST',
        data: {user_token : user_token},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        { 
          swal({
            title: 'Success!',
            text:'Deleted sucessfully!',
            allowOutsideClick: false,
            buttons: {
              confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn btn-primary",
                closeModal: true
              }
            }
          }).then((result) =>
          {
            location.reload();
          })
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
  })
});
     // Admin Email exits or not
     $('#email').blur(function(){
      var email = $('#email').val();
      var _token = $('input[name="_token"]').val();
      var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(!filter.test(email))
      {
       $('#errorMessage').html('<label class="text-danger">Invalid Email</label>');
       $('#email').addClass('has-error');
      }
      else
      {
       $.ajax({
        url:'./checkEmail',
        method:"POST",
        data:{email:email, _token:_token},
        success:function(result)
        {
         if(result == 'unique')
         {
          $('#error_email').html('<label class="text-success">Email Available</label>');
          $('#email').removeClass('has-error');
         }
         else
         {
          $('#error_email').html('<label class="text-danger">Email not Available</label>');
          $('#email').addClass('has-error');
         }
        }
       })
      }
     });

    // Admin Mobile Number Exits or Not
     $('#mobile').blur(function(){
        var mobile = $('#mobile').val();
        var _token = $('input[name="_token"]').val();
        var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if(!filter.test(mobile))
        {
         $('#errorMessage').html('<label class="text-danger">Invalid Mobile Number</label>');
         $('#mobile').addClass('has-error');
        }
        else
        {
         $.ajax({
          url:'./checkMobile',
          method:"POST",
          data:{mobile:mobile, _token:_token},
          success:function(result)
          {
           if(result == 'unique')
           {
            $('#error_mobile').html('<label class="text-success">Mobile Number Available</label>');
            $('#mobile').removeClass('has-error');
           }
           else
           {
            $('#error_mobile').html('<label class="text-danger">Mobile Number not Available</label>');
            $('#mobile').addClass('has-error');
           }
          }
         })
        }
       });

       // User Email exits or not
     $('#email').blur(function(){
        var email = $('#email').val();
        var _token = $('input[name="_token"]').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!filter.test(email))
        {
         $('#errorMessage').html('<label class="text-danger">Invalid Email</label>');
         $('#email').addClass('has-error');
        }
        else
        {
         $.ajax({
          url:'./UsercheckEmail',
          method:"POST",
          data:{email:email, _token:_token},
          success:function(result)
          {
           if(result == 'unique')
           {
            $('#error_email').html('<label class="text-success">Email Available</label>');
            $('#email').removeClass('has-error');
           }
           else
           {
            $('#error_email').html('<label class="text-danger">Email not Available</label>');
            $('#email').addClass('has-error');
           }
          }
         })
        }
       });

      // User Mobile Number Exits or Not
       $('#phone_number').blur(function(){
          var phone_number = $('#phone_number').val();
          var _token = $('input[name="_token"]').val();
          var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
          if(!filter.test(phone_number))
          {
           $('#errorMessage').html('<label class="text-danger">Invalid Mobile Number</label>');
           $('#phone_number').addClass('has-error');
          }
          else
          {
           $.ajax({
            url:'./UsercheckMobile',
            method:"POST",
            data:{phone_number:phone_number, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
              $('#error_mobile').html('<label class="text-success">Mobile Number Available</label>');
              $('#mobile').removeClass('has-error');
             }
             else
             {
              $('#error_mobile').html('<label class="text-danger">Mobile Number not Available</label>');
              $('#mobile').addClass('has-error');
             }
            }
           })
          }
         });
/*
        // Admin form submit button hidden
         $(document).ready(function() {
            $('#save_admin').attr("disabled", true);
        });

        var fields = "#role, #first_name, #last_name, #email, #mobile, #gender, #passwd, #confpass";

        $(fields).on('change', function() {
            if (allFilled()) {
                $('#save_admin').removeAttr('disabled');
            } else {
                $('#save_admin').attr('disabled', 'disabled');
            }
        });

        function allFilled() {
            var filled = true;
            $(fields).each(function() {
                if ($(this).val() == '') {
                    filled = false;
                }
            });
            return filled;
        }
        */
        // User form submit button hidden
        /*
        $(document).ready(function() {
            $('#save_user').attr("disabled", true);
        });

        var fields = "#first_name, #company_name, #last_name, #address_line_1, #email, #state, #phone_number, #suburb, #gender, #postal_code";

        $(fields).on('change', function() {
            if (allFilled()) {
                $('#save_user').removeAttr('disabled');
            } else {
                $('#save_user').attr('disabled', 'disabled');
            }
        });

        function allFilled() {
            var filled = true;
            $(fields).each(function() {
                if ($(this).val() == '') {
                    filled = false;
                }
            });
            return filled;
        }
*/