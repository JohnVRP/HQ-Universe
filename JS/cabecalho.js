(function () {
  var alvo = document.getElementById("cabecalho-hq");
  if (!alvo) return;
  var endpoint = alvo.getAttribute("data-endpoint") || "cabecalho_publico.php";

  fetch(endpoint, { credentials: "same-origin" })
    .then(function (resposta) {
      if (!resposta.ok) throw new Error("Cabeçalho indisponível");
      return resposta.text();
    })
    .then(function (html) {
      alvo.innerHTML = html;
      if (!document.querySelector('script[data-hq-carrinho-popup]')) {
        var src = new URL(endpoint, window.location.href);
        src.pathname = src.pathname.replace(/\/Projeto\/cabecalho_publico\.php$/, "/JS/carrinho-popup.js");
        var script = document.createElement("script");
        script.src = src.href;
        script.defer = true;
        script.setAttribute("data-hq-carrinho-popup", "1");
        document.body.appendChild(script);
      }
      if (!document.querySelector('script[data-hq-menu-mobile]')) {
        var src2 = new URL(endpoint, window.location.href);
        src2.pathname = src2.pathname.replace(/\/Projeto\/cabecalho_publico\.php$/, "/JS/menu-mobile.js");
        var script2 = document.createElement("script"); script2.src=src2.href; script2.defer=true; script2.setAttribute("data-hq-menu-mobile","1"); document.body.appendChild(script2);
      }
    })
    .catch(function () { alvo.innerHTML = ""; });
})();
