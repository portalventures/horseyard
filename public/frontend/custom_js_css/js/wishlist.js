$('.listing_add_into_wishlist').click(function(){
  var name = $(this);  
  var listing_token = name.attr('data-id');

  $.ajax({
    url: "/listing_add_into_wishlist",
    type: 'POST',
    data: {listing_token : listing_token},
    beforeSend: function (request) {
      return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
    },
    success:function(data)
    {
      if(data)
      {
        name.find('span').addClass('active');
        name.find('span.saved-text').html('saved');
      }
      else
      {
        name.find('span').removeClass('active');
        name.find('span.saved-text').html('save');
      }

      if(name.hasClass('account_wish_list'))
      {
        name.closest(".users_all_wishlist").remove();
      }
    },
    error:function(){
      swal("Oops!", "Something went wrong.");
    }
  });
});