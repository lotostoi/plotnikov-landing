@php
    /**
     * Плавающие слова и иконки. Координаты, размеры и повороты — 1:1 с React-компонентом.
     * @var string $variant — 'hero' | 'about' | 'services' | 'contacts'
     */

    $iconClasses = [
        0 => 'fi-rose',     // Heart
        1 => 'fi-amber',    // Brain
        2 => 'fi-yellow',   // Sparkles
        3 => 'fi-orange',   // Sun
        4 => 'fi-stone',    // Cloud
        5 => 'fi-emerald',  // Leaf
        6 => 'fi-amber-2',  // Star
        7 => 'fi-teal',     // MessageCircle
        8 => 'fi-yellow-2', // Smile
        9 => 'fi-amber-deep', // Coffee
        10 => 'fi-orange-2',  // Feather
        11 => 'fi-yellow-3',  // Lightbulb
        12 => 'fi-sky',       // Eye
        13 => 'fi-amber-3',   // Zap
        14 => 'fi-rose-2',    // Music
        15 => 'fi-pink',      // Flower2
    ];
    $iconNames = [
        0 => 'heart', 1 => 'brain', 2 => 'sparkles', 3 => 'sun', 4 => 'cloud', 5 => 'leaf',
        6 => 'star', 7 => 'message-circle', 8 => 'smile', 9 => 'coffee', 10 => 'feather',
        11 => 'lightbulb', 12 => 'eye', 13 => 'zap', 14 => 'music', 15 => 'flower-2',
    ];

    $configs = [
        'hero' => [
            ['type' => 'phrase', 'text' => 'доверие',     'x' => '2%',  'y' => '8%',  'size' => '1.5rem',   'rotate' => -6],
            ['type' => 'icon',   'iconIndex' => 0,        'x' => '5%',  'y' => '22%', 'size' => 32],
            ['type' => 'phrase', 'text' => 'чувства',     'x' => '3%',  'y' => '38%', 'size' => '1.25rem',  'rotate' => 4],
            ['type' => 'icon',   'iconIndex' => 8,        'x' => '6%',  'y' => '52%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'гармония',    'x' => '2%',  'y' => '68%', 'size' => '1.125rem', 'rotate' => -5],
            ['type' => 'icon',   'iconIndex' => 3,        'x' => '4%',  'y' => '82%', 'size' => 30],
            ['type' => 'phrase', 'text' => 'опора',       'x' => '8%',  'y' => '92%', 'size' => '1.25rem',  'rotate' => 3],
            ['type' => 'phrase', 'text' => 'осознанность','x' => '78%', 'y' => '5%',  'size' => '1.5rem',   'rotate' => 5],
            ['type' => 'icon',   'iconIndex' => 1,        'x' => '92%', 'y' => '18%', 'size' => 34],
            ['type' => 'phrase', 'text' => 'контакт',     'x' => '85%', 'y' => '32%', 'size' => '1.25rem',  'rotate' => -4],
            ['type' => 'icon',   'iconIndex' => 2,        'x' => '88%', 'y' => '48%', 'size' => 26],
            ['type' => 'phrase', 'text' => 'принятие',    'x' => '80%', 'y' => '62%', 'size' => '1.125rem', 'rotate' => 6],
            ['type' => 'icon',   'iconIndex' => 5,        'x' => '93%', 'y' => '75%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'рост',        'x' => '86%', 'y' => '88%', 'size' => '1.5rem',   'rotate' => -3],
            ['type' => 'icon',   'iconIndex' => 6,        'x' => '35%', 'y' => '3%',  'size' => 24],
            ['type' => 'icon',   'iconIndex' => 12,       'x' => '55%', 'y' => '5%',  'size' => 22],
            ['type' => 'icon',   'iconIndex' => 9,        'x' => '45%', 'y' => '95%', 'size' => 26],
        ],
        'about' => [
            ['type' => 'icon',   'iconIndex' => 4,        'x' => '2%',  'y' => '10%', 'size' => 30],
            ['type' => 'phrase', 'text' => 'понимание',   'x' => '4%',  'y' => '25%', 'size' => '1.25rem',  'rotate' => -4],
            ['type' => 'icon',   'iconIndex' => 10,       'x' => '3%',  'y' => '42%', 'size' => 26],
            ['type' => 'phrase', 'text' => 'покой',       'x' => '5%',  'y' => '58%', 'size' => '1.125rem', 'rotate' => 5],
            ['type' => 'icon',   'iconIndex' => 5,        'x' => '2%',  'y' => '75%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'ресурс',      'x' => '6%',  'y' => '90%', 'size' => '1.25rem',  'rotate' => -3],
            ['type' => 'phrase', 'text' => 'принятие',    'x' => '82%', 'y' => '8%',  'size' => '1.5rem',   'rotate' => 4],
            ['type' => 'icon',   'iconIndex' => 11,       'x' => '90%', 'y' => '22%', 'size' => 32],
            ['type' => 'phrase', 'text' => 'границы',     'x' => '85%', 'y' => '38%', 'size' => '1.125rem', 'rotate' => -5],
            ['type' => 'icon',   'iconIndex' => 13,       'x' => '92%', 'y' => '55%', 'size' => 24],
            ['type' => 'phrase', 'text' => 'эмпатия',     'x' => '80%', 'y' => '72%', 'size' => '1.25rem',  'rotate' => 3],
            ['type' => 'icon',   'iconIndex' => 15,       'x' => '88%', 'y' => '88%', 'size' => 28],
        ],
        'services' => [
            ['type' => 'phrase', 'text' => 'забота',      'x' => '2%',  'y' => '6%',  'size' => '1.5rem',   'rotate' => -5],
            ['type' => 'icon',   'iconIndex' => 0,        'x' => '5%',  'y' => '20%', 'size' => 30],
            ['type' => 'phrase', 'text' => 'выбор',       'x' => '3%',  'y' => '35%', 'size' => '1.125rem', 'rotate' => 4],
            ['type' => 'icon',   'iconIndex' => 7,        'x' => '4%',  'y' => '50%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'смысл',       'x' => '2%',  'y' => '65%', 'size' => '1.25rem',  'rotate' => -3],
            ['type' => 'icon',   'iconIndex' => 14,       'x' => '6%',  'y' => '80%', 'size' => 26],
            ['type' => 'phrase', 'text' => 'свобода',     'x' => '4%',  'y' => '93%', 'size' => '1.125rem', 'rotate' => 5],
            ['type' => 'icon',   'iconIndex' => 6,        'x' => '90%', 'y' => '8%',  'size' => 32],
            ['type' => 'phrase', 'text' => 'ценность',    'x' => '82%', 'y' => '22%', 'size' => '1.25rem',  'rotate' => 4],
            ['type' => 'icon',   'iconIndex' => 2,        'x' => '93%', 'y' => '38%', 'size' => 26],
            ['type' => 'phrase', 'text' => 'понимание',   'x' => '78%', 'y' => '55%', 'size' => '1.5rem',   'rotate' => -4],
            ['type' => 'icon',   'iconIndex' => 12,       'x' => '88%', 'y' => '70%', 'size' => 30],
            ['type' => 'phrase', 'text' => 'баланс',      'x' => '85%', 'y' => '85%', 'size' => '1.125rem', 'rotate' => 3],
        ],
        'contacts' => [
            ['type' => 'phrase', 'text' => 'близость',    'x' => '3%',  'y' => '10%', 'size' => '1.25rem',  'rotate' => 5],
            ['type' => 'icon',   'iconIndex' => 8,        'x' => '4%',  'y' => '28%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'контакт',     'x' => '2%',  'y' => '45%', 'size' => '1.5rem',   'rotate' => -4],
            ['type' => 'icon',   'iconIndex' => 1,        'x' => '5%',  'y' => '62%', 'size' => 30],
            ['type' => 'phrase', 'text' => 'доверие',     'x' => '3%',  'y' => '78%', 'size' => '1.125rem', 'rotate' => 3],
            ['type' => 'icon',   'iconIndex' => 0,        'x' => '6%',  'y' => '92%', 'size' => 26],
            ['type' => 'icon',   'iconIndex' => 3,        'x' => '92%', 'y' => '8%',  'size' => 32],
            ['type' => 'phrase', 'text' => 'поддержка',   'x' => '80%', 'y' => '22%', 'size' => '1.25rem',  'rotate' => -3],
            ['type' => 'icon',   'iconIndex' => 7,        'x' => '88%', 'y' => '40%', 'size' => 28],
            ['type' => 'phrase', 'text' => 'тепло',       'x' => '85%', 'y' => '58%', 'size' => '1.5rem',   'rotate' => 5],
            ['type' => 'icon',   'iconIndex' => 11,       'x' => '92%', 'y' => '75%', 'size' => 26],
            ['type' => 'phrase', 'text' => 'связь',       'x' => '82%', 'y' => '90%', 'size' => '1.125rem', 'rotate' => -4],
        ],
    ];
    $elements = $configs[$variant ?? 'hero'] ?? $configs['hero'];
@endphp

<div class="floating-layer" aria-hidden="true">
    @foreach ($elements as $i => $el)
        @if ($el['type'] === 'phrase')
            <span class="floating-phrase"
                  style="left: {{ $el['x'] }}; top: {{ $el['y'] }}; font-size: {{ $el['size'] }}; --r: {{ $el['rotate'] }}deg; animation-duration: {{ 5 + $i * 0.7 }}s; animation-delay: {{ $i * 0.2 }}s;">{{ $el['text'] }}</span>
        @else
            @php
                $idx = $el['iconIndex'] ?? 0;
                $iconClass = $iconClasses[$idx] ?? 'fi-amber';
                $iconName = $iconNames[$idx] ?? 'sparkles';
            @endphp
            <span class="floating-icon {{ $iconClass }}"
                  style="left: {{ $el['x'] }}; top: {{ $el['y'] }}; animation-duration: {{ 6 + $i * 0.6 }}s; animation-delay: {{ $i * 0.3 }}s;">
                <i data-lucide="{{ $iconName }}" style="width: {{ $el['size'] }}px; height: {{ $el['size'] }}px;"></i>
            </span>
        @endif
    @endforeach

    <div class="layer-glow-tl"></div>
    <div class="layer-glow-br"></div>
</div>
