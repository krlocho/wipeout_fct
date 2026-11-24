<!DOCTYPE html> {{-- HTML5 standard doctype --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth"> {{-- Language and smooth scrolling root --}}
<head> {{-- Head metadata --}}
    <meta charset="utf-8"> {{-- Character encoding --}}
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Viewport settings for mobile responsiveness --}}
    <title>Wipeout — Sistema de Gestión para Talleres de Surf y Shapers</title> {{-- Authentic page title --}}
    <meta name="description" content="Gestión operativa de toques y tablas de surf. Recepción rápida, orden física con código QR y seguimiento online para clientes."> {{-- Meta description --}}
    <link rel="preconnect" href="https://fonts.bunny.net"> {{-- Preconnect fonts --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&family=space-mono:700&display=swap" rel="stylesheet" /> {{-- Fonts bundle --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Vite asset pipeline loader --}}
</head> {{-- Close head --}}
<body class="bg-[#F8F7F4] text-zinc-900 font-sans antialiased selection:bg-zinc-900 selection:text-white"> {{-- Warm canvas editorial background --}}
    <header class="border-b border-stone-200 bg-[#F8F7F4]/90 backdrop-blur-sm sticky top-0 z-50"> {{-- Sticky minimal header --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-18 flex items-center justify-between"> {{-- Header flex container --}}
            <a href="{{ route('welcome') }}" class="flex items-center gap-3 group"> {{-- Brand logo link --}}
                <div class="w-9 h-9 bg-zinc-900 text-white rounded flex items-center justify-center font-mono font-bold text-base tracking-tighter group-hover:bg-[#D9381E] transition">W</div> {{-- Brutalist square brand mark --}}
                <div class="flex flex-col"> {{-- Title column --}}
                    <span class="text-base font-extrabold tracking-tight text-zinc-900 uppercase">WIPEOUT</span> {{-- Brand wordmark --}}
                    <span class="text-[10px] uppercase font-mono tracking-wider text-zinc-500">Ding Repair System</span> {{-- Technical descriptor --}}
                </div> {{-- Close title column --}}
            </a> {{-- Close brand link --}}
            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold uppercase tracking-wider text-zinc-600"> {{-- Navigation list --}}
                <a href="#rastreo" class="hover:text-zinc-900 transition">Rastrear Tabla</a> {{-- Tracking anchor --}}
                <a href="#flujo" class="hover:text-zinc-900 transition">El Sistema</a> {{-- Workflow anchor --}}
                <a href="#precios" class="hover:text-zinc-900 transition">Planes</a> {{-- Pricing anchor --}}
                <a href="#talleres" class="hover:text-zinc-900 transition">Red de Talleres</a> {{-- Workshops anchor --}}
            </nav> {{-- Close navigation list --}}
            <div class="flex items-center gap-3"> {{-- Header actions --}}
                @auth {{-- Authenticated session --}}
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-xs font-bold uppercase tracking-wider bg-zinc-900 text-white rounded hover:bg-zinc-800 transition">Mi Taller</a> {{-- Dashboard button --}}
                @else {{-- Guest session --}}
                    <a href="{{ route('login') }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-zinc-700 hover:text-zinc-900 transition">Acceso</a> {{-- Login link --}}
                    @if (Route::has('register')) {{-- Register route check --}}
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold uppercase tracking-wider bg-zinc-900 text-white rounded hover:bg-[#D9381E] transition">Registrar Taller</a> {{-- Register button --}}
                    @endif {{-- Close register check --}}
                @endauth {{-- Close auth check --}}
            </div> {{-- Close header actions --}}
        </div> {{-- Close header container --}}
    </header> {{-- Close header --}}

    <section class="pt-12 pb-16 sm:pt-20 sm:pb-24 border-b border-stone-200"> {{-- Hero section --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6"> {{-- Container --}}
            <div class="max-w-3xl"> {{-- Copy column --}}
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-stone-200 text-zinc-800 text-[11px] font-mono uppercase tracking-wider mb-6 font-bold"> {{-- Technical pill --}}
                    <span>//</span> TALLERES DE REPARACIÓN Y SHAPERS {{-- Category label --}}
                </div> {{-- Close pill --}}
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-zinc-950 leading-[1.08]"> {{-- Editorial headline --}}
                    El taller bajo control. <br />De la resina al agua. {{-- Main title lines --}}
                </h1> {{-- Close headline --}}
                <p class="mt-6 text-lg sm:text-xl text-zinc-600 leading-relaxed font-normal"> {{-- Subtitle --}}
                    Recepción de toques en 30 segundos, etiqueta con código para la tabla y seguimiento online para que tus clientes sepan exactamente cuándo recogerla, sin llamadas ni mensajes continuos por WhatsApp. {{-- Subhead copy --}}
                </p> {{-- Close subtitle --}}
            </div> {{-- Close copy column --}}

            <div class="mt-10 max-w-2xl bg-white border border-stone-300 rounded-xl p-5 shadow-sm"> {{-- Search & start action card --}}
                <span class="text-[11px] uppercase tracking-wider font-mono font-bold text-zinc-500 block mb-2">Comprobar estado de una tabla</span> {{-- Input label --}}
                <form method="GET" action="{{ route('reparaciones.track') }}" class="flex flex-col sm:flex-row gap-2"> {{-- Tracking form --}}
                    <input type="text" name="code" placeholder="Código de orden (ej. WP-DEMO01)" required class="flex-1 uppercase font-mono text-sm tracking-wider px-3.5 py-2.5 rounded-lg border border-stone-300 focus:border-zinc-900 focus:ring-1 focus:ring-zinc-900 bg-stone-50" /> {{-- Input --}}
                    <button type="submit" class="px-5 py-2.5 bg-zinc-900 hover:bg-[#D9381E] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition shrink-0">Rastrear</button> {{-- Submit button --}}
                </form> {{-- Close form --}}
                <div class="mt-3 flex items-center justify-between text-xs text-zinc-500 pt-3 border-t border-stone-100"> {{-- Sub info row --}}
                    <span>¿Eres shaper o tienes taller? <a href="{{ route('register') }}" class="font-bold text-zinc-900 underline hover:text-[#D9381E]">Crear cuenta gratuita</a></span> {{-- Workshop register link --}}
                    <a href="{{ route('reparaciones.track', ['code' => 'WP-DEMO01']) }}" class="hidden sm:inline font-mono text-zinc-600 hover:text-zinc-900">Ver orden ejemplo →</a> {{-- Demo link --}}
                </div> {{-- Close sub info row --}}
            </div> {{-- Close action card --}}

            <div class="mt-16 grid lg:grid-cols-12 gap-8 items-start"> {{-- Workbench preview grid --}}
                <div class="lg:col-span-7 bg-white border-2 border-zinc-900 rounded-xl p-6 shadow-[6px_6px_0px_0px_rgba(24,24,27,1)]"> {{-- Realistic workshop ticket card --}}
                    <div class="flex items-start justify-between border-b-2 border-zinc-900 pb-4 mb-4"> {{-- Card top --}}
                        <div> {{-- Left col --}}
                            <span class="text-[10px] font-mono font-bold uppercase px-1.5 py-0.5 bg-zinc-900 text-white rounded">ORDEN DE TALLER</span> {{-- Badge --}}
                            <h3 class="text-lg font-extrabold uppercase mt-1">Zarautz Surfboards Bay</h3> {{-- Workshop name --}}
                            <p class="text-xs text-zinc-500 font-mono">22 Noviembre · Taller Principal</p> {{-- Meta --}}
                        </div> {{-- Close left col --}}
                        <div class="text-right"> {{-- Code col --}}
                            <span class="text-[10px] uppercase font-mono text-zinc-400">Código Orden:</span> {{-- Label --}}
                            <div class="font-mono text-2xl font-black text-[#D9381E]">WP-DEMO01</div> {{-- Code --}}
                        </div> {{-- Close code col --}}
                    </div> {{-- Close card top --}}
                    <div class="grid sm:grid-cols-3 gap-4 text-xs py-2"> {{-- Details row --}}
                        <div> {{-- Client details --}}
                            <span class="text-zinc-400 uppercase font-mono text-[10px] block">Rider:</span> {{-- Rider label --}}
                            <strong class="text-sm">Aitor Mendizabal</strong> {{-- Client name --}}
                            <div class="text-zinc-500 font-mono text-[11px]">+34 611 223 344</div> {{-- Phone --}}
                        </div> {{-- Close client details --}}
                        <div> {{-- Board details --}}
                            <span class="text-zinc-400 uppercase font-mono text-[10px] block">Tabla:</span> {{-- Board label --}}
                            <strong class="text-sm">Lost Surfboards</strong> {{-- Brand --}}
                            <div class="text-zinc-600">Driver 3.0 · Resina Epoxy</div> {{-- Model --}}
                        </div> {{-- Close board details --}}
                        <div class="bg-stone-50 p-2 rounded border border-stone-200"> {{-- State details --}}
                            <span class="text-zinc-400 uppercase font-mono text-[10px] block">Estado:</span> {{-- State label --}}
                            <span class="font-bold text-amber-700 font-mono">EN CURADO FIBRA</span> {{-- Current status --}}
                            <div class="text-zinc-500 text-[11px] mt-0.5">Precio: 45,00 €</div> {{-- Price --}}
                        </div> {{-- Close state details --}}
                    </div> {{-- Close details row --}}
                    <div class="mt-4 pt-3 border-t border-stone-200 flex items-center justify-between text-xs text-zinc-500 font-mono"> {{-- Ticket footer --}}
                        <span>Fisura en canto derecho con delaminación</span> {{-- Damage scope --}}
                        <span class="text-zinc-400">[ Escanear QR para seguimiento ]</span> {{-- QR note --}}
                    </div> {{-- Close ticket footer --}}
                </div> {{-- Close workshop ticket card --}}

                <div class="lg:col-span-5 space-y-4"> {{-- Right highlights column --}}
                    <div class="bg-white border border-stone-200 rounded-xl p-5"> {{-- Highlight 1 --}}
                        <div class="text-xs font-mono font-bold uppercase text-zinc-400 mb-1">01 / RECEPCIÓN A PIE DE POTRO</div> {{-- Step number --}}
                        <h4 class="font-bold text-base text-zinc-900 mb-1">Diagnóstico con foto en 30 segundos</h4> {{-- Heading --}}
                        <p class="text-xs text-zinc-600 leading-relaxed">Saca la foto con el teléfono directamente en el taller antes de empezar a lijar. Se guarda con las medidas y los datos del rider.</p> {{-- Body --}}
                    </div> {{-- Close highlight 1 --}}

                    <div class="bg-white border border-stone-200 rounded-xl p-5"> {{-- Highlight 2 --}}
                        <div class="text-xs font-mono font-bold uppercase text-zinc-400 mb-1">02 / ETIQUETA FÍSICA & CÓDIGO QR</div> {{-- Step number --}}
                        <h4 class="font-bold text-base text-zinc-900 mb-1">Cada tabla identificada. Resguardo al cliente</h4> {{-- Heading --}}
                        <p class="text-xs text-zinc-600 leading-relaxed">Imprime la orden en papel o etiqueta térmica. Entrega el resguardo con QR para que el cliente consulte cuándo está seca y terminada.</p> {{-- Body --}}
                    </div> {{-- Close highlight 2 --}}

                    <div class="bg-white border border-stone-200 rounded-xl p-5"> {{-- Highlight 3 --}}
                        <div class="text-xs font-mono font-bold uppercase text-zinc-400 mb-1">03 / AVISO DIRECTO POR WHATSAPP</div> {{-- Step number --}}
                        <h4 class="font-bold text-base text-zinc-900 mb-1">Avisa al terminar con un solo clic</h4> {{-- Heading --}}
                        <p class="text-xs text-zinc-600 leading-relaxed">Al pasar la tabla a terminada en el tablero, un botón de WhatsApp abre la conversación con el mensaje de recogida y enlace ya preparado.</p> {{-- Body --}}
                    </div> {{-- Close highlight 3 --}}
                </div> {{-- Close right column --}}
            </div> {{-- Close workbench grid --}}
        </div> {{-- Close container --}}
    </section> {{-- Close hero section --}}

    <section id="flujo" class="py-16 sm:py-24 border-b border-stone-200 bg-white"> {{-- Workflow section --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6"> {{-- Container --}}
            <div class="max-w-2xl mb-12"> {{-- Section lead --}}
                <span class="text-xs font-mono uppercase font-bold text-zinc-400 tracking-wider">Metodología de Taller</span> {{-- Section badge --}}
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-zinc-900 mt-2">Diseñado para la realidad del polvo, la fibra y la resina.</h2> {{-- Title --}}
                <p class="text-sm text-zinc-600 mt-3">Sin menús complejos ni configuración interminable. Abre desde el móvil en el potro o desde el ordenador del mostrador.</p> {{-- Subhead --}}
            </div> {{-- Close section lead --}}

            <div class="grid md:grid-cols-3 gap-6"> {{-- Cards grid --}}
                <div class="border border-stone-200 rounded-xl p-6 bg-[#F8F7F4]"> {{-- Card 1 --}}
                    <div class="w-8 h-8 rounded bg-zinc-900 text-white flex items-center justify-center font-mono font-bold text-xs mb-4">1</div> {{-- Number box --}}
                    <h3 class="font-bold text-base text-zinc-900 mb-2">Alta Rápida (Quick Intake)</h3> {{-- Card title --}}
                    <p class="text-xs text-zinc-600 leading-relaxed">Registra al surfista, la tabla y el toque en un único formulario fluido. Si el cliente ya existe, se vincula automáticamente a su quiver.</p> {{-- Card body --}}
                </div> {{-- Close card 1 --}}

                <div class="border border-stone-200 rounded-xl p-6 bg-[#F8F7F4]"> {{-- Card 2 --}}
                    <div class="w-8 h-8 rounded bg-zinc-900 text-white flex items-center justify-center font-mono font-bold text-xs mb-4">2</div> {{-- Number box --}}
                    <h3 class="font-bold text-base text-zinc-900 mb-2">Tablero Kanban de Curado</h3> {{-- Card title --}}
                    <p class="text-xs text-zinc-600 leading-relaxed">Visualiza las columnas de trabajo: Sin Empezar, En Proceso (fibra/resina) y Listas para Recoger. Mueve estados en un clic.</p> {{-- Card body --}}
                </div> {{-- Close card 2 --}}

                <div class="border border-stone-200 rounded-xl p-6 bg-[#F8F7F4]"> {{-- Card 3 --}}
                    <div class="w-8 h-8 rounded bg-zinc-900 text-white flex items-center justify-center font-mono font-bold text-xs mb-4">3</div> {{-- Number box --}}
                    <h3 class="font-bold text-base text-zinc-900 mb-2">Portal Público sin Contraseñas</h3> {{-- Card title --}}
                    <p class="text-xs text-zinc-600 leading-relaxed">Tus clientes acceden mediante su código de orden para ver las fotos y el avance. Cero fricción, cero llamadas para preguntar si ya está lista.</p> {{-- Card body --}}
                </div> {{-- Close card 3 --}}
            </div> {{-- Close cards grid --}}
        </div> {{-- Close container --}}
    </section> {{-- Close workflow section --}}

    <section id="precios" class="py-16 sm:py-24 border-b border-stone-200"> {{-- Pricing section --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6"> {{-- Container --}}
            <div class="max-w-2xl mb-12"> {{-- Lead --}}
                <span class="text-xs font-mono uppercase font-bold text-zinc-400 tracking-wider">Precios Claros</span> {{-- Badge --}}
                <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-zinc-900 mt-2">Empieza gratis. Escala si tu taller lo necesita.</h2> {{-- Title --}}
                <p class="text-sm text-zinc-600 mt-3">Sin letra pequeña. Todos los planes incluyen etiquetas con código QR y portal de seguimiento.</p> {{-- Subhead --}}
            </div> {{-- Close lead --}}

            <div class="grid md:grid-cols-3 gap-6 items-stretch"> {{-- Plans grid --}}
                <div class="bg-white border border-stone-300 rounded-xl p-6 flex flex-col justify-between"> {{-- Free plan --}}
                    <div> {{-- Content --}}
                        <span class="text-[10px] font-mono uppercase font-bold text-zinc-500">Plan Básico</span> {{-- Category --}}
                        <h3 class="text-xl font-extrabold text-zinc-900 mt-1">Shaper Local</h3> {{-- Title --}}
                        <div class="mt-4 flex items-baseline gap-1"> {{-- Price --}}
                            <span class="text-3xl font-black text-zinc-900 font-mono">0€</span> {{-- Figure --}}
                            <span class="text-xs text-zinc-500">/ mes para siempre</span> {{-- Frequency --}}
                        </div> {{-- Close price --}}
                        <p class="text-xs text-zinc-600 mt-3">Para artesanos independientes o talleres ocasionales que quieren probar el sistema.</p> {{-- Description --}}
                        <ul class="mt-6 space-y-2 text-xs text-zinc-700 border-t border-stone-100 pt-4"> {{-- Features list --}}
                            <li class="flex items-center gap-2">✓ Hasta 5 tablas al mes</li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2">✓ Código QR y portal de cliente</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2">✓ Tablero Kanban de producción</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2">✓ Impresión de tickets de taller</li> {{-- Item 4 --}}
                        </ul> {{-- Close features --}}
                    </div> {{-- Close content --}}
                    <div class="mt-8"> {{-- Button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-2.5 text-center text-xs font-bold uppercase tracking-wider bg-zinc-100 hover:bg-zinc-200 text-zinc-900 rounded transition">Comenzar Gratis</a> {{-- Free button --}}
                    </div> {{-- Close button container --}}
                </div> {{-- Close free plan --}}

                <div class="bg-white border-2 border-zinc-900 rounded-xl p-6 flex flex-col justify-between shadow-[4px_4px_0px_0px_rgba(24,24,27,1)] relative"> {{-- Pro plan --}}
                    <div class="absolute -top-3 left-6 bg-[#D9381E] text-white text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded tracking-wider">Recomendado Taller</div> {{-- Pro badge --}}
                    <div> {{-- Content --}}
                        <span class="text-[10px] font-mono uppercase font-bold text-zinc-500">Volumen Taller</span> {{-- Category --}}
                        <h3 class="text-xl font-extrabold text-zinc-900 mt-1">Taller Pro</h3> {{-- Title --}}
                        <div class="mt-4 flex items-baseline gap-1"> {{-- Price --}}
                            <span class="text-3xl font-black text-zinc-900 font-mono">29€</span> {{-- Figure --}}
                            <span class="text-xs text-zinc-500">/ mes sin permanencia</span> {{-- Frequency --}}
                        </div> {{-- Close price --}}
                        <p class="text-xs text-zinc-600 mt-3">Para talleres profesionales en activo con entrada continua de tablas.</p> {{-- Description --}}
                        <ul class="mt-6 space-y-2 text-xs text-zinc-900 border-t border-stone-100 pt-4 font-medium"> {{-- Features list --}}
                            <li class="flex items-center gap-2">✓ <strong>Tablas y reparaciones ilimitadas</strong></li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2">✓ Fotos de toques en alta resolución</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2">✓ Avisos por WhatsApp con 1 clic</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2">✓ Notificaciones por correo electrónico</li> {{-- Item 4 --}}
                            <li class="flex items-center gap-2">✓ Soporte directo para el taller</li> {{-- Item 5 --}}
                        </ul> {{-- Close features --}}
                    </div> {{-- Close content --}}
                    <div class="mt-8"> {{-- Button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-2.5 text-center text-xs font-bold uppercase tracking-wider bg-zinc-900 hover:bg-[#D9381E] text-white rounded transition">Empezar con Taller Pro</a> {{-- Pro button --}}
                    </div> {{-- Close button container --}}
                </div> {{-- Close pro plan --}}

                <div class="bg-white border border-stone-300 rounded-xl p-6 flex flex-col justify-between"> {{-- Factory plan --}}
                    <div> {{-- Content --}}
                        <span class="text-[10px] font-mono uppercase font-bold text-zinc-500">Multi-Operario</span> {{-- Category --}}
                        <h3 class="text-xl font-extrabold text-zinc-900 mt-1">Escuela & Factory</h3> {{-- Title --}}
                        <div class="mt-4 flex items-baseline gap-1"> {{-- Price --}}
                            <span class="text-3xl font-black text-zinc-900 font-mono">59€</span> {{-- Figure --}}
                            <span class="text-xs text-zinc-500">/ mes</span> {{-- Frequency --}}
                        </div> {{-- Close price --}}
                        <p class="text-xs text-zinc-600 mt-3">Para escuelas de surf, surf camps y fábricas de tablas con varios operarios.</p> {{-- Description --}}
                        <ul class="mt-6 space-y-2 text-xs text-zinc-700 border-t border-stone-100 pt-4"> {{-- Features list --}}
                            <li class="flex items-center gap-2">✓ Todo lo incluido en Taller Pro</li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2">✓ Cuentas para múltiples operarios</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2">✓ Control de flota de tablas de escuela</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2">✓ Métricas y exportación mensual</li> {{-- Item 4 --}}
                        </ul> {{-- Close features --}}
                    </div> {{-- Close content --}}
                    <div class="mt-8"> {{-- Button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-2.5 text-center text-xs font-bold uppercase tracking-wider bg-zinc-100 hover:bg-zinc-200 text-zinc-900 rounded transition">Contactar para Factory</a> {{-- Factory button --}}
                    </div> {{-- Close button container --}}
                </div> {{-- Close factory plan --}}
            </div> {{-- Close plans grid --}}
        </div> {{-- Close container --}}
    </section> {{-- Close pricing section --}}

    <section id="talleres" class="py-16 sm:py-24 border-b border-stone-200 bg-white"> {{-- Workshop map section --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6"> {{-- Container --}}
            <div class="max-w-2xl mb-8"> {{-- Heading --}}
                <span class="text-xs font-mono uppercase font-bold text-zinc-400 tracking-wider">Directorio de Talleres</span> {{-- Badge --}}
                <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 mt-1">Talleres y shapers asociados</h2> {{-- Title --}}
                <p class="text-xs text-zinc-600 mt-1">Localiza talleres de confianza con sistema Wipeout en tu zona.</p> {{-- Subhead --}}
            </div> {{-- Close heading --}}
            <div class="rounded-xl overflow-hidden border border-stone-300"> {{-- Map container --}}
                <x-map-card :users="$users" /> {{-- Render map component --}}
            </div> {{-- Close map container --}}
        </div> {{-- Close container --}}
    </section> {{-- Close map section --}}

    <footer class="py-10 bg-[#F8F7F4] text-xs text-zinc-500 font-mono"> {{-- Footer --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4"> {{-- Footer container --}}
            <div class="flex items-center gap-2"> {{-- Brand block --}}
                <span class="font-bold text-zinc-900">WIPEOUT</span> {{-- Brand --}}
                <span>//</span> {{-- Slash --}}
                <span>Ding Repair Management System © {{ date('Y') }}</span> {{-- Copyright --}}
            </div> {{-- Close brand block --}}
            <div class="flex items-center gap-6 text-[11px] uppercase"> {{-- Links list --}}
                <a href="#flujo" class="hover:text-zinc-900 transition">El Sistema</a> {{-- Link 1 --}}
                <a href="#precios" class="hover:text-zinc-900 transition">Planes</a> {{-- Link 2 --}}
                <a href="{{ route('login') }}" class="hover:text-zinc-900 transition">Acceso Taller</a> {{-- Link 3 --}}
            </div> {{-- Close links list --}}
        </div> {{-- Close footer container --}}
    </footer> {{-- Close footer --}}
</body> {{-- Close body --}}
</html> {{-- Close html --}}
