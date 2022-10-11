$(document).ready(function () {

    // .section1 스와이퍼
    const swiper = new Swiper('.section1 .swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,

        autoplay: {
            delay: 3000,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var swiper2 = new Swiper(".section5 .swiper-container", {
        slidesPerView: 3,
        spaceBetween: 50,
        grabCursor: true,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    


    // 메뉴열기 클릭
    $('.nav_btn').on('click', function () {
        const $gnb = $('#gnb');
        const $first = $gnb.find('[data-link="first"]');
        const $last = $gnb.find('[data-link="last"]');
        const wrapHei = $('#wrap').outerHeight();

        // #wrap의 높이값을 html, body 높이로 강제 지정 
        $('html, body').css({height: wrapHei, overflow: 'hidden'});

        //열기
        $(this).addClass('on').find('.blind').text('주메뉴 닫기');
        $(this).next().stop().fadeIn('fast');
        $gnb.css({visibility: 'visible'}).stop().animate({right: 0}, 300, function () {
            $first.focus();   //대상 엘리먼트에 포커스를 강제로 이동
        });

        //첫번째 a 태그에서 shift+tab을 눌러 header의 영역으로 포커스가 이동하지 못하게 제한
        $first.on('keydown', function (e) {
            console.log(e.keyCode);   //tab을 클릭하면 9를 반환
            if ( e.shiftKey && e.keyCode == 9) {
                e.preventDefault();   //포커스 이동을 강제로 제한
                $last.focus();        //처음 포커스로 이동, #gnbWrap을 벗어나지 않고 순환됨
            }
        });
        $last.on('keydown', function (e) {
            if (!e.shiftKey && e.keyCode == 9) {
                e.preventDefault();
                $('.nav_btn').focus();
            }
        });

        // 닫기
        $('.arrow, #dim').click(function () { 
            $('html, body').removeAttr('style');
            $('.nav_btn').removeClass('on').find('.blind').text('주메뉴 열기');
            $('#dim').stop().fadeOut('fast');  //dim 보이기

            $gnb.stop().animate({right: '-391px'}, 300, function () {
                $(this).css({visibility: 'hidden'}).children('ul').stop().animate({maxHeight: 0}, 'fast', function () {});
            });
        });

    });


    
    $(document).on('scroll', function(){
        // 오감과 함께할 당신에게,
        $('h2 .to_left').css("left", Math.max(130 - 0.1*window.scrollY, 1) + "vw");
        $('.section6 h2 .to_left').css("left", Math.max( 380 - 0.1*window.scrollY, 1) + "vw");
        $('h2 .to_right').css("right", Math.max(130 - 0.1*window.scrollY, 1) + "vw");
    });


    // section3 타이핑효과
    $(".typed").typed({
        strings: ["Software Development", "Design&#59; Publishing", "UX &#38; UI Planning", "QA&#59; QC part", "Online Marketing"],
        typeSpeed: 100,
        loop: true,
    });

    function trick () {
        $('.txt_right p:first-of-type').fadeOut(function () {
            $(this).appendTo($('.txt_right')).fadeIn(100);
        });
    }
    setInterval(function () { trick()}, 3700);


    // 포트폴리오 부분
    // const $sticky_wrap = $('.sticky_wrap');
    // const stickyWrapY = $sticky_wrap.offset().top;  //.sticky_wrap이 상단 브라우저에서 떨어진 거리
    // const stickyWrapHei = $sticky_wrap.outerHeight(); //.sticky_wrap의 세로 높이(border 포함)
    // console.log(stickyWrapY, stickyWrapHei);  // 4920 4225

    // $(window).on('scroll', function () {
    //     const scrollY = $(this).scrollTop();    //스크롤바 이동거리
    //     const leftMove = scrollY - stickyWrapY; // absolute를 가지는 .hor_long의 left좌표
    //     console.log(leftMove);
    //     const hor_long = $('.hor_long').width();
    //     $sticky_wrap.css('height', hor_long);

    //     if (scrollY < stickyWrapY - $(window).height()/10) {  //.cnt_top이 보여지는 동안: left 0고정, 스크롤을 빨리 움직이는 사용자 때문에 조금만 빨리 animate()
    //     /* gsap.to('#box', {rotation: 27, x: 100, duration: 1});
    //     첫 번째 파라미터는 트윈 할 대상(Target)
    //     두 번째 속성(Properties) */
    //     gsap.to('.hor_long', {left: 0, duration: 0.5, ease: Power3.easeOut});
    //     } else if (scrollY < stickyWrapY + stickyWrapHei - $(window).height()) { //.cnt_btm이 보이지 전 : left=> 스크롤바의 이동거리-.sticky_wrap의수직위치
    //     gsap.to('.hor_long', {left: -leftMove, duration: 0.5, ease: Power3.easeOut});
    //     }
    // });
   

    // 더보기버튼
    $('.btn_more p').click(function () {
        $('.more').addClass('on');
    });



    // fade효과
    // 1) scroll 이벤트 선언
    $(window).on('scroll', function () {
    // 2) 스크롤바의 수직 이동거리를 변수에 저장(스크롤을 빨리 움직이는 사용자를 위해 값을 더해주기)
    const scrollY = $(this).scrollTop() + $(this).height()* 3/4;

    // 3) 스크롤바의 수직이동거리와 나(보여질 컨텐츠)의 위치가 가까워질 경우만 .fade.on 클래스명 추가
    $('.fade').each(function (idx, ele) {
      if (scrollY > $(this).offset().top) $(this).addClass('on');
      // 하단에서 상단으로 다시 올렸을때 효과가 반복되길 바란다면 추가 
      else $(this).removeClass('on');
    });


    // 스크롤이 근처에 도달시 애니메이션 실행
    const scrollTop = $(this).scrollTop();
    $('.road').each(function (idx, ele) {
        const road1 = $('.road1').offset().top;
        const road2 = $('.road2').offset().top;
        if (scrollTop + 1100 >= road1) {
            $('.road1').addClass('on');
        } else{
            $('.road1').removeClass('on');
        }
        if (scrollTop + 1100 >= road2) {
            $('.road2').addClass('on');
        } else{
            $('.road2').removeClass('on');
        }
        console.log(scrollTop, road1);
    });

    $('.illust').each(function (idx, ele) {
        const footer = $('footer').offset().top;
        if (scrollTop + 1200 >= footer) {
            $(this).addClass('on');
        }
        else{
            $(this).removeClass('on');
        }
    });

  });


});