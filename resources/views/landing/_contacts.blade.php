<section id="contacts" class="relative overflow-hidden py-20 md:py-28 bg-secondary">
    <div class="contacts-bg"></div>
    @include('landing._floating', ['variant' => 'contacts'])

    <div class="relative mx-auto max-w-7xl px-4 md:px-6">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Контент --}}
            <div class="flex flex-col justify-center space-y-8" data-reveal="left">
                <div class="space-y-4 self-start text-left">
                    <p class="text-sm font-semibold uppercase tracking-widest" style="color: var(--theme-gradient-from)">{{ $contactsHeading['badge'] }}</p>
                    <h2 class="text-balance text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">
                        {{ $contactsHeading['title'] }} <span class="theme-gradient-text-amber">{{ $contactsHeading['subtitle'] }}</span>
                    </h2>
                    <p class="text-lg leading-relaxed text-muted-foreground">
                        {{ $contactsHeading['description'] }}
                    </p>
                </div>

                {{-- Бесплатный созвон --}}
                <div class="free-call-card" data-reveal data-reveal-delay="200">
                    <span class="deco"></span>
                    <div class="relative flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl"
                             style="background: rgba(255,255,255,.2); backdrop-filter: blur(8px);">
                            <i data-lucide="phone" style="width:26px;height:26px;color:#fff"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-white">{{ $contactsFreeCall['title'] }}</h3>
                                <i data-lucide="sparkles" style="width:16px;height:16px;color:#fff"></i>
                            </div>
                            <p class="text-sm" style="color: rgba(255,255,255,.85)">{{ $contactsFreeCall['subtitle'] }}</p>
                        </div>
                    </div>
                    <p class="relative mt-4" style="color: rgba(255,255,255,.95)">
                        {{ $contactsFreeCall['description'] }}
                    </p>
                </div>

                {{-- Кнопки мессенджеров (личный Telegram, не канал) --}}
                <div class="space-y-4" data-reveal data-reveal-delay="300">
                    <p class="font-semibold text-foreground">Напишите мне:</p>
                    <div class="flex flex-col flex-wrap gap-4 sm:flex-row">
                        <a href="{{ $contactsTelegram['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="btn btn-lg btn-telegram flex-1 min-w-[10rem]">
                            <i data-lucide="{{ $contactsTelegram['icon'] }}" style="width:20px;height:20px"></i>
                            <span>{{ $contactsTelegram['text'] }}</span>
                        </a>
                        <a href="{{ $contactsWhatsapp['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="btn btn-lg btn-whatsapp flex-1 min-w-[10rem]">
                            <i data-lucide="{{ $contactsWhatsapp['icon'] }}" style="width:20px;height:20px"></i>
                            <span>{{ $contactsWhatsapp['text'] }}</span>
                        </a>
                        <a href="{{ $contactsMax['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="btn btn-lg btn-max flex-1 min-w-[10rem]">
                            <i data-lucide="{{ $contactsMax['icon'] }}" style="width:20px;height:20px"></i>
                            <span>{{ $contactsMax['text'] }}</span>
                        </a>
                    </div>

                    @if ($contactsTelegramChannel['visible'] && !empty($contactsTelegramChannel['url']))
                        <a href="{{ $contactsTelegramChannel['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="tg-channel-card group flex gap-4 rounded-2xl border border-border bg-card/80 p-4 transition-all hover:border-[#0088cc]/40 hover:shadow-md">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl"
                                 style="background: linear-gradient(135deg, #0088cc22, #00a8e822);">
                                <i data-lucide="{{ $contactsTelegramChannel['icon'] }}" style="width:22px;height:22px;color:#0088cc"></i>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <p class="text-sm font-bold text-foreground leading-snug">{{ $contactsTelegramChannel['title'] }}</p>
                                <p class="text-xs text-muted-foreground leading-relaxed">{{ $contactsTelegramChannel['subtitle'] }}</p>
                                <span class="inline-flex items-center gap-1 text-sm font-semibold theme-gradient-text pt-1">
                                    {{ $contactsTelegramChannel['button_text'] }}
                                    <i data-lucide="arrow-right" style="width:14px;height:14px;transition:transform .2s" class="group-hover:translate-x-0.5"></i>
                                </span>
                            </div>
                        </a>
                    @endif

                    <a href="{{ $contactsPhone['url'] }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-foreground hover:opacity-75 transition-opacity">
                        <i data-lucide="phone" style="width:15px;height:15px;color:var(--theme-gradient-from)"></i>
                        {{ $contactsPhone['number'] }}
                    </a>
                </div>

                {{-- Локация --}}
                <div class="card flex items-center gap-3 p-4" data-reveal data-reveal-delay="400">
                    <div class="icon-box-sm icon-box" style="width:42px;height:42px;border-radius:.85rem">
                        <i data-lucide="{{ $contactsLocation['icon'] }}" style="width:20px;height:20px"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-foreground">{{ $contactsLocation['title'] }}</p>
                        <p class="text-sm text-muted-foreground">{{ $contactsLocation['subtitle'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Изображение --}}
            <div class="relative mx-auto w-full max-w-md lg:max-w-none" data-reveal="right">
                <div class="photo-frame aspect-[3/4]">
                    <img src="{{ $images['contacts'] }}" alt="Александр - психолог" loading="lazy">
                </div>
                <div class="glow glow-amber glow-pulse-amber"
                     style="bottom:-2rem; right:-2rem; width:12rem; height:12rem; z-index:-1;"></div>
            </div>
        </div>
    </div>
</section>
