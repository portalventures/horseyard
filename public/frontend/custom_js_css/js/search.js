$(function() {

  $(".search_discipline, .search_breed_primary, .search_age, .search_state, .search_gender, .search_rider_Level, .search_color, .sortBy, .perpage").change(function() {    
    search_listing_form();
  });

  $(".MaxMinHeight_btn, .MaxMinAge_btn, .keyword_SN_txt_btn").click(function() {    
    search_listing_form();
  });


  $(".category").change(function() {
    $("input[type=checkbox]").prop('checked', false);
    search_listing_form();
  });

  $(".search_trans_type, .search_no_of_horses, .search_ramplocation, .search_saddlerytype, .search_property_category, .search_property_Bedrooms, .search_property_Bathrooms").change(function() {
    search_listing_form();
  });

  $(".clear_all_filters").click(function() {
    if($(this).attr("checked")) $('input:checkbox').attr('checked','checked');
    else $('input:checkbox').removeAttr('checked');

    //$(".clearfilter :selected").remove();
    $(".clearfilter").each(function () {
      $(this).val($(this).find("option:first").val()).trigger('change');      
    })
    $("#keyword_txt").val('');
    //window.location.replace($(this).data('href'));
    search_listing_form();
  });

  function search_listing_form()
  {
    var form = $('form.search_page_form')[0];
    form.submit();
  }

  $('ul.pagination li').each( function () {
    if($(this).find('a').length){
      var a_href_m = $(this).find('a').attr('href').split("&");

      if(a_href_m.indexOf("page=1") !== -1){        
        $(this).find('a').attr('href',$(this).find('a').attr('href').replace("&page=1",''));
      }
      var a_href_q = $(this).find('a').attr('href').split("?");
      
      if(a_href_q.indexOf("page=1") !== -1){        
        $(this).find('a').attr('href',$(this).find('a').attr('href').replace("?page=1",''));
      }
    }
  });

  // var li_last_page = $(".search-result-listing").attr('data-lastPage');  
  // $("li.page-item")[0].remove();  
  
  // if(li_last_page >10)
  // {    
  //   $('ul.pagination li').each( function () {
  //     var page_link = $(this).find('.page-link');
  //     var page_link_text = page_link.text();
  //     var last_li_rel = page_link.attr('rel');    
      
  //     console.log($(this).attr('aria-label'));
  //     if($(this).attr('aria-label') == 'Next »')
  //     {
  //       console.log('true');
  //     }
  //     if(page_link_text != 1 && page_link_text != 2 && page_link_text != li_last_page && page_link_text != '...' && last_li_rel != 'next' && $(this).attr('aria-label') != 'Next »'){
  //       console.log('in if');
  //       $(this).remove();
  //     }
  //   });  
  // }
});
