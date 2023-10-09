if ($(".code_verify_form").length) {
  $(".code_verify_form").validate({
    rules: {
      verification_code: {
        required: true,       
      },     
    },
    messages: {
      // password: {
      //   pattern: "Must have atleast: 1 alphanumeric character, 1 special character, 1 uppercase character and 1 lowercase character"
      // },
      // confpassword: {
      //   equalTo: "Password and Confirm password muct match"
      // }
    },
    submitHandler: function(form) {
      /**
       * This is called whent the form is valid.
       */
      form.submit();
    }
  });
}

if ($(".admin_login_form").length) {
  $(".admin_login_form").validate({
    rules: {
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      },
      password: {
        required: true
      }
    },
    messages: {
    },
    submitHandler: function(form) {
      /**
       * This is called whent the form is valid.
       */
      form.submit();
    }
  });
}

if ($(".admin_forgot_password_email_verify").length) {
  $(".admin_forgot_password_email_verify").validate({
    rules: {
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      }
    },
    messages: {
      
    },
    submitHandler: function(form) {
      /**
       * This is called whent the form is valid.
       */
      form.submit();
    }
  });
}

if ($(".admin_change_password_form").length) {
  $(".admin_change_password_form").validate({
    rules: {
      password: {
        required: true,
        minlength: 8,
        pattern: /^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/
      },
      confpassword: {
        required: true,
        minlength: 8,
        equalTo: "#password"
      }
    },
    messages: {
      password: {
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
}
