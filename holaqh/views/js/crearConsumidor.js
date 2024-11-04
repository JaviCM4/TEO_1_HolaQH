document.getElementById('tipoUsuario').addEventListener('change', function() {
    const tipoUsuario = document.getElementById('tipoUsuario');
    const formAnunciante = document.getElementById('formulario-anunciante');
    const formCliente = document.getElementById('formulario-cliente');
 
    if (tipoUsuario.value === 'cliente') {
        formAnunciante.style.display = 'none';
        formCliente.style.display = 'block';
    } else {
        formAnunciante.style.display = 'block';
        formCliente.style.display = 'none';
    }
});

document.getElementById('formulario-anunciante').style.display = 'none';
