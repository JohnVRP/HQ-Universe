async function calcularFreteHQ(inputId, resultadoId, hiddenPrefix){
  const input=document.getElementById(inputId), box=document.getElementById(resultadoId);
  const cep=(input.value||'').replace(/\D/g,'');
  box.style.display='block'; box.classList.remove('hq-frete-erro');
  if(cep.length!==8){box.classList.add('hq-frete-erro');box.textContent='Digite um CEP com 8 números.';return null;}
  box.textContent='Consultando CEP...';
  try{
    const r=await fetch('https://viacep.com.br/ws/'+cep+'/json/');
    const d=await r.json(); if(d.erro)throw new Error('CEP não encontrado');
    const sudeste=['SP','RJ','MG','ES'], sul=['PR','SC','RS'], centro=['DF','GO','MT','MS'];
    let valor=29.90,prazo='7 a 12 dias úteis';
    if(d.uf==='SP'){valor=12.90;prazo='2 a 4 dias úteis';}
    else if(sudeste.includes(d.uf)){valor=18.90;prazo='3 a 6 dias úteis';}
    else if(sul.includes(d.uf)){valor=22.90;prazo='4 a 7 dias úteis';}
    else if(centro.includes(d.uf)){valor=25.90;prazo='5 a 9 dias úteis';}
    else if(['BA','SE','AL','PE','PB','RN','CE','PI','MA'].includes(d.uf)){valor=31.90;prazo='7 a 12 dias úteis';}
    else if(['AM','PA','AC','RO','RR','AP','TO'].includes(d.uf)){valor=39.90;prazo='9 a 16 dias úteis';}
    const endereco=[d.logradouro,d.bairro,d.localidade+' - '+d.uf].filter(Boolean).join(', ');
    box.innerHTML='<strong>'+endereco+'</strong><br>Frete simulado: R$ '+valor.toFixed(2).replace('.',',')+' — '+prazo+'<br><small>Origem: <b>São Paulo/SP</b>.</small>';
    if(hiddenPrefix){
      document.getElementById(hiddenPrefix+'_cep').value=cep;
      document.getElementById(hiddenPrefix+'_endereco').value=endereco;
      document.getElementById(hiddenPrefix+'_frete').value=valor.toFixed(2);
      document.getElementById(hiddenPrefix+'_prazo').value=prazo;
    }
    return {cep,endereco,valor,prazo};
  }catch(e){box.classList.add('hq-frete-erro');box.textContent='Não foi possível consultar o CEP. Verifique sua conexão e tente novamente.';return null;}
}
