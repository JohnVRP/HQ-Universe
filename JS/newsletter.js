(function(){
  document.addEventListener("submit",function(e){
    var form=e.target; if(form.id!=="hq-newsletter-form") return; e.preventDefault();
    var msg=document.getElementById("hq-newsletter-msg"); var btn=form.querySelector("button"); btn.disabled=true;
    fetch(form.action,{method:"POST",body:new FormData(form),headers:{"Accept":"application/json","X-Requested-With":"XMLHttpRequest"}})
      .then(function(r){return r.json().then(function(d){if(!r.ok||!d.ok) throw d; return d;});})
      .then(function(d){msg.textContent=d.mensagem;msg.className="sucesso";form.reset();})
      .catch(function(d){msg.textContent=(d&&d.mensagem)||"Não foi possível cadastrar agora.";msg.className="erro";})
      .finally(function(){btn.disabled=false;});
  });
})();
