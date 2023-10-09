$(function() {
  if ($(".dynamic_category_search_form").length) {
    $(".dynamic_category_search_form").validate({
      rules: {
        price_min: {
         
        },
        price_max: {
          
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

  $('.dynamic_category_tabs').click(function(){
    var name = $(this);  
    var category = name.attr('data-id');

    $.ajax({
      url: "/get_dynamic_category_list",
      type: 'GET',
      data: {category : category},
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success : function (data)
      {
        $('.dynamic_category_fields').html(data);
        $(".dynamic_category_fields").find("select").select2({
          //minimumResultsForSearch: -1,
        })
      },
      error:function(){
        swal("Oops!", "Something went wrong.");
      }
    });
  });
});

function reset_quick_search_filter(argument) {
  $('select').val(null).trigger('change');
}
