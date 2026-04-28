<footer class="site-footer">
    <span class="footer-glow-1"></span>
    <span class="footer-glow-2"></span>

    <div class="relative mx-auto max-w-7xl px-4 py-16 md:px-6">
        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            {{-- Brand --}}
            <div class="space-y-6 lg:col-span-2" data-reveal>
                <a href="#top" class="inline-flex items-baseline gap-2 group">
                    <span class="text-2xl font-bold tracking-tight theme-gradient-text">{{ $footerBrand['title'] }}</span>
                    <span class="text-sm transition-colors" style="color: rgba(255,255,255,.6)">{{ $footerBrand['subtitle'] }}</span>
                </a>
                <p class="max-w-md leading-relaxed" style="color: rgba(255,255,255,.7)">
                    {{ $footerBrand['description'] }}
                </p>
                <div class="flex gap-3">
                    <a href="{{ $content->telegram_url }}" target="_blank" rel="noopener noreferrer"
                       class="social-square social-telegram" aria-label="Telegram">
                        <i data-lucide="send" style="width:20px;height:20px"></i>
                    </a>
                    <a href="{{ $content->whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                       class="social-square social-whatsapp" aria-label="WhatsApp">
                        <i data-lucide="message-circle" style="width:20px;height:20px"></i>
                    </a>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="space-y-4" data-reveal data-reveal-delay="100">
                <h3 class="font-semibold text-white">Навигация</h3>
                <nav class="flex flex-col gap-3">
                    @foreach (array_slice($navItems, 0, 4) as $item)
                        <a href="{{ $item['href'] }}" class="text-sm transition-colors duration-200"
                           style="color: rgba(255,255,255,.6)"
                           onmouseover="this.style.color='rgba(255,255,255,.95)'"
                           onmouseout="this.style.color='rgba(255,255,255,.6)'">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- More --}}
            <div class="space-y-4" data-reveal data-reveal-delay="200">
                <h3 class="font-semibold text-white">Ещё</h3>
                <nav class="flex flex-col gap-3">
                    @foreach (array_slice($navItems, 4) as $item)
                        <a href="{{ $item['href'] }}" class="text-sm transition-colors duration-200"
                           style="color: rgba(255,255,255,.6)"
                           onmouseover="this.style.color='rgba(255,255,255,.95)'"
                           onmouseout="this.style.color='rgba(255,255,255,.6)'">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t pt-8 sm:flex-row sm:items-center sm:justify-between"
             style="border-color: rgba(255,255,255,.1)" data-reveal data-reveal-delay="300">
            <p class="inline-flex items-center gap-1 text-sm" style="color: rgba(255,255,255,.55)">
                © {{ date('Y') }} {{ $footerBrand['title'] }}. {{ $footerCopyright['text'] }}
                <i data-lucide="heart" style="width:12px;height:12px;color:var(--theme-gradient-from);fill:var(--theme-gradient-from)"></i>
            </p>
            <p class="text-sm" style="color: rgba(255,255,255,.55)">{{ $content->location_text }}</p>
        </div>
    </div>
</footer>
