<!DOCTYPE html> {{-- HTML5 standard doctype --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth"> {{-- Language and smooth scrolling root --}}
<head> {{-- Head metadata --}}
    <meta charset="utf-8"> {{-- Character encoding --}}
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Viewport settings for mobile responsiveness --}}
    <title>Wipeout | Software de Gestión para Talleres de Surf y Shapers</title> {{-- SEO optimized title --}}
    <meta name="description" content="El software SaaS líder para talleres de reparación de tablas de surf. Recepción rápida de toques, seguimiento con código QR en vivo y tablero Kanban de producción."> {{-- SEO meta description --}}
    <link rel="preconnect" href="https://fonts.bunny.net"> {{-- Preconnect Bunny fonts --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" /> {{-- Figtree typography --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Vite asset bundle loader --}}
</head> {{-- Close head --}}
<body class="font-sans antialiased bg-zinc-950 text-zinc-100 selection:bg-[#FF2D20] selection:text-white"> {{-- Main body with dark theme styling --}}
    <header class="sticky top-0 z-50 bg-zinc-950/80 backdrop-blur-md border-b border-zinc-800/80"> {{-- Sticky navigation bar --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between"> {{-- Nav wrapper container --}}
            <div class="flex items-center gap-3"> {{-- Brand logo container --}}
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group"> {{-- Home anchor link --}}
                    <x-application-logo class="w-10 h-10 fill-current text-[#FF2D20] transition transform group-hover:scale-105" /> {{-- App branding svg --}}
                    <div class="flex flex-col"> {{-- Title wrapper --}}
                        <span class="text-xl font-extrabold tracking-tight text-white flex items-center gap-2"> {{-- Brand wordmark --}}
                            WIPEOUT {{-- Wordmark name --}}
                            <span class="text-[10px] uppercase font-bold tracking-widest bg-red-500/10 text-[#FF2D20] border border-red-500/20 px-2 py-0.5 rounded-full">Pro</span> {{-- Pro badge --}}
                        </span> {{-- Close brand wordmark --}}
                        <span class="text-[11px] text-zinc-400 hidden sm:inline">Software para Talleres de Surf</span> {{-- Subtitle tagline --}}
                    </div> {{-- Close title wrapper --}}
                </a> {{-- Close brand link --}}
            </div> {{-- Close brand logo container --}}
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-300"> {{-- Desktop navigation items --}}
                <a href="#caracteristicas" class="hover:text-white transition">Características</a> {{-- Feature section anchor --}}
                <a href="#rastreo" class="hover:text-white transition">Rastrear Tabla</a> {{-- Tracking anchor --}}
                <a href="#precios" class="hover:text-white transition">Precios</a> {{-- Pricing anchor --}}
                <a href="#talleres" class="hover:text-white transition">Red de Talleres</a> {{-- Workshops map anchor --}}
                <a href="#faq" class="hover:text-white transition">FAQ</a> {{-- FAQ anchor --}}
            </nav> {{-- Close desktop navigation --}}
            <div class="flex items-center gap-3"> {{-- Auth action buttons --}}
                @auth {{-- Authenticated session check --}}
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-zinc-800 hover:bg-zinc-700 rounded-lg border border-zinc-700 transition">Panel de Control</a> {{-- Dashboard button --}}
                @else {{-- Guest session check --}}
                    <a href="{{ route('login') }}" class="px-3.5 py-2 text-sm font-medium text-zinc-300 hover:text-white transition">Acceso Taller</a> {{-- Login button --}}
                    @if (Route::has('register')) {{-- Registration route check --}}
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-[#FF2D20] hover:bg-[#e02619] rounded-lg shadow-sm shadow-red-500/30 transition transform hover:-translate-y-0.5">Prueba Gratis</a> {{-- Register CTA button --}}
                    @endif {{-- Close registration check --}}
                @endauth {{-- Close auth check --}}
            </div> {{-- Close auth actions --}}
        </div> {{-- Close nav wrapper --}}
    </header> {{-- Close header --}}

    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 border-b border-zinc-800/60 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(255,45,32,0.15),rgba(255,255,255,0))]"> {{-- Hero section wrapper --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Container grid --}}
            <div class="text-center max-w-3xl mx-auto"> {{-- Hero content block --}}
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-950/60 text-red-400 border border-red-800/40 mb-6"> {{-- Pill badge --}}
                    <span class="w-2 h-2 rounded-full bg-[#FF2D20] animate-pulse"></span> {{-- Pulse indicator --}}
                    Software de gestión operativa nº 1 para talleres y shapers {{-- Badge text --}}
                </div> {{-- Close pill badge --}}
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white leading-tight"> {{-- Main headline --}}
                    El software que ahorra <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-amber-400">10h/semana</span> a tu taller de surf {{-- Headline highlight --}}
                </h1> {{-- Close main headline --}}
                <p class="mt-6 text-lg sm:text-xl text-zinc-400 leading-relaxed"> {{-- Hero subheadline --}}
                    Recepción de toques en 30 segundos, fotos de daños desde el móvil, seguimiento transparente con código QR para surfistas y control visual con tablero Kanban. {{-- Subheadline text --}}
                </p> {{-- Close subheadline --}}
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4"> {{-- Hero CTA group --}}
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-[#FF2D20] hover:bg-[#e02619] rounded-xl shadow-lg shadow-red-500/25 transition transform hover:-translate-y-0.5 text-center"> {{-- Primary CTA button --}}
                        Registrar mi Taller Gratis {{-- Primary CTA text --}}
                    </a> {{-- Close primary CTA --}}
                    <a href="#rastreo" class="w-full sm:w-auto px-8 py-4 text-base font-semibold text-zinc-300 bg-zinc-900 hover:bg-zinc-800 rounded-xl border border-zinc-800 transition text-center"> {{-- Secondary CTA button --}}
                        Rastrear una Tabla en Reparación {{-- Secondary CTA text --}}
                    </a> {{-- Close secondary CTA --}}
                </div> {{-- Close CTA group --}}
                <div class="mt-8 flex items-center justify-center gap-6 text-xs text-zinc-500"> {{-- Value props row --}}
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Sin tarjeta de crédito</span> {{-- Prop 1 --}}
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Configuración en 2 minutos</span> {{-- Prop 2 --}}
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 5 tablas gratis al mes</span> {{-- Prop 3 --}}
                </div> {{-- Close value props row --}}
            </div> {{-- Close content block --}}

            <div class="mt-14 max-w-4xl mx-auto rounded-2xl bg-zinc-900/90 p-4 border border-zinc-800 shadow-2xl"> {{-- Metrics teaser container --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center divide-y md:divide-y-0 md:divide-x divide-zinc-800"> {{-- Metrics grid --}}
                    <div class="p-4"> {{-- Stat 1 --}}
                        <div class="text-3xl font-extrabold text-white">30 seg</div> {{-- Stat number --}}
                        <div class="text-xs text-zinc-400 mt-1">Recepción completa con foto</div> {{-- Stat label --}}
                    </div> {{-- Close stat 1 --}}
                    <div class="p-4"> {{-- Stat 2 --}}
                        <div class="text-3xl font-extrabold text-[#FF2D20]">0</div> {{-- Stat number --}}
                        <div class="text-xs text-zinc-400 mt-1">Llamadas de "¿está mi tabla?"</div> {{-- Stat label --}}
                    </div> {{-- Close stat 2 --}}
                    <div class="p-4"> {{-- Stat 3 --}}
                        <div class="text-3xl font-extrabold text-white">100%</div> {{-- Stat number --}}
                        <div class="text-xs text-zinc-400 mt-1">Visibilidad de producción</div> {{-- Stat label --}}
                    </div> {{-- Close stat 3 --}}
                    <div class="p-4"> {{-- Stat 4 --}}
                        <div class="text-3xl font-extrabold text-white">+1,200</div> {{-- Stat number --}}
                        <div class="text-xs text-zinc-400 mt-1">Tablas reparadas registradas</div> {{-- Stat label --}}
                    </div> {{-- Close stat 4 --}}
                </div> {{-- Close metrics grid --}}
            </div> {{-- Close teaser container --}}
        </div> {{-- Close container --}}
    </section> {{-- Close hero section --}}

    <section id="rastreo" class="py-16 bg-zinc-900/50 border-b border-zinc-800"> {{-- Live customer tracking section --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center"> {{-- Tracking wrapper --}}
            <span class="text-xs uppercase tracking-widest font-bold text-[#FF2D20]">Portal de Autoservicio para Surfistas</span> {{-- Subtitle --}}
            <h2 class="text-2xl sm:text-3xl font-bold text-white mt-2">¿Dejaste tu tabla en un taller Wipeout?</h2> {{-- Heading --}}
            <p class="text-sm text-zinc-400 mt-2 max-w-xl mx-auto">Consulta el estado de tu reparación en vivo introduciendo el código de seguimiento (ej. <span class="font-mono text-zinc-200">WP-ABC123</span>) o escanea el QR de tu resguardo.</p> {{-- Instructions --}}
            <div class="mt-8"> {{-- Search component mount point --}}
                <x-search-ding /> {{-- Render search ding component --}}
            </div> {{-- Close mount point --}}
        </div> {{-- Close tracking wrapper --}}
    </section> {{-- Close tracking section --}}

    <section id="caracteristicas" class="py-20 lg:py-28 border-b border-zinc-800"> {{-- Features section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Features container --}}
            <div class="text-center max-w-3xl mx-auto mb-16"> {{-- Section header --}}
                <span class="text-xs uppercase tracking-widest font-bold text-[#FF2D20]">Diseñado para el día a día en el taller</span> {{-- Section badge --}}
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Todo lo que necesitas para gestionar toques y tablas</h2> {{-- Section heading --}}
                <p class="text-base text-zinc-400 mt-4">Deja las libretas manchadas de resina y las notas de WhatsApp en el olvido. Centraliza tu taller en una sola app.</p> {{-- Section subhead --}}
            </div> {{-- Close header --}}

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8"> {{-- Features grid --}}
                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 1 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">📸</div> {{-- Icon 1 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Recepción Rápida en 1 Paso</h3> {{-- Title 1 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Da de alta al cliente, la tabla y el daño con foto directamente desde la cámara de tu móvil en menos de 30 segundos.</p> {{-- Description 1 --}}
                </div> {{-- Close card 1 --}}

                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 2 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">📱</div> {{-- Icon 2 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Seguimiento QR en Vivo</h3> {{-- Title 2 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Genera un código QR y enlace público para cada reparación. El surfista comprueba el avance en tiempo real sin tener que llamarte.</p> {{-- Description 2 --}}
                </div> {{-- Close card 2 --}}

                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 3 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">📋</div> {{-- Icon 3 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Tablero Kanban Visual</h3> {{-- Title 3 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Gestiona tu cola de trabajo por columnas: Sin Empezar, En Proceso y Terminado. Visualiza cuellos de botella al instante.</p> {{-- Description 3 --}}
                </div> {{-- Close card 3 --}}

                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 4 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">✉️</div> {{-- Icon 4 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Avisos Automáticos</h3> {{-- Title 4 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Notificaciones por email instantáneas al cliente cuando la orden es creada y cuando la tabla está lista para su recogida.</p> {{-- Description 4 --}}
                </div> {{-- Close card 4 --}}

                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 5 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">🏄‍♂️</div> {{-- Icon 5 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Quiver & Historial de Clientes</h3> {{-- Title 5 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Base de datos de todos tus clientes y sus tablas asociadas. Conoce las preferencias y toques recurrentes de cada rider.</p> {{-- Description 5 --}}
                </div> {{-- Close card 5 --}}

                <div class="p-8 rounded-2xl bg-zinc-900 border border-zinc-800 hover:border-zinc-700 transition"> {{-- Feature card 6 --}}
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 text-[#FF2D20] flex items-center justify-center font-bold text-xl mb-6">🔒</div> {{-- Icon 6 --}}
                    <h3 class="text-xl font-bold text-white mb-2">Multi-Inquilino & Seguro</h3> {{-- Title 6 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Políticas de seguridad blindadas. Cada taller gestiona exclusivamente sus clientes y reparaciones con total privacidad.</p> {{-- Description 6 --}}
                </div> {{-- Close card 6 --}}
            </div> {{-- Close features grid --}}
        </div> {{-- Close features container --}}
    </section> {{-- Close features section --}}

    <section id="precios" class="py-20 lg:py-28 border-b border-zinc-800 bg-zinc-900/30"> {{-- Pricing section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Pricing container --}}
            <div class="text-center max-w-3xl mx-auto mb-16"> {{-- Section header --}}
                <span class="text-xs uppercase tracking-widest font-bold text-[#FF2D20]">Precios Transparentes</span> {{-- Section badge --}}
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Planes adaptados al tamaño de tu taller</h2> {{-- Section heading --}}
                <p class="text-base text-zinc-400 mt-4">Comienza gratis sin compromiso y escala a medida que aumente tu volumen de tablas.</p> {{-- Section subhead --}}
            </div> {{-- Close header --}}

            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch"> {{-- Pricing cards grid --}}
                <div class="bg-zinc-900 rounded-2xl p-8 border border-zinc-800 flex flex-col justify-between"> {{-- Free tier card --}}
                    <div> {{-- Content block --}}
                        <h3 class="text-lg font-bold text-white">Shaper Local</h3> {{-- Tier name --}}
                        <p class="text-xs text-zinc-400 mt-1">Para artesanos independientes y talleres que empiezan.</p> {{-- Tier description --}}
                        <div class="mt-6 flex items-baseline gap-1"> {{-- Price display --}}
                            <span class="text-4xl font-extrabold text-white">0€</span> {{-- Price number --}}
                            <span class="text-sm text-zinc-400">/mes para siempre</span> {{-- Price period --}}
                        </div> {{-- Close price display --}}
                        <ul class="mt-8 space-y-3 text-sm text-zinc-300"> {{-- Feature list --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Hasta 5 tablas activas al mes</li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Código QR y enlace de seguimiento</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tablero Kanban básico</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Directorio de clientes y tablas</li> {{-- Item 4 --}}
                        </ul> {{-- Close feature list --}}
                    </div> {{-- Close content block --}}
                    <div class="mt-8"> {{-- Action button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-3 px-4 text-center text-sm font-semibold text-white bg-zinc-800 hover:bg-zinc-700 rounded-xl transition border border-zinc-700">Comenzar Gratis</a> {{-- Free tier button --}}
                    </div> {{-- Close action button --}}
                </div> {{-- Close free tier card --}}

                <div class="bg-zinc-900 rounded-2xl p-8 border-2 border-[#FF2D20] shadow-2xl shadow-red-500/10 flex flex-col justify-between relative"> {{-- Pro tier card --}}
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#FF2D20] text-white text-[11px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider shadow-sm">Más Popular</div> {{-- Most popular badge --}}
                    <div> {{-- Content block --}}
                        <h3 class="text-lg font-bold text-white">Taller Pro</h3> {{-- Tier name --}}
                        <p class="text-xs text-zinc-400 mt-1">Para talleres de surf en activo con flujo continuo de toques.</p> {{-- Tier description --}}
                        <div class="mt-6 flex items-baseline gap-1"> {{-- Price display --}}
                            <span class="text-4xl font-extrabold text-white">29€</span> {{-- Price number --}}
                            <span class="text-sm text-zinc-400">/mes (facturación mensual)</span> {{-- Price period --}}
                        </div> {{-- Close price display --}}
                        <ul class="mt-8 space-y-3 text-sm text-zinc-300"> {{-- Feature list --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-[#FF2D20] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <strong>Reparaciones ilimitadas</strong></li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-[#FF2D20] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Subida de fotos de daños en alta definición</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-[#FF2D20] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Notificaciones automáticas por Email</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-[#FF2D20] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Quick Intake acelerado para móvil</li> {{-- Item 4 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-[#FF2D20] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Soporte prioritario por WhatsApp</li> {{-- Item 5 --}}
                        </ul> {{-- Close feature list --}}
                    </div> {{-- Close content block --}}
                    <div class="mt-8"> {{-- Action button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-3 px-4 text-center text-sm font-bold text-white bg-[#FF2D20] hover:bg-[#e02619] rounded-xl transition shadow-lg shadow-red-500/25">Empezar Prueba de 14 Días</a> {{-- Pro tier button --}}
                    </div> {{-- Close action button --}}
                </div> {{-- Close pro tier card --}}

                <div class="bg-zinc-900 rounded-2xl p-8 border border-zinc-800 flex flex-col justify-between"> {{-- Enterprise tier card --}}
                    <div> {{-- Content block --}}
                        <h3 class="text-lg font-bold text-white">Escuela & Factory</h3> {{-- Tier name --}}
                        <p class="text-xs text-zinc-400 mt-1">Para escuelas de surf, surf camps y fábricas multi-operario.</p> {{-- Tier description --}}
                        <div class="mt-6 flex items-baseline gap-1"> {{-- Price display --}}
                            <span class="text-4xl font-extrabold text-white">59€</span> {{-- Price number --}}
                            <span class="text-sm text-zinc-400">/mes</span> {{-- Price period --}}
                        </div> {{-- Close price display --}}
                        <ul class="mt-8 space-y-3 text-sm text-zinc-300"> {{-- Feature list --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Todo lo incluido en el plan Pro</li> {{-- Item 1 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Múltiples cuentas para operarios de taller</li> {{-- Item 2 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Gestión de flotas de escuelas y alquiler</li> {{-- Item 3 --}}
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Exportación de métricas y facturación</li> {{-- Item 4 --}}
                        </ul> {{-- Close feature list --}}
                    </div> {{-- Close content block --}}
                    <div class="mt-8"> {{-- Action button container --}}
                        <a href="{{ route('register') }}" class="block w-full py-3 px-4 text-center text-sm font-semibold text-white bg-zinc-800 hover:bg-zinc-700 rounded-xl transition border border-zinc-700">Contactar para Factory</a> {{-- Enterprise tier button --}}
                    </div> {{-- Close action button --}}
                </div> {{-- Close enterprise tier card --}}
            </div> {{-- Close pricing cards grid --}}
        </div> {{-- Close pricing container --}}
    </section> {{-- Close pricing section --}}

    <section id="talleres" class="py-20 lg:py-28 border-b border-zinc-800"> {{-- Workshop map directory section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Container --}}
            <div class="text-center max-w-3xl mx-auto mb-12"> {{-- Section header --}}
                <span class="text-xs uppercase tracking-widest font-bold text-[#FF2D20]">Ecosistema Wipeout</span> {{-- Badge --}}
                <h2 class="text-3xl font-extrabold text-white mt-2">Talleres de surf asociados</h2> {{-- Title --}}
                <p class="text-sm text-zinc-400 mt-2">Encuentra los talleres de reparación y shapers de confianza en tu zona.</p> {{-- Subhead --}}
            </div> {{-- Close header --}}
            <div class="max-w-4xl mx-auto"> {{-- Map container wrapper --}}
                <x-map-card :users="$users" /> {{-- Render interactive workshops map --}}
            </div> {{-- Close map wrapper --}}
        </div> {{-- Close container --}}
    </section> {{-- Close workshop map directory section --}}

    <section id="faq" class="py-20 lg:py-28 border-b border-zinc-800 bg-zinc-900/40"> {{-- FAQ section --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Container --}}
            <div class="text-center mb-16"> {{-- Section header --}}
                <span class="text-xs uppercase tracking-widest font-bold text-[#FF2D20]">Dudas Frecuentes</span> {{-- Badge --}}
                <h2 class="text-3xl font-extrabold text-white mt-2">Preguntas frecuentes</h2> {{-- Heading --}}
            </div> {{-- Close header --}}

            <div class="space-y-6"> {{-- FAQ items container --}}
                <div class="p-6 rounded-2xl bg-zinc-900 border border-zinc-800"> {{-- Question 1 --}}
                    <h3 class="text-base font-bold text-white mb-2">¿Mis clientes surfistas necesitan crearse una cuenta para ver el estado?</h3> {{-- Q1 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">No. El cliente solo necesita el enlace público o escanear el código QR que se le envía. No requiere contraseñas ni altas previas, lo que garantiza una adopción del 100% sin fricción.</p> {{-- A1 --}}
                </div> {{-- Close question 1 --}}

                <div class="p-6 rounded-2xl bg-zinc-900 border border-zinc-800"> {{-- Question 2 --}}
                    <h3 class="text-base font-bold text-white mb-2">¿Puedo usar Wipeout desde el teléfono móvil en el taller?</h3> {{-- Q2 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Sí. Toda la aplicación está diseñada con enfoque mobile-first. Puedes sacar fotos del toque directamente con la cámara de tu smartphone mientras inspeccionas la tabla en el potro.</p> {{-- A2 --}}
                </div> {{-- Close question 2 --}}

                <div class="p-6 rounded-2xl bg-zinc-900 border border-zinc-800"> {{-- Question 3 --}}
                    <h3 class="text-base font-bold text-white mb-2">¿Qué pasa si supero las 5 tablas mensuales del plan gratuito?</h3> {{-- Q3 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Podrás actualizar al plan Taller Pro en cualquier momento con un clic para seguir registrando tablas sin interrupciones. No perderás ningún dato ni histórico de clientes.</p> {{-- A3 --}}
                </div> {{-- Close question 3 --}}

                <div class="p-6 rounded-2xl bg-zinc-900 border border-zinc-800"> {{-- Question 4 --}}
                    <h3 class="text-base font-bold text-white mb-2">¿Pueden otros talleres ver mis clientes o presupuestos?</h3> {{-- Q4 --}}
                    <p class="text-sm text-zinc-400 leading-relaxed">Rotundamente no. La plataforma cuenta con políticas de seguridad multi-inquilino a nivel de base de datos. Cada taller solo tiene visibilidad sobre su propia información.</p> {{-- A4 --}}
                </div> {{-- Close question 4 --}}
            </div> {{-- Close FAQ items container --}}
        </div> {{-- Close container --}}
    </section> {{-- Close FAQ section --}}

    <section class="py-20 bg-gradient-to-b from-zinc-900 to-zinc-950 text-center"> {{-- Final CTA section --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Container --}}
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Lleva tu taller de surf al siguiente nivel</h2> {{-- Headline --}}
            <p class="text-base text-zinc-400 mt-4 max-w-xl mx-auto">Únete a los talleres que ya han eliminado el caos en la gestión de toques y ahorrado cientos de horas de llamadas y mensajes.</p> {{-- Subhead --}}
            <div class="mt-8 flex justify-center"> {{-- Action container --}}
                <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-white bg-[#FF2D20] hover:bg-[#e02619] rounded-xl shadow-xl shadow-red-500/25 transition transform hover:-translate-y-0.5">Crear Cuenta de Taller Gratis</a> {{-- Button --}}
            </div> {{-- Close action container --}}
        </div> {{-- Close container --}}
    </section> {{-- Close final CTA section --}}

    <footer class="py-12 border-t border-zinc-800/80 bg-zinc-950 text-xs text-zinc-500"> {{-- Footer wrapper --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4"> {{-- Footer flex container --}}
            <div class="flex items-center gap-2"> {{-- Brand footer block --}}
                <x-application-logo class="w-6 h-6 fill-current text-[#FF2D20]" /> {{-- Footer logo --}}
                <span class="font-bold text-zinc-300">WIPEOUT</span> {{-- Wordmark --}}
                <span>© {{ date('Y') }} Todos los derechos reservados.</span> {{-- Copyright notice --}}
            </div> {{-- Close brand footer block --}}
            <div class="flex items-center gap-6"> {{-- Footer links --}}
                <a href="#caracteristicas" class="hover:text-zinc-300 transition">Características</a> {{-- Link 1 --}}
                <a href="#precios" class="hover:text-zinc-300 transition">Precios</a> {{-- Link 2 --}}
                <a href="{{ route('login') }}" class="hover:text-zinc-300 transition">Acceso Taller</a> {{-- Link 3 --}}
            </div> {{-- Close footer links --}}
        </div> {{-- Close footer flex container --}}
    </footer> {{-- Close footer wrapper --}}
</body> {{-- Close body tag --}}
</html> {{-- Close html tag --}}
