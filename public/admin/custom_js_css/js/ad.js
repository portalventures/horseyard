var categoryType = '';

var item_type = $('.item_type:checked');
update_price_based_on_item_type(item_type);

$(function() {

  if($(".all_top_categories").length)
  {
    categoryType = $(".all_top_categories").find("input:checked").attr('data-id');
    setAdDetails(categoryType);
  }

  $(".all_top_categories input").each(function() {
    $(this).change(function() {
      categoryType = $(this).attr('data-id');
      setAdDetails(categoryType);
    });
  });

  $(".admin_create_ad_form").validate({
    rules: {
      name: {
        required: true
      },
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      },
      contact_number: {
        required: true,
        pattern: /^[0-9]{10}/
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

  function setAdDetails(category) {
    var ad_slug_url = 0;
    console.log(category,ad_slug_url);
    if ($(".ad_slug_url").length) {
      ad_slug_url = $(".ad_slug_url").val();
    }
    $.ajax({
      type: "POST",
      url:  '/admin/get-categorytype-dynamic-fields',
      data: {
              categoryType : category,
              ad_slug_url : ad_slug_url
            },
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success:function(data){
        $('.categories_dynamic_data').html(data);
        $(".adDetailsStep").find("select").select2({
          //minimumResultsForSearch: -1,
        });        
      }
    });
    $(".adDetailsStep").find("select").select2({
      //minimumResultsForSearch: -1,
    })
  }

  function create_ad(form) {
    var formData = new FormData(form);
    for(var i=0; i<postImAages.length; i++){
      formData.append('lisintg_images[]', postImAages[i]);
    }

    $.ajax({
      url: "post-ad",
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success : function (data)
      {
        window.scrollTo(0, 0);
        swal({
          title: 'Success!',
          text: 'Listing added sucessfully!',
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

  $(".delete_ad_image").click(function(){
    var name = $(this);
    var image_id = name.attr('data-id');

    swal({
      title: "Are you sure?",
      text: "you want to Delete.",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function(isConfirm)
    {
      if (isConfirm)
      {
        $.ajax({
          url: "/admin/listing-image-delete",
          type: 'POST',
          data: {image_id : image_id},
          beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success : function (data)
          {
            name.closest("span").remove();
          },
          error:function(){
            swal("Oops!", "Something went wrong.");
          }
        });
      }
    });
  });

  $(".admin_update_ad_form").validate({
    rules: {
      name: {
        required: true
      },
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      },
      number: {
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
      update_ad(form,"true");
    }
  });

  function update_ad(form) {
    var formData = new FormData(form);
    for(var i=0; i<postImAages.length; i++){
      formData.append('lisintg_images[]', postImAages[i]);
    }
    $.ajax({
      url: "/admin/update-ad",
      type: 'POST',
      contentType: false,
      processData: false,
      data: formData,
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success:function (data)
      {
        window.scrollTo(0, 0);
        swal({
          title: 'Success!',
          text: 'Listing update sucessfully!',
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

  $('.listing_status').click(function(){
    var name = $(this);
    var ad_id = name.attr('data-id');
    var status = name.val();

    var swalText = name.attr('data-swalText');
    var swalTitle = name.attr('dataSwalTitle');

    swal({
      title: swalTitle,
      text: swalText,
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
          url: "/admin/update-ad-status",
          type: 'POST',
          data: {ad_id : ad_id,status : status},
          beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success : function (data)
          {
            if(data == 1)
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
            }
            if(data == 2)
            {
              swal("User blocked.", "Please unblock user first.");
            }
          },
          error:function(){
            swal("Oops!", "Something went wrong.");
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

  $('.state_list').change(function(){
    var name = $(this);
    var state = name.val();
    $.ajax({
      url: "/admin/get-admin-suburb-list",
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

  $('.approved_status').click(function(){
    var name = $(this);
    var ad_id = name.attr('data-id');
    var status = name.attr('data-status');

    $.ajax({
      url: "/admin/admin-approved-reject-ad",
      type: 'POST',
      data: {ad_id : ad_id,
            status : status},
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success : function (data)
      {
        if(data == 1)
        {
          name.parent().parent().parent().remove();
        }
        swal({
          title: 'Success!',
          text: 'Ad ' +status+ ' sucessfully!',
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
  });

  $('.delete_ad_by_admin').click(function(){
    var name = $(this);
    var ad_token = name.attr('data-id');
    var swalText = name.attr('data-swalText');
    var swalTitle = name.attr('dataSwalTitle');

    swal({
      title: swalTitle,
      text: swalText,
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
          url: "/admin/admin-delete-ad",
          type: 'POST',
          data: {ad_token : ad_token},
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
  
  $('.item_type').click(function(){
    var name = $(this);
    update_price_based_on_item_type(name);
  });
});

function update_price_based_on_item_type(name) 
{
  var item_type_value = name.val();
  $('.item_type_radio').find('.errorMessage').html('');
  if(item_type_value == 'free')
  {
    $('.item_price').prop('disabled', true);
    $('.item_price').val('00');
  }
  // else{
  //   $('.item_price').prop('disabled', false);
  //   $('.item_price').val('');
  // }
}