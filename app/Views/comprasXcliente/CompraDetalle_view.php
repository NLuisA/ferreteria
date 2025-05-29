<?php 
$session = session();
$perfil = $session->get('perfil_id');

$VTO_CAE = '';
$motivo = '';
$total_anterior = '';
$monto_efectivo = 0;
$monto_transferencia = 0;
$monto_tarjetaC = 0;
$total_sin_desc = 0;
$estado = '';
$vta_num = 0;
?>
<style>
  /* Estilos para las celdas de la tabla */
.detalle-compra-tabla td {
    color: white; /* Letra blanca */
    font-weight: bold; /* Negrita */
}

</style>
<div style="width: 100%;">
  <div style="text-align:center;">
<br><br>
<a class="detalle-compra-titulo btn" align="center" href="javascript:history.back()">⬅ Volver</a>
</div>
<div style="clear: both;"></div>
<br>

<h2 class="detalle-compra-titulo">Detalle de la Compra</h2>
<br>

<?php if (!empty($ventas)): ?>
  <?php foreach ($ventas as $vta): ?>
    <?php 
    if ($vta['vto_cae'] != null) {
        $VTO_CAE = date('d-m-Y', strtotime($vta['vto_cae']));
    }
    if (!empty($vta['motivo'])) {
        $motivo = $vta['motivo'];
    }
    if (!empty($vta['total_anterior'])) {
        $total_anterior = $vta['total_anterior'];
    }
    if (!empty($vta['total_bonificado'])) {
      $total_actual = $vta['total_bonificado'];
    }
    if (!empty($vta['monto_efectivo'])) {
      $monto_efectivo = $vta['monto_efectivo'];
    }
    if (!empty($vta['monto_transferencia'])) {
      $monto_transferencia = $vta['monto_transferencia'];
    }
    if (!empty($vta['monto_tarjetaC'])) {
      $monto_tarjetaC = $vta['monto_tarjetaC'];
    }
    if (!empty($vta['total_venta'])) {
      $total_sin_desc = $vta['total_venta'];
    }
    if (!empty($vta['estado'])) {
      $estado = $vta['estado'];
    }
    if (!empty($vta['venta_numero'])) {
      $vta_num = $vta['venta_numero'];
    }
    ?>
  <?php endforeach; ?>
<?php endif; ?>

<!-- Mostrar solo si existe un CAE -->
<?php if ($VTO_CAE != ''): ?>
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Nro Factura</th>
          <th>CAE</th>
          <th>Vencimiento CAE</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td><?php echo $vta['id_cae']; ?></td>
          <td><?php echo $vta['cae']; ?></td>                   
          <td><?php echo $VTO_CAE; ?></td>
      </tr>
    </tbody>
  </table>
<?php endif; ?>

<!-- Mostrar motivo si existe -->
<?php if ($motivo != ''): ?>
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Venta Modificada sin Facturar (Modificada_SF) Motivo:</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td class="color"><?php echo $motivo; ?></td>
      </tr>
    </tbody>
  </table>
<?php endif; ?>

<!-- Mostrar total anterior si existe -->
<?php if ($total_anterior != ''): ?>
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Total Anterior</th>
          <th>Total Actual</th>
          <th style="color:orange;">Diferencia</th>
      </tr>
      <br>
    </thead>
    <tbody>
      <tr>
          <td>$ <?php echo $total_anterior; ?></td>
          <td>$ <?php echo $total_actual; ?></td>
          <td style="color:orange;">$ <?php echo $total_actual - $total_anterior; ?></td>
      </tr>
    </tbody>
  </table>
<?php endif; ?>

<br>
<div class="detalle-compra-tabla-container">
        <!-- Numero de Venta -->
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Nro COD</th>
         
      </tr>
      <br>
    </thead>
    <tbody>
      <tr>
          <td><?php echo $vta_num; ?></td>
          
      </tr>
    </tbody>
  </table>
  <br>
  <!-- Detalle de la venta -->
  <table class="detalle-compra-tabla comprados">
    <thead>
      <tr>
        <th>ID Producto</th>
        <th>Nombre</th>
        <th>Cantidad Comprada</th>
        <th>Precio Unitario</th>
        <th>Total x Producto</th>          
      </tr>
    </thead>
    <tbody>
      <?php if ($ventas): ?>
        <?php foreach ($ventas as $vta): ?>
          <tr>
            <form method="post" action="<?= base_url('ventas/actualizarPrecioDetalle') ?>">
          <input type="hidden" name="id_detalle" value="<?= $vta['id'] ?>">
            <td><?php echo $vta['id'];?></td>
            <td><?php echo $vta['nombre']; ?></td>
            <td><?php echo $vta['cantidad']; ?></td>
            <td>$ <?php echo $vta['precio']; ?>
            <?php if($estado == 'Pendiente'):?>
            <input type="number" name="nuevo_precio" value="<?= $vta['precio'] ?>" min="0" step="0.01">
            <button type="submit">Actualizar</button>
            <?php endif;?>
          </td>
            <td>$ <?php echo $vta['total']; ?></td>
            </form>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <?php if($estado != 'Pendiente') {  ?>
  <!-- Total venta con descuento-->
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Pago Efectivo</th>
          <th>Pago Transferencia</th>
          <th>Pago Tarteja C.Adi.</th>
          <th>Total</th>
      </tr>
      <br>
    </thead>
    <tbody>
      <tr>
          <td>$ <?php echo $monto_efectivo; ?></td>
          <td>$ <?php echo $monto_transferencia; ?></td>
          <td>$ <?php echo $monto_tarjetaC; ?></td>
          <td style="background-color:green;">$ <?php echo $monto_transferencia + $monto_efectivo + $monto_tarjetaC; ?></td>
      </tr>
    </tbody>
  </table>
        <!-- Totales con desc y sin y adicionaes o no-->
        </table>
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Total Con Descuento Pago Efectivo y Pago Tarjeta Sin Adicional</th>
         
      </tr>
      <br>
    </thead>
    <tbody>
      <tr>

      <td>$ <?php echo $monto_transferencia + $monto_efectivo + ($monto_tarjetaC / 1.1); ?></td>
          
      </tr>
    </tbody>
  </table>
  <?php } ?>
        <!-- Total venta sin descuento-->
  </table>
  <table class="comprados detalle-compra-tabla">
    <thead>
      <tr>
          <th>Total Sin Descuentos Ni Adicionales</th>
         
      </tr>
      <br>
    </thead>
    <tbody>
      <tr>
          <td>$ <?php echo $total_sin_desc; ?></td>
          
      </tr>
    </tbody>
  </table>
</div>

<br>
