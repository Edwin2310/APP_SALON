<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuación</p>

<!-- AGREGANDO ALERTAS -->
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>



<!-- If para que no me aparezca el campo -->
<?php if ($error) return; ?>


<!-- FORMULARIO DE LOGIN -->
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nueva contraseña">
    </div>
    <input type="submit" class="boton" value="Guardar Nueva Contraseña">
</form>
<!-- FIN FORMULARIO DE LOGIN -->

<div class="acciones">
    <a href="/">¿Ya tiene una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crea Una</a>
</div>