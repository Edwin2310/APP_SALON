<h1 class="nombre-pagina">¿Olvidó Su Contraseña?</h1>
<p class="descripcion-pagina">Reestablece tu contraseña escribiendo tu email a continuación.</p>

<!-- AGREGANDO ALERTAS -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<!-- FORMULARIO DE LOGIN -->
<form class="formulario" action="/olvide" method="POST">

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Tu E-mail">
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">

</form>
<!-- FIN FORMULARIO DE LOGIN -->

<div class="acciones">
    <a href="/">¿Ya tiene una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea Una</a>

</div>