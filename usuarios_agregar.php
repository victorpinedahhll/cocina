<?php
$titulo = "Control de Usuarios";
$nologg = "SI";
$page   = "usuarios";
$areaLg = "USUARIOS";  // valida roles del usuario

include("header.php");

$postuseradd = $_SESSION["formadduser"];
?>


<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="px-5" style="margin-top: 140px;">
			<form action="usuarios_grabar.php" method="POST" id="formRegistro">
            <input type="hidden" name="acceso" value="agregar">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="pl-4 mb-4 mt-5"><a href="Javascript:history.back();" style="color: #82909d;"><i class="fa fa-caret-left"></i>&nbsp; regresar</a></h5>
                    <div class="row content-text" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <h3>Nuevo usuario</h3>
                            <div id="errores" style="color: red; margin-top: 10px;"></div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Usuario *</label>
                                    <input type="text" class="form-control" name="usuario" id="usuario" <?php if(!empty($postuseradd["usuario"])){ ?>value="<?php echo $postuseradd["usuario"]; ?>"<?php } ?>>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nivel</label>
                                    <?php if($idsession=="1" && 1==2){ ?>
                                    <h5>Webmaster</h5>
                                    <?php }else{ ?>
                                    <select name="nivel" id="areaSelect" class="form-control">
                                        <option value="ENFERMERIA" <?php if($postuseradd["nivel"]=="ENFERMERIA"){ ?>selected<?php }else{ ?>selected<?php } ?>>Enfermería</option>
                                        <option value="COCINA" <?php if($postuseradd["nivel"]=="COCINA"){ ?>selected<?php } ?>>Cocina</option>
                                        <option value="AUXILIAR" <?php if($postuseradd["nivel"]=="AUXILIAR"){ ?>selected<?php }else{ ?>selected<?php } ?>>Auxiliar de Cocina</option>
                                        <option value="ADMIN" <?php if($postuseradd["nivel"]=="ADMIN"){ ?>selected<?php } ?>>Administración</option>
                                    </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nombre *</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" <?php if(!empty($postuseradd["nombre"])){ ?>value="<?php echo $postuseradd["nombre"]; ?>"<?php } ?>>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="email" <?php if(!empty($postuseradd["email"])){ ?>value="<?php echo $postuseradd["email"]; ?>"<?php } ?>>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" name="pass1" id="password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="pass2" id="confirmar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 pl-5 pt-3">
                            
                        <h5 class="mb-0 pb-0 mt-5 text-secondary">Roles Usuario</h5>

                            <div id="checkboxes">
                                <div class="grupo pt-3" data-area="ENFERMERIA">
                                    <b>Enfermería</b><br>
                                    <input type="checkbox" class="rol-checkbox mt-3" name="roles[]" value="PACIENTES">&nbsp; Pacientes<br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="ORDENES">&nbsp; Ordenes Médicas
                                </div>

                                <div class="grupo pt-3" data-area="AUXILIAR">
                                    <b>Auxiliar de Cocina</b><br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="TOM_PEDIDOS">&nbsp; Pedidos a Pacientes
                                </div>

                                <div class="grupo pt-3" data-area="COCINA">
                                    <b>Cocina</b><br>
                                    <input type="checkbox" class="rol-checkbox mt-3" name="roles[]" value="TIPO_MENU">&nbsp; Tipos de Menus<br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="TIPO_DIETA">&nbsp; Tipos de Dieta<br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="MENUS">&nbsp; Platos Menu<br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="PROGRAMACION">&nbsp; Programación de Menus<br>
                                    <input type="checkbox" class="rol-checkbox" name="roles[]" value="PEDIDOS">&nbsp; Pedidos
                                </div>

                                <div class="grupo pt-3" data-area="ADMIN">
                                    <b>Administración</b><br>
                                    <input type="checkbox" class="rol-checkbox mt-3" name="roles[]" value="USUARIOS">&nbsp; Control de Usuarios
                                </div>
                        </div>
                    </div>

                    <div class="form-row mt-4 mb-4 pl-4">
                        <div class="form-group col-md-5">
                            <input type="submit" class="btn btn-secondary px-4" name="formsubmit" value="Agregar usuario" style="font-size: 12pt !important; color: #fff;">
                        </div>
                    </div>
                </div>
                </form>
            </div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function () {
        $('#areaSelect').on('change', function () {
            const areaSeleccionada = $(this).val();

            // Desmarcar todos primero
            $('.rol-checkbox').prop('checked', false);

            if (areaSeleccionada === "ADMIN") {
                $('.rol-checkbox').prop('checked', true); // Todos los checkboxes
            } else {
                $(`.grupo[data-area="${areaSeleccionada}"] .rol-checkbox`).prop('checked', true);
            }
        });

        // Ejecutar selección inicial (por defecto "enfermeria")
        $('#areaSelect').trigger('change');
    });

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#formRegistro').submit(function(e) {
  e.preventDefault(); // evita el envío si hay errores

  let errores = [];

  let usuario = $('#usuario').val().trim();
  let nombre = $('#nombre').val().trim();
  let email = $('#email').val().trim();
  let password = $('#password').val();
  let confirmar = $('#confirmar').val();

  // Limpia errores anteriores
  $('#errores').html('');
  $('input').css('border', '');

  if (usuario === '') {
    errores.push('El campo Usuario es obligatorio');
    $('#usuario').css('border', '1px solid red');
  }

  if (nombre === '') {
    errores.push('El campo Nombre es obligatorio');
    $('#nombre').css('border', '1px solid red');
  }

//   if (email === '') {
//     errores.push('El campo Email es obligatorio');
//     $('#email').css('border', '1px solid red');
//   } else if (!/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
//     errores.push('El Email no tiene un formato válido');
//     $('#email').css('border', '1px solid red');
//   }

  if (email !== '' && !/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
    errores.push('El Email no tiene un formato válido');
    $('#email').css('border', '1px solid red');
  }

  if (password === '') {
    errores.push('La Contraseña es obligatoria');
    $('#password').css('border', '1px solid red');
  } else if (password.length < 6) {
    errores.push('La Contraseña debe tener al menos 6 caracteres');
    $('#password').css('border', '1px solid red');
  }


  if (confirmar === '') {
    errores.push('Debes confirmar la contraseña');
    $('#confirmar').css('border', '1px solid red');
  } else if (password.length >= 6 && password !== confirmar) {
    // errores.push('Las contraseñas no coinciden');
    $('#password, #confirmar').css('border', '1px solid red');
  }


  if (password !== '' && confirmar !== '' && password !== confirmar) {
    errores.push('Las contraseñas no coinciden');
    $('#password, #confirmar').css('border', '1px solid red');
  }

  if (errores.length > 0) {
    $('#errores').html('<ul><li>' + errores.join('</li><li>') + '</li></ul>');
  } else {
    // Si todo está bien, podrías enviar con AJAX o permitir el envío normal
    this.submit(); // o hacer el submit manual
  }
});
</script>


<?php include("footer.php"); ?>

