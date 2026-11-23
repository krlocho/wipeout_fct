<!DOCTYPE html> {{-- HTML5 document standard doctype --}}
<html lang="es"> {{-- Spanish document root language --}}
<head> {{-- Head document metadata --}}
    <meta charset="utf-8"> {{-- Character encoding UTF-8 --}}
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Viewport settings --}}
    <title>Ticket #{{ $reparacion->tracking_code }} | Taller Wipeout</title> {{-- Page title with tracking token --}}
    <link rel="preconnect" href="https://fonts.bunny.net"> {{-- Preconnect Google fonts --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&family=space-mono:700&display=swap" rel="stylesheet" /> {{-- Fonts bundle --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Vite asset pipeline --}}
    <style> {{-- Internal print styles sheet --}}
        @media print { {{-- Media query for printing --}}
            .no-print { display: none !important; } {{-- Hide print buttons and navigation --}}
            body { background: white !important; color: black !important; padding: 0 !important; } {{-- Reset page background --}}
            .print-container { box-shadow: none !important; border: 1px solid #111 !important; margin: 0 auto !important; max-width: 100% !important; } {{-- Full print layout --}}
            @page { margin: 10mm; size: auto; } {{-- Standard printer margins --}}
        } {{-- End of media print block --}}
    </style> {{-- Close print style element --}}
</head> {{-- Close head element --}}
<body class="bg-zinc-100 font-sans antialiased text-zinc-900 min-h-screen p-4 sm:p-8"> {{-- Body wrapper --}}
    <div class="no-print max-w-xl mx-auto mb-6 flex items-center justify-between gap-4"> {{-- Interactive top toolbar --}}
        <a href="{{ route('reparaciones.kanban') }}" class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 flex items-center gap-1.5 transition"> {{-- Return anchor --}}
            ← Volver al Tablero Kanban {{-- Back to kanban text --}}
        </a> {{-- Close return anchor --}}
        <button onclick="window.print()" class="px-5 py-2.5 bg-[#FF2D20] hover:bg-[#e02619] text-white text-sm font-bold rounded-lg shadow-sm shadow-red-500/20 flex items-center gap-2 transition"> {{-- Print action trigger --}}
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg> {{-- Print icon svg --}}
            Imprimir Ticket & Etiqueta {{-- Print button text --}}
        </button> {{-- Close print button --}}
    </div> {{-- Close interactive toolbar --}}

    <div class="print-container max-w-xl mx-auto bg-white border-2 border-zinc-900 rounded-xl shadow-lg overflow-hidden divide-y-2 divide-dashed divide-zinc-400"> {{-- Combined ticket container --}}
        <div class="p-6 bg-white"> {{-- Workshop surfboard sticky label section --}}
            <div class="flex items-start justify-between border-b-2 border-zinc-900 pb-4 mb-4"> {{-- Ticket header flex row --}}
                <div> {{-- Brand identity col --}}
                    <span class="text-[10px] font-extrabold uppercase tracking-widest bg-zinc-900 text-white px-2 py-0.5 rounded">Etiqueta de Taller</span> {{-- Workshop sticker tag --}}
                    <h1 class="text-xl font-extrabold text-zinc-900 mt-1 uppercase">{{ $reparacion->users?->name ?? 'Taller Wipeout' }}</h1> {{-- Workshop business name --}}
                    <p class="text-xs text-zinc-500">Orden de Reparación de Tabla</p> {{-- Ticket subtitle --}}
                </div> {{-- Close brand identity col --}}
                <div class="text-right"> {{-- Top right tracking info --}}
                    <span class="text-xs font-semibold text-zinc-500">Código Orden:</span> {{-- Code label --}}
                    <div class="text-2xl font-mono font-extrabold text-[#FF2D20] tracking-tight">{{ $reparacion->tracking_code }}</div> {{-- Highlighted tracking token --}}
                    <span class="text-[11px] text-zinc-500">{{ $reparacion->Fecha_llegada }}</span> {{-- Arrival date --}}
                </div> {{-- Close right tracking info --}}
            </div> {{-- Close ticket header row --}}

            <div class="grid grid-cols-3 gap-4 items-center"> {{-- Details and QR grid --}}
                <div class="col-span-2 space-y-2 text-xs"> {{-- Left details 2-cols --}}
                    <div> {{-- Client field --}}
                        <span class="font-bold text-zinc-500 uppercase text-[10px]">Cliente:</span> {{-- Client label --}}
                        <div class="text-sm font-extrabold text-zinc-900">{{ $reparacion->clientes?->Nombre }} {{ $reparacion->clientes?->Apellido }}</div> {{-- Client full name --}}
                        <div class="text-xs font-mono text-zinc-600">{{ $reparacion->clientes?->Telefono }}</div> {{-- Client phone --}}
                    </div> {{-- Close client field --}}
                    <div class="pt-1 border-t border-zinc-200"> {{-- Board field --}}
                        <span class="font-bold text-zinc-500 uppercase text-[10px]">Tabla de Surf:</span> {{-- Board label --}}
                        <div class="text-sm font-bold text-zinc-900">{{ $reparacion->tablas?->Marca }} - {{ $reparacion->tablas?->Modelo }}</div> {{-- Brand and model --}}
                        <div class="text-zinc-600">Color: {{ $reparacion->tablas?->Color ?? '-' }}</div> {{-- Board color --}}
                    </div> {{-- Close board field --}}
                    <div class="pt-1 border-t border-zinc-200"> {{-- Damage repair field --}}
                        <span class="font-bold text-zinc-500 uppercase text-[10px]">Trabajo a realizar:</span> {{-- Damage label --}}
                        <div class="font-bold text-zinc-900 text-xs">{{ $reparacion->Reparacion }}</div> {{-- Damage description --}}
                        @if (!empty($reparacion->Observaciones)) {{-- Check observations exist --}}
                            <div class="text-zinc-500 text-[11px] italic mt-0.5">Nota: {{ $reparacion->Observaciones }}</div> {{-- Additional notes --}}
                        @endif {{-- Close observations check --}}
                    </div> {{-- Close damage field --}}
                </div> {{-- Close left details --}}

                <div class="col-span-1 flex flex-col items-center justify-center p-2 bg-zinc-50 rounded-lg border border-zinc-200 text-center"> {{-- Right QR box --}}
                    <img src="{{ $qr_url }}" alt="Código QR Taller" class="w-28 h-28 mix-blend-multiply" /> {{-- Workshop QR image --}}
                    <span class="text-[9px] font-mono font-bold text-zinc-500 mt-1">Escanear para Panel</span> {{-- QR prompt text --}}
                </div> {{-- Close right QR box --}}
            </div> {{-- Close details and QR grid --}}

            <div class="mt-4 pt-3 border-t border-zinc-200 flex justify-between items-center text-xs"> {{-- Bottom label row --}}
                <div>Estado inicial: <span class="font-bold">{{ $reparacion->Estado }}</span></div> {{-- Current status --}}
                <div class="font-mono text-sm font-extrabold">{{ $reparacion->Precio ? number_format($reparacion->Precio, 2) . ' €' : 'Presupuesto pte.' }}</div> {{-- Price tag --}}
            </div> {{-- Close bottom label row --}}
        </div> {{-- Close workshop label section --}}

        <div class="relative py-2 bg-zinc-100 flex items-center justify-center text-[10px] font-mono uppercase tracking-widest text-zinc-500 font-bold select-none"> {{-- Cut separator rail --}}
            <span>✂ - - - - - - - CORTAR AQUÍ (ENTREGAR AL CLIENTE) - - - - - - - ✂</span> {{-- Visual scissors cut instructions --}}
        </div> {{-- Close cut separator rail --}}

        <div class="p-6 bg-white"> {{-- Customer claim ticket section --}}
            <div class="flex items-start justify-between border-b-2 border-zinc-900 pb-3 mb-4"> {{-- Customer header --}}
                <div> {{-- Brand title --}}
                    <span class="text-[10px] font-extrabold uppercase tracking-widest bg-[#FF2D20] text-white px-2 py-0.5 rounded">Resguardo para el Surfista</span> {{-- Customer badge --}}
                    <h2 class="text-lg font-extrabold text-zinc-900 mt-1">{{ $reparacion->users?->name ?? 'Taller Wipeout' }}</h2> {{-- Workshop name --}}
                    <p class="text-xs text-zinc-500">Resguardo de Recepción & Seguimiento Online</p> {{-- Claim text --}}
                </div> {{-- Close brand title --}}
                <div class="text-right"> {{-- Tracking code badge --}}
                    <span class="text-[10px] uppercase font-bold text-zinc-400">Tu Código de Seguimiento:</span> {{-- Subtitle --}}
                    <div class="text-xl font-mono font-extrabold text-zinc-900">{{ $reparacion->tracking_code }}</div> {{-- Tracking code --}}
                </div> {{-- Close tracking code badge --}}
            </div> {{-- Close customer header --}}

            <div class="flex items-center gap-5"> {{-- Flex row for customer instructions and QR --}}
                <div class="flex-1 space-y-2 text-xs"> {{-- Customer copy col --}}
                    <p class="font-semibold text-zinc-800"> {{-- Instructions lead --}}
                        Sigue en tiempo real la reparación de tu tabla desde tu smartphone: {{-- Instruction copy --}}
                    </p> {{-- Close instructions lead --}}
                    <ol class="list-decimal list-inside space-y-1 text-zinc-600 text-xs"> {{-- Steps list --}}
                        <li>Apunta con la cámara de tu móvil al código QR.</li> {{-- Step 1 --}}
                        <li>Accede al portal sin contraseñas ni registros.</li> {{-- Step 2 --}}
                        <li>Comprueba las fotos y si tu tabla está lista para surfear.</li> {{-- Step 3 --}}
                    </ol> {{-- Close steps list --}}
                    <div class="mt-3 p-2.5 bg-zinc-50 rounded border border-zinc-200 text-[11px] text-zinc-600"> {{-- Board reminder card --}}
                        <strong>Tabla recibida:</strong> {{ $reparacion->tablas?->Marca }} {{ $reparacion->tablas?->Modelo }} ({{ $reparacion->Fecha_llegada }}) {{-- Board reminder details --}}
                    </div> {{-- Close reminder card --}}
                </div> {{-- Close customer copy col --}}

                <div class="w-32 flex flex-col items-center text-center shrink-0"> {{-- Customer QR box --}}
                    <img src="{{ $qr_url }}" alt="QR de seguimiento" class="w-28 h-28 border border-zinc-300 rounded p-1" /> {{-- QR image --}}
                    <span class="text-[9px] font-bold text-zinc-500 mt-1">Escanear para Estado</span> {{-- QR label --}}
                </div> {{-- Close customer QR box --}}
            </div> {{-- Close flex row --}}

            <div class="mt-4 pt-3 border-t border-zinc-200 text-center text-[10px] text-zinc-400"> {{-- Customer footer --}}
                Presenta este resguardo o muestra el código al recoger tu tabla en el taller. {{-- Pickup note --}}
            </div> {{-- Close customer footer --}}
        </div> {{-- Close customer section --}}
    </div> {{-- Close combined ticket container --}}
</body> {{-- Close body tag --}}
</html> {{-- Close html tag --}}
