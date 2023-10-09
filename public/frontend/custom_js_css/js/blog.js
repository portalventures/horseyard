$('#blog_search').on('keypress',function(e) {
  if(e.which == 13) {
    var form = $('form.blog_search_form')[0];  
    form.submit();
  }
});

$(function() {
  $('ul.pagination li').each( function () {
    if($(this).find('a').length){
      var a_href_m = $(this).find('a').attr('href').split("&");

      if(a_href_m.indexOf("page=1") !== -1){        
        $(this).find('a').attr('href',$(this).find('a').attr('href').replace("&page=1",''));
      }
      var a_href_q = $(this).find('a').attr('href').split("?");
      console.log(a_href_q);
      if(a_href_q.indexOf("page=1") !== -1){        
        $(this).find('a').attr('href',$(this).find('a').attr('href').replace("?page=1",''));
      }
    }
  });

  // var li_last_page = $("#blog-list").attr('data-lastPage');  
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

  // if($("li.page-item.disabled").length > 1){
  //   var disabledPages = $("li.page-item");    
  //   $(disabledPages[3]).remove();
  //   $(disabledPages[4]).remove();
  //   $(disabledPages[5]).remove();
  //   $(disabledPages[6]).remove();
  //   $(disabledPages[7]).remove();
  // }
  // else
  // {
  //   var disabledPages = $("li.page-item");
  //   $(disabledPages[3]).remove();
  // }
});