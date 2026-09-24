(function(){
  "use strict";
  document.addEventListener("click", function(e){
    var botao=e.target.closest(".hq-mobile-toggle");
    var menus=document.querySelectorAll(".hq-mobile-menu.aberto");
    if(botao){
      var menu=botao.nextElementSibling;
      var abrir=!menu.classList.contains("aberto");
      menus.forEach(function(m){m.classList.remove("aberto");});
      document.querySelectorAll(".hq-mobile-toggle").forEach(function(b){b.setAttribute("aria-expanded","false");});
      if(abrir){menu.classList.add("aberto");botao.setAttribute("aria-expanded","true");}
      return;
    }
    if(!e.target.closest(".hq-acoes")){
      menus.forEach(function(m){m.classList.remove("aberto");});
      document.querySelectorAll(".hq-mobile-toggle").forEach(function(b){b.setAttribute("aria-expanded","false");});
    }
  });
})();
