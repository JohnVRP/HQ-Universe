(function () {
  "use strict";

  var timer = null;

  function mostrarToast(mensagem, sucesso) {
    var toast = document.getElementById("hq-cart-toast");
    var texto = document.getElementById("hq-toast-texto");
    if (!toast || !texto) return;

    texto.textContent = mensagem || (sucesso ? "Produto adicionado ao carrinho." : "Não foi possível adicionar o produto.");
    toast.classList.toggle("hq-toast-erro", !sucesso);
    toast.classList.add("visivel");

    window.clearTimeout(timer);
    timer = window.setTimeout(function () {
      toast.classList.remove("visivel");
    }, 5000);
  }

  document.addEventListener("click", function (event) {
    var fechar = event.target.closest(".hq-toast-fechar");
    if (fechar) {
      var toast = document.getElementById("hq-cart-toast");
      if (toast) toast.classList.remove("visivel");
      window.clearTimeout(timer);
    }
  });

  document.addEventListener("submit", function (event) {
    var form = event.target;
    if (!(form instanceof HTMLFormElement)) return;
    var action = form.getAttribute("action") || "";
    if (action.indexOf("carrinho_adicionar.php") === -1) return;

    event.preventDefault();
    var botao = form.querySelector("button[type=submit], input[type=submit]");
    if (botao) botao.disabled = true;

    fetch(form.action, {
      method: "POST",
      body: new FormData(form),
      headers: { "X-Requested-With": "XMLHttpRequest", "Accept": "application/json" },
      credentials: "same-origin"
    })
      .then(function (resposta) {
        return resposta.json().catch(function () {
          return { ok: false, mensagem: "Resposta inválida do servidor." };
        }).then(function (dados) {
          if (!resposta.ok || !dados.ok) throw dados;
          return dados;
        });
      })
      .then(function (dados) {
        var contador = document.getElementById("hq-carrinho-qtd");
        if (contador && typeof dados.quantidade !== "undefined") contador.textContent = dados.quantidade;
        mostrarToast(dados.mensagem, true);
      })
      .catch(function (erro) {
        mostrarToast(erro && erro.mensagem ? erro.mensagem : "Não foi possível adicionar o produto.", false);
      })
      .finally(function () {
        if (botao) botao.disabled = false;
      });
  });
})();
