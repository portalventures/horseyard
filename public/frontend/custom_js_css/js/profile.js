if ($(".user_change_password_form").length) {
  $('#changePassword').on('shown.bs.modal', function () {
    $(".user_change_password_form").validate({
      rules: {
        oldpassword: {
          required: true,       
        },
        new_password: {
          required: true,
          minlength: 8,
          pattern: /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/
        },
        confpassword: {
          required: true,
          minlength: 8,
          equalTo: "#new_password"
        }
      },
      messages: {
        new_password: {
          pattern: "Must have atleast: 1 alphanumeric character, 1 special character, 1 uppercase character and 1 lowercase character"
        },
        confpassword: {
          equalTo: "Password and Confirm password muct match"
        }
      },
      submitHandler: function(form) {
        /**
         * This is called whent the form is valid.
         */
        form.submit();
      }
    });
  });
}

$('.state_list').change(function(){ 
  var name = $(this);  
  var state = name.val();

  $.ajax({
    url: "/get_user_profile_suburb_list",
    type: 'POST',
    data: {state : state},
    beforeSend: function (request) {
      return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
    },
    success : function (data)
    {
      $('.suburb_div').html(data);
      $(".user_profile_form").find("select").select2({
        //minimumResultsForSearch: -1,
      })
    },
    error:function(){
    }
  });
});

  $(".user_profile_form").validate({
    rules: {
      phone_number: {
        required: true
      },
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
      form.submit();
    }
  });