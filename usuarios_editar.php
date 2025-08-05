<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$titulo = "Control de Usuarios";
$nologg = "SI";
$page   = "usuarios";
$areaLg = "USUARIOS";  // valida roles del usuario

include("header.php");

$id   = $_GET["us"];
$qry  = "
    SELECT *
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'PACIENTES') AS PACIENTES
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'ORDENES') AS ORDENES
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'TOMA_PEDIDOS') AS TOMA_PEDIDOS
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'TIPO_MENU') AS TIPO_MENU
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'TIPO_DIETA') AS TIPO_DIETA
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'MENUS') AS MENUS
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'PROGRAMACION') AS PROGRAMACION
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'PEDIDOS') AS PEDIDOS
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'USUARIOS') AS USUARIOS
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'ALERGIAS') AS ALERGIAS 
    , (SELECT _rol FROM _usuarios_roles b WHERE b._usuario_id = a.id_us00 AND _rol = 'AREAS') AS AREAS 
    FROM _usuarios_admin a  
    WHERE id_us00 = ?
";
$stmt = $pdo->prepare($qry);
$stmt->execute([$id]);
$row  = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="row pt-0 mb-4">
	<div class="col-md-12 content-box position-relative">

		<div class="px-5" style="margin-top: 140px;">
			<form action="usuarios_grabar.php" method="POST" id="formRegistro">
            <input type="hidden" name="acceso" value="editar">
            <input type="hidden" name="id"     value="<?php echo $id; ?>">
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
                                        Editar Usuario
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
                                        <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $row["usuario_us13"]; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nivel del Usuario</label>
                                        <?php if($idsession=="1" && 1==2){ ?>
                                        <h5>Webmaster</h5>
                                        <?php }else{ ?>
                                        <select name="nivel" id="areaSelect" class="form-control">
                                            <option value="">elija nivel</option>
                                            <option value="ENFERMERIA" <?php if($row["nivel_wua67"]=="ENFERMERIA"){ ?>selected<?php } ?>>Enfermería</option>
                                            <option value="COCINA" <?php if($row["nivel_wua67"]=="COCINA"){ ?>selected<?php } ?>>Supervisor de Cocina</option>
                                            <option value="AUXILIAR" <?php if($row["nivel_wua67"]=="AUXILIAR"){ ?>selected<?php } ?>>Auxiliar de Nutrición</option>
                                            <option value="ADMIN" <?php if($row["nivel_wua67"]=="ADMIN"){ ?>selected<?php } ?>>Administración</option>
                                        </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-row" id="areaux" <?php if( $row["nivel_wua67"]!=="AUXILIAR" ){ ?>style="display: none;"<?php } ?>>
                                    <div class="form-group col-md-12">
                                        <label>Área de Atención</label>
                                        <select name="area" class="form-control">
                                            <option value="">elija una</option>
                                            <?php 
                                            $qAR = "SELECT * FROM _areas WHERE _status='A'";
                                            $rAR = $conexion->query($qAR);
                                            while ($fAR = $rAR->fetch_assoc()){
                                            ?>
                                            <option value="<?php echo $fAR["_id"];?>" <?php if($fAR["_id"]==$row["area_wua45"]){ echo "selected"; } ?>><?php echo $fAR["_nombre"];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Nombre *</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $row["nombre_us07"]; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $row["email_wua25"]; ?>">
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
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label>Estado</label> &nbsp;
                                        <input type="radio" name="status" value="1" <?php if( $row["status_wua32"]=="1" ){ echo "checked"; } ?>> Activo &nbsp; <input type="radio" name="status" value="0" <?php if( $row["status_wua32"]=="0" ){ echo "checked"; } ?>> Inactivo
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
                                <b><?php echo $fCB["_area"]; ?></b><br>
                                <?php
                                $van  = 0;
                                $areaCB = $fCB["_area"]; 
                                $qCB2 = "SELECT * FROM _roles WHERE _area = '$areaCB'";
                                $rCB2 = $conexion->query($qCB2);
                                while ($fCB2 = $rCB2->fetch_assoc()){
                                    $nomsys = $fCB2["_nombre_sys"];
                                    $van++;
                                    $mt = "";
                                    if($van==1){
                                        $mt = "mt-3";
                                    }
                                    ?>
                                    <input type="checkbox" <?php if($areaCB=="AUXILIAR"){ ?>id="<?php echo $fCB2["_nombre_sys"]; ?>"<?php } ?> class="rol-checkbox <?php echo $mt; ?>" name="roles[]" value="<?php echo $fCB2["_nombre_sys"]; ?>" <?php if(!empty($row[$nomsys]) && $row[$nomsys]==$fCB2["_nombre_sys"]){ echo "checked"; } ?>>&nbsp; <?php echo $fCB2["_nombre"]; ?><br>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-row mt-4 mb-4 pl-4">
                        <div class="form-group col-md-5">
                            <input type="submit" class="btn btn-cocina px-4" name="formsubmit" value="Salvar cambios" style="font-size: 12pt !important; color: #fff;">
                        </div>
                    </div>
                </div>
            </div>
            </form>
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
            } else if (areaSeleccionada === "AUXILIAR") {
                $('#TOMA_PEDIDOS').prop('checked', true); // check de pacientes pedidos
            } else {
                $(`.grupo[data-area="${areaSeleccionada}"] .rol-checkbox`).prop('checked', true);
            }
        });

        // ✅ Solo ejecutar cambio automático si no hay roles seleccionados desde PHP
        if ($('.rol-checkbox:checked').length === 0) {
            $('#areaSelect').trigger('change');
        }
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

  if (password !== '' || confirmar !== '') {
    // Si uno de los dos campos fue llenado, validamos ambos

    if (password.length < 6) {
        errores.push('La Contraseña debe tener al menos 6 caracteres');
        $('#password').css('border', '1px solid red');
    }

    if (confirmar === '') {
        errores.push('Debes confirmar la contraseña');
        $('#confirmar').css('border', '1px solid red');
    } else if (password !== confirmar) {
    errores.push('Las contraseñas no coinciden');
        $('#password, #confirmar').css('border', '1px solid red');
    }
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

