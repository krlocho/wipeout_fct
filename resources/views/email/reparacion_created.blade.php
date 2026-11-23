<!DOCTYPE html> {{-- HTML5 document declaration --}}
<html lang="es"> {{-- Spanish language html root --}}
<head> {{-- Head metadata --}}
    <meta charset="UTF-8"> {{-- Character set --}}
    <title>Hemos recibido tu tabla de surf</title> {{-- Email title --}}
</head> {{-- Close head --}}
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;"> {{-- Body container --}}
    @php // PHP block to normalize data access
        $tracking_code = is_array($reparacion) ? ($reparacion['tracking_code'] ?? '') : ($reparacion->tracking_code ?? ''); // Retrieve tracking token safely
        $damage_desc = is_array($reparacion) ? ($reparacion['Reparacion'] ?? '') : ($reparacion->Reparacion ?? ''); // Retrieve damage text
    @endphp {{-- End PHP block --}}
    <h2 style="color: #FF2D20;">Tu tabla ya está en nuestro taller</h2> {{-- Header headline --}}
    <p>Estimado/a <strong>{{ $cliente->Nombre }} {{ $cliente->Apellido }}</strong>,</p> {{-- Greeting line --}}
    <p>Te confirmamos que hemos recibido tu tabla de surf y hemos registrado tu orden de reparación en nuestro sistema.</p> {{-- Confirmation body --}}
    <div style="background-color: #f7f7f7; border-left: 4px solid #FF2D20; padding: 15px; margin: 20px 0;"> {{-- Highlights box --}}
        <p style="margin: 0 0 5px 0;"><strong>Código de Seguimiento:</strong> <span style="font-family: monospace; font-size: 1.2em; font-weight: bold; color: #FF2D20;">{{ $tracking_code }}</span></p> {{-- Tracking token line --}}
        <p style="margin: 0;"><strong>Trabajo registrado:</strong> {{ $damage_desc }}</p> {{-- Damage description --}}
    </div> {{-- Close highlights box --}}
    <p>Puedes seguir el avance de tu tabla en cualquier momento a través de nuestro portal de seguimiento:</p> {{-- Explanatory line --}}
    <p><a href="{{ route('reparaciones.track', $tracking_code) }}" style="display: inline-block; background-color: #FF2D20; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: bold;">Rastrear mi Tabla</a></p> {{-- Action button --}}
    <p style="margin-top: 30px; font-size: 0.85em; color: #888;">Gracias por confiar en nuestro trabajo artesanal.<br>Equipo Wipeout</p> {{-- Signoff footer --}}
</body> {{-- Close body --}}
</html> {{-- Close html --}}
