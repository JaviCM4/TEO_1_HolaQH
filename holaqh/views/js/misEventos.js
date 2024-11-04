const mensaje = document.getElementById('mensaje');

if (mensaje) {
    mensaje.style.display = 'block';

    // Ocultar el mensaje después de 5 segundos
    setTimeout(() => {
        mensaje.style.display = 'none';
    }, 5000); // 5000 milisegundos = 5 segundos
}