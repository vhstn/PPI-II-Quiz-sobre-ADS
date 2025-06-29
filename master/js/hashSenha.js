async function hashSenha(senha) {
    const encoder = new TextEncoder();
    const data = encoder.encode(senha);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer)); 
    const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join(''); 
    return hashHex;
}

function monitorarSenha(campoOrigem, campoDestino) {
    document.getElementById(campoOrigem).addEventListener('change', async (event) => {
        const senhaDigitada = event.target.value.trim();
        const campoSenhaHash = document.getElementById(campoDestino);
    
        if (senhaDigitada === '') {
          campoSenhaHash.value = '';
          return;
        }
    
        campoSenhaHash.value = await hashSenha(senhaDigitada);
      });
}