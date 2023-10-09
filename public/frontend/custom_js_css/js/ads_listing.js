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

  $(".user_create_ad_form").validate({
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
      url:  '/categoryType_dynemic_fileds',
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
        category_field_validation();
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
      url: "/create-listing",
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
          text: 'Listing added successfully!',
          allowOutsideClick: false,
          showConfirmButton: true
        }).then((result) =>
        {
          //location.reload();
          window.location.href = 'manage-ads';
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
          url: "/user_listing_image_delete",
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

          }
        });
      }
    });
  });

  $(".user_update_ad_form").validate({
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
    $.ajax({
      url: "/user_update_listing",
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
          text: 'Listing updated successfully!',
          allowOutsideClick: false,
          showConfirmButton: true
        }).then((result) =>
        {
          location.assign("/manage-ads");
        })
      },
      error:function(){
        swal("Oops!", "Something went wrong.");
      }
    });
  }

  $('.listing_status').change(function(){
    var name = $(this);
    var ad_id = name.attr('data-id');
    var status = name.val();

    swal({
      title: "Are you sure?",
      text: "you want to change.",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then(function(isConfirm)
    {
      if (isConfirm)
      {
        $.ajax({
          url: "/update_listing_status",
          type: 'POST',
          data: {ad_id : ad_id,status : status},
          beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success : function (data)
          {

          },
          error:function(){
          }
        });
      }
    })
  });

  $('.state_list').change(function(){
    var name = $(this);
    var state = name.val();

    $.ajax({
      url: "/get_user_category_suburb_list",
      type: 'POST',
      data: {state : state},
      beforeSend: function (request) {
        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
      },
      success : function (data)
      {
        $('.suburb_div').html(data);
        $("#main").find("select").select2({
         //minimumResultsForSearch: -1,
        })
      },
      error:function(){
      }
    });
  });

  $('.user_listing_status').change(function(){
    var name = $(this);
    var ad_id = name.attr('data-id');
    var status = name.val();

    swal({
      title: "Are you sure?",
      text: "you want to change.",
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
          url: "/user_update_ad_status",
          type: 'POST',
          data: {ad_id : ad_id,status : status},
          beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success : function (data)
          {

          },
          error:function(){
          }
        });
      }else
      {
        name.prop('checked',false);
      }
    })
  });

  $(".listing_report_form").validate({
    rules: {
      name: {
        required: true
      },
      email: {
        required: true,
        email: true,
        pattern: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
      },
      report_reason: {
        required: true
      },
      report_message: {
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
      add_report(form);
    }
  });

  function add_report(form) {
    var formData = new FormData(form);
    $.ajax({
      url: "/listing_report",
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
        $(form)[0].reset();
        swal("Success!", "Report submitted successfully.");
        $('#reportListing').modal('toggle');
      },
      error:function(){
        swal("Oops!", "Something went wrong.");
      }
    });
  }

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
