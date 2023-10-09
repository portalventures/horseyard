$('.breed_status').change(function(){
  var name = $(this);
  var id = name.attr('data-id');
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
    text: "you want to " + message + " the item",
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
        url: "/admin/update-explore-breed-status",
        type: 'POST',
        data: {explore_horse_id : id,status : status},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: 'Sucessfully ' + message,
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
