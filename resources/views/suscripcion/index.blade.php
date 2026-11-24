<x-app-layout> {{-- Main authenticated application layout component --}}
    <x-slot name="header"> {{-- Layout header slot --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"> {{-- Header flex container --}}
            <div> {{-- Title wrapper --}}
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ __('Plan y Suscripción del Taller') }}</h2> {{-- Section heading --}}
                <p class="text-xs text-gray-500 mt-0.5">Gestiona tu cuota mensual de tablas, facturación y suscripción Pro.</p> {{-- Subtitle --}}
            </div> {{-- Close title wrapper --}}
        </div> {{-- Close header flex container --}}
    </x-slot> {{-- Close header slot --}}

    <div class="py-8"> {{-- Content spacing wrapper --}}
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Container column --}}
            @if (session('success')) {{-- Check success flash message --}}
                <div class="p-4 text-sm font-semibold text-green-800 bg-green-100 rounded-xl dark:bg-green-950/40 dark:text-green-300">{{ session('success') }}</div> {{-- Success banner --}}
            @endif {{-- Close success check --}}
            @if (session('info')) {{-- Check info flash message --}}
                <div class="p-4 text-sm font-semibold text-blue-800 bg-blue-100 rounded-xl dark:bg-blue-950/40 dark:text-blue-300">{{ session('info') }}</div> {{-- Info banner --}}
            @endif {{-- Close info check --}}

            <div class="bg-white dark:bg-zinc-800 rounded-2xl p-6 sm:p-8 border border-gray-100 dark:border-zinc-700 shadow-sm"> {{-- Current plan card --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 dark:border-zinc-700 pb-6 mb-6"> {{-- Card top row --}}
                    <div> {{-- Plan info block --}}
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Tu Plan Actual</span> {{-- Label --}}
                        <div class="flex items-center gap-3 mt-1"> {{-- Plan heading row --}}
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $is_pro ? 'Taller Pro' : 'Shaper Local (Gratis)' }}</h3> {{-- Plan title --}}
                            @if ($is_pro) {{-- Pro active badge --}}
                                <span class="px-2.5 py-0.5 text-xs font-extrabold uppercase tracking-wider bg-green-100 text-green-800 dark:bg-green-950/50 dark:text-green-300 rounded-full">Activo ⚡</span> {{-- Badge --}}
                            @else {{-- Free plan badge --}}
                                <span class="px-2.5 py-0.5 text-xs font-extrabold uppercase tracking-wider bg-gray-100 text-gray-700 dark:bg-zinc-700 dark:text-gray-300 rounded-full">Básico</span> {{-- Badge --}}
                            @endif {{-- Close plan badge --}}
                        </div> {{-- Close heading row --}}
                    </div> {{-- Close plan info block --}}

                    <div> {{-- Action CTA block --}}
                        @if (!$is_pro) {{-- Upgrade button for free users --}}
                            <form action="{{ route('suscripcion.checkout') }}" method="POST"> {{-- Checkout form --}}
                                @csrf {{-- CSRF token --}}
                                <input type="hidden" name="plan" value="pro" /> {{-- Target plan --}}
                                <button type="submit" class="px-6 py-3 bg-[#FF2D20] hover:bg-[#e02619] text-white text-sm font-bold rounded-xl shadow-lg shadow-red-500/20 transition transform hover:-translate-y-0.5 flex items-center gap-2"> {{-- Action button --}}
                                    <span>⚡</span> Actualizar a Taller Pro (29€/mes) {{-- Button label --}}
                                </button> {{-- Close action button --}}
                            </form> {{-- Close form --}}
                        @else {{-- Cancel button for pro users --}}
                            <form action="{{ route('suscripcion.cancel') }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar tu suscripción Pro?');"> {{-- Cancel form --}}
                                @csrf {{-- CSRF token --}}
                                <button type="submit" class="px-4 py-2 border border-gray-300 dark:border-zinc-600 text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-red-600 rounded-lg transition">Cancelar Suscripción</button> {{-- Cancel button --}}
                            </form> {{-- Close cancel form --}}
                        @endif {{-- Close action check --}}
                    </div> {{-- Close action block --}}
                </div> {{-- Close card top row --}}

                <div> {{-- Quota consumption section --}}
                    <div class="flex items-center justify-between text-sm mb-2"> {{-- Progress header --}}
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Uso de tablas este mes:</span> {{-- Label --}}
                        <span class="font-mono font-bold text-gray-900 dark:text-white"> {{-- Quota text --}}
                            @if ($is_pro) {{-- Unlimited indicator --}}
                                {{ $monthly_repairs }} tablas registradas (Ilimitadas) {{-- Unlimited label --}}
                            @else {{-- Capped indicator --}}
                                {{ $monthly_repairs }} / {{ $max_free_repairs }} tablas registradas {{-- Ratio label --}}
                            @endif {{-- Close indicator --}}
                        </span> {{-- Close quota text --}}
                    </div> {{-- Close progress header --}}

                    @if (!$is_pro) {{-- Free quota progress bar --}}
                        @php // Calculate percent
                            $quota_pct = min(100, round(($monthly_repairs / $max_free_repairs) * 100)); // Cap percentage at 100
                        @endphp {{-- End PHP block --}}
                        <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-3 overflow-hidden"> {{-- Bar rail --}}
                            <div class="h-3 rounded-full transition-all duration-500 {{ $quota_pct >= 100 ? 'bg-red-500' : 'bg-[#FF2D20]' }}" style="width: {{ $quota_pct }}%;"></div> {{-- Active fill --}}
                        </div> {{-- Close bar rail --}}
                        @if ($monthly_repairs >= $max_free_repairs) {{-- Reached limit alert --}}
                            <div class="mt-4 p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900 text-xs text-red-700 dark:text-red-400"> {{-- Alert container --}}
                                <strong>⚠️ Has alcanzado el límite mensual:</strong> No podrás registrar nuevas órdenes hasta el próximo mes salvo que actualices a <strong>Taller Pro</strong>. {{-- Alert text --}}
                            </div> {{-- Close alert container --}}
                        @endif {{-- Close limit check --}}
                    @endif {{-- Close free progress bar --}}
                </div> {{-- Close quota section --}}
            </div> {{-- Close current plan card --}}

            <div class="grid md:grid-cols-2 gap-6"> {{-- Plan comparison grid --}}
                <div class="bg-white dark:bg-zinc-800 rounded-2xl p-6 border border-gray-100 dark:border-zinc-700"> {{-- Free tier box --}}
                    <h4 class="font-bold text-base text-gray-900 dark:text-white">Shaper Local (Gratis)</h4> {{-- Title --}}
                    <p class="text-xs text-gray-500 mt-1">Para artesanos independientes o talleres ocasionales.</p> {{-- Description --}}
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white mt-4">0€ <span class="text-xs font-normal text-gray-500">/mes</span></div> {{-- Price --}}
                    <ul class="mt-6 space-y-2.5 text-xs text-gray-600 dark:text-gray-300"> {{-- Features list --}}
                        <li class="flex items-center gap-2">✓ Hasta 5 tablas activas al mes</li> {{-- Item 1 --}}
                        <li class="flex items-center gap-2">✓ Seguimiento QR y portal público</li> {{-- Item 2 --}}
                        <li class="flex items-center gap-2">✓ Tablero Kanban visual básico</li> {{-- Item 3 --}}
                        <li class="flex items-center gap-2">✓ Impresión de tickets y etiquetas</li> {{-- Item 4 --}}
                    </ul> {{-- Close list --}}
                </div> {{-- Close free tier box --}}

                <div class="bg-gradient-to-b from-red-50/50 to-white dark:from-red-950/20 dark:to-zinc-800 rounded-2xl p-6 border-2 border-[#FF2D20]"> {{-- Pro tier box --}}
                    <span class="text-[10px] font-extrabold uppercase tracking-widest bg-[#FF2D20] text-white px-2.5 py-0.5 rounded-full">Recomendado</span> {{-- Pro tag --}}
                    <h4 class="font-bold text-base text-gray-900 dark:text-white mt-2">Taller Pro</h4> {{-- Title --}}
                    <p class="text-xs text-gray-500 mt-1">Para talleres con flujo regular de toques y clientes.</p> {{-- Description --}}
                    <div class="text-3xl font-extrabold text-[#FF2D20] mt-4">29€ <span class="text-xs font-normal text-gray-500">/mes</span></div> {{-- Price --}}
                    <ul class="mt-6 space-y-2.5 text-xs text-gray-700 dark:text-gray-200"> {{-- Features list --}}
                        <li class="flex items-center gap-2 font-semibold">⚡ Reparaciones y tablas ilimitadas</li> {{-- Item 1 --}}
                        <li class="flex items-center gap-2">⚡ Fotografías de inspección en alta resolución</li> {{-- Item 2 --}}
                        <li class="flex items-center gap-2">⚡ Notificaciones automáticas por Email</li> {{-- Item 3 --}}
                        <li class="flex items-center gap-2">⚡ Avisos por WhatsApp con 1 clic</li> {{-- Item 4 --}}
                        <li class="flex items-center gap-2">⚡ Soporte prioritario para tu taller</li> {{-- Item 5 --}}
                    </ul> {{-- Close list --}}
                </div> {{-- Close pro tier box --}}
            </div> {{-- Close comparison grid --}}
        </div> {{-- Close container column --}}
    </div> {{-- Close content wrapper --}}
</x-app-layout> {{-- Close layout --}}
