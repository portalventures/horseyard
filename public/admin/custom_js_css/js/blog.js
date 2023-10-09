if ($(".blog_add_form").length) {
  $(".blog_add_form").validate({
    rules: {
      title: {
        required: true        
      },
      detailed_text: {
        required: true
      },
      blog_image: {
        required: true,
        extension: "jpeg|png|jpg|jfif"
      },
      category: {
        required: true        
      },        
    },
    messages: {
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
      //$("#detailed_text").val($("#editor").html());       
      form.submit();
    }
  });
}

if ($(".blog_update_form").length) {
  $(".blog_update_form").validate({
    rules: {
      title: {
        required: true        
      },
      detailed_text: {
        required: true
      },
      blog_image: {      
        extension: "jpeg|png|jpg|jfif"
      },      
      category: {
        required: true        
      },        
    },
    messages: {
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
$('.blog_status').change(function(){
  var name = $(this);
  var blogid = name.attr('data-id');
  var status = name.val();
  var message = '';
  var message1 = '';
  
  if(name.is(":checked")){
    message = "activate";
    message1 = "activated";
  }
  else{
    message = "deactivate";
    message1 = "deactivated";
  }
  
  swal({
    title: "Are you sure?",
    text: "you want to " + message + " the blog",
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
        url: "/admin/update-blog-status",
        type: 'POST',
        data: {blog_id : blogid,status : status},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: 'Sucessfully ' + message1 + " the blog!",
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
            window.location.reload();
          })
        },
        error:function(){
        }
      });
    }else
    {
      if(name.is(":checked")){
        name.prop('checked',false);
      }else{
        name.prop('checked',true);
      }
    }
  })
});
