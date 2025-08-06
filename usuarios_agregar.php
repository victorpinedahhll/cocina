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
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <div class="row" style="margin-top: 40px;">
                        <div class="col-md-12">
                            <div class="row box-menu mx-1 mb-2">
                                <div class="col-md-6 py-2">
                                    <h5 class="text-secondary m-0 p-0">
                                        <a href="usuarios.php" style="color: #002d59;">
                                            <i class="fa fa-angle-left"></i>
                                        </a>&nbsp;
                                        Agregar Usuario
                                    </h5>
                                </div>
                                <div class="col-md-6 py-2 text-right">
                                    
                                </div>
                            </div>
                    
                            <div class="box-items">
                                <div id="errores" style="color: red; margin-top: 10px;"></div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Usuario *</label>
                                        <input type="text" class="form-control" name="usuario" id="usuario" <?php if(!empty($postuseradd["usuario"])){ ?>value="<?php echo $postuseradd["usuario"]; ?>"<?php } ?>>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nivel del Usuario</label>
                                        <?php if($idsession=="1" && 1==2){ ?>
                                        <h5>Webmaster</h5>
                                        <?php }else{ ?>
                                        <select name="nivel" id="areaSelect" class="form-control">
                                            <option value="ENFERMERIA" <?php if($postuseradd["nivel"]=="ENFERMERIA"){ ?>selected<?php }else{ ?>selected<?php } ?>>Enfermería</option>
                                            <option value="COCINA" <?php if($postuseradd["nivel"]=="COCINA"){ ?>selected<?php } ?>>Supervisor de Cocina</option>
                                            <option value="AUXILIAR" <?php if($postuseradd["nivel"]=="AUXILIAR"){ ?>selected<?php } ?>>Auxiliar de Nutrición</option>
                                            <option value="ADMIN" <?php if($postuseradd["nivel"]=="ADMIN"){ ?>selected<?php } ?>>Administración</option>
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-row" id="areaux" style="display: none;">
                                    <div class="form-group col-md-12">
                                        <label>Área de Atención</label>
                                        <select name="area" class="form-control">
                                            <option value="">elija una</option>
                                            <?php 
                                            $qAR = "SELECT * FROM _areas WHERE _status='A'";
                                            $rAR = $conexion->query($qAR);
                                            while ($fAR = $rAR->fetch_assoc()){
                                            ?>
                                            <option value="<?php echo $fAR["_id"];?>"><?php echo $fAR["_nombre"];?></option>
                                            <?php } ?>
                                        </select>
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
                                <div class="form-row pb-4">
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
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 pl-5">
                            <h5 class="mb-0 pb-0 mt-5 text-secondary">Roles Usuario</h5>
                            <div id="checkboxes">
                                <?php 
                                $qCB = "SELECT _area FROM _roles GROUP by _area ORDER by _area desc";
                                $rCB = $conexion->query($qCB);
                                while ($fCB = $rCB->fetch_assoc()){
                                ?>
                                <div class="grupo pt-3" data-area="<?php echo $fCB["_area"]; ?>">
                                    <b><?php echo ucfirst($fCB["_area"]); ?></b><br>
                                    <?php
                                    $van  = 0;
                                    $areaCB = $fCB["_area"]; 
                                    $qCB2 = "SELECT * FROM _roles WHERE _area = '$areaCB'";
                                    $rCB2 = $conexion->query($qCB2);
                                    while ($fCB2 = $rCB2->fetch_assoc()){
                                        $van++;
                                        $mt = "";
                                        if($van==1){
                                            $mt = "mt-3";
                                        }
                                        ?>
                                        <input type="checkbox" <?php if($areaCB=="AUXILIAR"){ ?>id="<?php echo $fCB2["_nombre_sys"]; ?>"<?php } ?> class="rol-checkbox <?php echo $mt; ?>" name="roles[]" value="<?php echo $fCB2["_nombre_sys"]; ?>">&nbsp; <?php echo $fCB2["_nombre"]; ?><br>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                    </div>

                    <div class="form-row mt-4 mb-4 pl-4">
                        <div class="form-group col-md-5">
                            <input type="submit" class="btn btn-cocina px-4" name="formsubmit" value="Agregar usuario" style="font-size: 12pt !important; color: #fff;">
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
                if (areaSeleccionada === "AUXILIAR") {
                    $('#TOMA_PEDIDOS').prop('checked', true); // check de pacientes pedidos
                    // $('#areaux').show(); // se inactivo ya que la asignacion se haran programadas
                } else {
                    $(`.grupo[data-area="${areaSeleccionada}"] .rol-checkbox`).prop('checked', true);
                    // $('#areaux').hide(); // se inactivo ya que la asignacion se haran programadas
                }
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

