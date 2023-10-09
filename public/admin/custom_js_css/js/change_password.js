if ($(".admin_change_password_form").length) {
  $(".admin_change_password_form").validate({
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
      /**
       * This is called whent the form is valid.
       */
      form.submit();
    }
  });
}
