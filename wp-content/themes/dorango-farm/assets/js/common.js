const createBurger=()=>{$("#js-burger").on("click",function(){$(this).hasClass("is-open")?($("#js-burger-target").fadeOut(),$("#js-header").attr("style",""),$(this).removeClass("is-open")):($("#js-burger-target").fadeIn(),$("#js-header").css({position:"fixed",top:"0",left:"0"}),$(this).addClass("is-open")),LockScrollY($(this))})};let openPosition=null;const LockScrollY=o=>{o.hasClass("is-open")?(openPosition=$(window).scrollTop(),$("body").css({width:"100%",position:"fixed",top:-openPosition})):($("body").attr("style",""),$(window).scrollTop(openPosition))},banScroll=()=>{document.addEventListener("mousewheel",controlScroll,{passive:!1}),document.addEventListener("touchmove",controlScroll,{passive:!1})},returnScroll=()=>{document.removeEventListener("mousewheel",controlScroll,{passive:!1}),document.removeEventListener("touchmove",controlScroll,{passive:!1})},controlScroll=o=>{o.preventDefault()},scrollSmooth=()=>{$('a[href^="#"]').on("click",function(){var o=$(this).attr("href"),o=$("#"==o||""==o?"html":o).offset().top+0;return $("body,html").animate({scrollTop:o},400,"swing"),!1})},validateSearch=()=>{$(".js-serach-btn").on("click",function(){$(".js-serach-input").val()&&$(".js-serach-form").submit()})},addMargin=()=>{$(window).on("load resize",function(){var o,e;$(window).width()<=750&&$("#js-gnav-sp").length?(o=$("#js-gnav-sp").height(),o+=50,e=$("#js-header").height(),$("#js-footer").css("padding-bottom",o),$("#js-menu-inner").css("margin-bottom",o),$("#js-menu-inner").css("margin-top",e)):($("#js-footer").css("padding-bottom",""),$("#js-menu-inner").css("margin-bottom",""),$("#js-menu-inner").css("margin-top",""))})};validateSearch(),scrollSmooth(),createBurger();