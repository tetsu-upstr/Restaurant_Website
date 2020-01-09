// ハンバーガーボタン
jQuery(document).ready(function(){
  /* open */
  $('.header__icon').on('click',function(){
    $('.l-sidebar').css(
      'display','block'
    ).animate({
      left:'0'
    }, 
      300
    );
    $('.l-sidebar-bg').css(
      'display','block'
    ).animate({
      opacity:'0.5'
    },
      300
    )
  });

  /* close */
  $('.sidebar__icon').on('click',function(){
    $('.l-sidebar').animate({
      left:'-200px'
    },
      300
    );
    $('.l-sidebar-bg').animate({
      opacity:'0'
    },
      300
    );
    setTimeout(function(){
      $('.l-sidebar').css('display','none');
      $('.l-sidebar-bg').css('display','none');
    },
      300
    );
  });
});

  // コンテンツフェードイン
  $(window).scroll(function (){

      $('.js-fadein').each(function(){
        var elemPos = $(this).offset().top,
            scroll = $(window).scrollTop(),
            windowHeight = $(window).height();
            
          if (scroll > elemPos - windowHeight + 100){
              $(this).addClass('js-scrollin');
            }
      });
  });

// スクロールボタン
$(function() {
  var topBtn = $('#js-scrollTop');    
  topBtn.hide();
  // スクロールが100に達したらボタン表示
  $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {
          topBtn.fadeIn();
      } else {
          topBtn.fadeOut();
      }
  });
  // スクロールしてトップ
  topBtn.click(function () {
      $('body,html').animate({
          scrollTop: 0
      }, 500);
      return false;
  });
});