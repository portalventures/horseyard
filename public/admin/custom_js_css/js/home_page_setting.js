$(function() {
  $('.add_ads_into_featured_listing').click(function(){
    var name = $(this);
    var ads_ids = [];
    var from = name.attr('data-id');
    var existingRecs = name.attr('total-rec');

    $("input.ads_ids:checked").each(function(){
      ads_ids.push($(this).val());
    });
    var iVal = parseInt(existingRecs) + ads_ids.length;
    if(iVal > 10) {
      swal("Oops!", "You may add only " + (10 - existingRecs) + " more records!!!");
      return;
    }
    if(ads_ids.length > 0)
    {
      $.ajax({
        url: "/admin/add-new-featured-latest-blog-listing",
        type: 'POST',
        data: {ads_ids : ads_ids, from : from},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: 'Added sucessfully!',
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
              if(from!="stallion"){
                 window.location.href = "/admin/featured-listing-settings";
              }
              else{
                window.location.href = "/admin/stallions_listing_settings";
              }
          })
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
    else{
      swal("Oops!", "Please select listing.");
    }
  });

  $('.add_ads_into_latest_listing').click(function(){
    var name = $(this);
    var ads_ids = [];
    var from = name.attr('data-id');
    var existingRecs = name.attr('total-rec');

    $("input.ads_ids:checked").each(function(){
        ads_ids.push($(this).val());
    });
    var iVal = parseInt(existingRecs) + ads_ids.length;
    if(iVal > 10) {
      swal("Oops!", "You may add only " + (10 - existingRecs) + " more records!!!");
      return;
    }

    if(ads_ids.length > 0)
    {
      $.ajax({
        url: "/admin/add-new-featured-latest-blog-listing",
        type: 'POST',
        data: {ads_ids : ads_ids, from : from},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: 'Added sucessfully!',
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
            window.location.href = "/admin/latest-listing-settings";
          })
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
    else{
      swal("Oops!", "Please select listing.");
    }
  });

  $('.add_blog_into_blog_listing').click(function(){
    var name = $(this);
    var ads_ids = [];
    var from = name.attr('data-id');
    var existingRecs = name.attr('total-rec');

    $("input.ads_ids:checked").each(function(){
      ads_ids.push($(this).val());
    });
    var iVal = parseInt(existingRecs) + ads_ids.length;
    if(iVal > 10) {
      swal("Oops!", "You may add only " + (10 - existingRecs) + " more records!!!");
      return;
    }

    if(ads_ids.length > 0)
    {
      $.ajax({
        url: "/admin/add-new-featured-latest-blog-listing",
        type: 'POST',
        data: {ads_ids : ads_ids, from : from},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
          swal({
            title: 'Success!',
            text: 'Added sucessfully!',
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
            window.location.href = "/admin/blog-settings";
          })
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
    else{
      swal("Oops!", "Please select blog.");
    }
  });

  $('.delete_featured_listing_blog').click(function(){
    var name = $(this);
    var listing_id = name.attr('data-id');
    var from = name.attr('data-object');

    swal({
      title: "Are you sure?",
      text: "you want to remove.",
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
          url: "/admin/featured-listing-blog-delete",
          type: 'POST',
          data: {listing_id : listing_id, from : from},
          beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success : function (data)
          {
            swal({
              title: 'Success!',
              text: 'Removed sucessfully!',
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
              name.parent().parent().parent().remove();
              location.reload();
            })
          },
          error:function(){
            swal("Oops!", "Something went wrong.");
          }
        });
      }
    });
  });

  $(".ads_ids").change(function() {
    var name = $(this);
    var listing_id = name.val();
    var ads_ids = [];

    $("input.ads_ids:checked").each(function(){
      ads_ids.push($(this).val());
    });

    if(name.is(":checked")){
      $.ajax({
        url: "/admin/featured-listing-ad-ids-session",
        type: 'POST',
        data: {ads_ids : ads_ids},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
    else{
      $.ajax({
        url: "/admin/featured-listing-remove-ids-session",
        type: 'POST',
        data: {listing_id : listing_id},
        beforeSend: function (request) {
          return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success : function (data)
        {
        },
        error:function(){
          swal("Oops!", "Something went wrong.");
        }
      });
    }
  });
});
