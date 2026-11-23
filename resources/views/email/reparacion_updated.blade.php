<!DOCTYPE html> {{-- HTML5 document declaration --}}
<html lang="es"> {{-- Spanish language html root --}}
<head> {{-- Head metadata --}}
    <meta charset="UTF-8"> {{-- Character set --}}
    <title>Actualización de tu tabla de surf</title> {{-- Email title --}}
</head> {{-- Close head --}}
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;"> {{-- Body container --}}
    <h2 style="color: #FF2D20;">Actualización sobre tu tabla de surf</h2> {{-- Subject header --}}
    <p>Hola <strong>{{ $cliente->Nombre }} {{ $cliente->Apellido }}</strong>,</p> {{-- Greeting line --}}
    <p>Te informamos de que el estado de tu reparación ha cambiado a: <strong style="color: #FF2D20; font-size: 1.1em;">{{ $reparacion->Estado }}</strong>.</p> {{-- Status notice --}}
    <div style="background-color: #f7f7f7; border-left: 4px solid #FF2D20; padding: 15px; margin: 20px 0;"> {{-- Summary block --}}
        <p style="margin: 0 0 5px 0;"><strong>Código de Seguimiento:</strong> {{ $reparacion->tracking_code }}</p> {{-- Tracking code line --}}
        <p style="margin: 0 0 5px 0;"><strong>Tabla:</strong> {{ $reparacion->tablas?->Modelo ?? 'Tabla' }}</p> {{-- Board line --}}
        <p style="margin: 0;"><strong>Trabajo:</strong> {{ $reparacion->Reparacion }}</p> {{-- Damage line --}}
    </div> {{-- Close summary block --}}
    @if ($reparacion->Estado === 'Terminado') {{-- Check if completed --}}
        <p style="color: #15803d; font-weight: bold;">¡Tu tabla ya está lista para ser recogida en el taller!</p> {{-- Ready to pick notice --}}
    @endif {{-- Close status check --}}
    <p>Puedes consultar el progreso detallado y los detalles en cualquier momento en el siguiente enlace:</p> {{-- Link introduction --}}
    <p><a href="{{ route('reparaciones.track', $reparacion->tracking_code) }}" style="display: inline-block; background-color: #FF2D20; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;">Ver Estado de la Tabla</a></p> {{-- Direct link button --}}
    <p style="margin-top: 30px; font-size: 0.85em; color: #888;">Gracias por confiar en nosotros.<br>Equipo Wipeout</p> {{-- Signoff footer --}}
</body> {{-- Close body --}}
</html> {{-- Close html --}}
