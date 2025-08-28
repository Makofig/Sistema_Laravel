@if($status === 'success')
    <h1>Nueva cuota generada</h1>
    <p>Se generó correctamente la cuota para el período <strong>{{ $quota->periodo }}</strong>.</p>
    <p>Monto: <strong>${{ number_format($quota->monto, 2) }}</strong></p>
@else
    <h1>Error al generar cuota</h1>
    <p>No se pudo emitir la cuota.</p>
    <p><strong>Detalle del error:</strong> {{ $errorMessage }}</p>
@endif
<p>Fecha de generación: {{ $quota?->created_at ? $quota->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>