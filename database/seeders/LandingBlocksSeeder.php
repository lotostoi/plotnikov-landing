<?php

namespace Database\Seeders;

use App\Models\LandingBlock;
use Illuminate\Database\Seeder;

class LandingBlocksSeeder extends Seeder
{
    public function run(): void
    {
        $blocks = [
            // Header
            ['section_code' => 'header', 'block_key' => 'brand', 'block_type' => 'brand', 'title' => 'Александр', 'subtitle' => 'психолог', 'sort_order' => 10],
            ['section_code' => 'header', 'block_key' => 'cta', 'block_type' => 'cta', 'button_text' => 'Записаться', 'button_url' => '#contacts', 'sort_order' => 20],

            // Header navigation
            ['section_code' => 'header', 'block_key' => 'nav_about', 'block_type' => 'nav_item', 'label' => 'Обо мне', 'button_url' => '#about', 'sort_order' => 30],
            ['section_code' => 'header', 'block_key' => 'nav_services', 'block_type' => 'nav_item', 'label' => 'Услуги', 'button_url' => '#services', 'sort_order' => 40],
            ['section_code' => 'header', 'block_key' => 'nav_education', 'block_type' => 'nav_item', 'label' => 'Образование', 'button_url' => '#education', 'sort_order' => 50],
            ['section_code' => 'header', 'block_key' => 'nav_reviews', 'block_type' => 'nav_item', 'label' => 'Отзывы', 'button_url' => '#reviews', 'sort_order' => 60],
            ['section_code' => 'header', 'block_key' => 'nav_blog', 'block_type' => 'nav_item', 'label' => 'Блог', 'button_url' => '#blog', 'sort_order' => 70],
            ['section_code' => 'header', 'block_key' => 'nav_faq', 'block_type' => 'nav_item', 'label' => 'FAQ', 'button_url' => '#faq', 'sort_order' => 80],
            ['section_code' => 'header', 'block_key' => 'nav_contacts', 'block_type' => 'nav_item', 'label' => 'Контакты', 'button_url' => '#contacts', 'sort_order' => 90],

            // Hero
            ['section_code' => 'hero', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Гештальт-терапевт', 'title' => 'Здравствуйте,', 'subtitle' => 'я Александр', 'body' => 'Уже 15 лет моя жизнь связана с психологией. Помогаю людям находить опору и контакт с собой через доверие и живое человеческое присутствие.', 'sort_order' => 10],
            ['section_code' => 'hero', 'block_key' => 'cta_primary', 'block_type' => 'cta', 'button_text' => 'Бесплатный созвон 15 мин', 'button_url' => '#contacts', 'sort_order' => 20],
            ['section_code' => 'hero', 'block_key' => 'cta_secondary', 'block_type' => 'cta', 'button_text' => 'Узнать больше', 'button_url' => '#about', 'sort_order' => 30],
            ['section_code' => 'hero', 'block_key' => 'format_badge', 'block_type' => 'badge', 'label' => 'Формат', 'title' => 'Онлайн по всему миру', 'sort_order' => 40],
            ['section_code' => 'hero', 'block_key' => 'stat_1', 'block_type' => 'stat', 'title' => '15+', 'subtitle' => 'лет в психологии', 'sort_order' => 50],
            ['section_code' => 'hero', 'block_key' => 'stat_2', 'block_type' => 'stat', 'title' => '12+', 'subtitle' => 'лет личной терапии', 'sort_order' => 60],
            ['section_code' => 'hero', 'block_key' => 'stat_3', 'block_type' => 'stat', 'title' => '10+', 'subtitle' => 'лет групповой', 'sort_order' => 70],

            // About — заголовок
            ['section_code' => 'about', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Обо мне', 'title' => 'Немного', 'subtitle' => 'обо мне', 'sort_order' => 10],

            // About — слайды (about_slide: label=иконка, title=заголовок, body=текст через \n\n, button_url=фото)
            ['section_code' => 'about', 'block_key' => 'slide_1', 'block_type' => 'about_slide', 'label' => 'message-circle', 'title' => 'Здравствуйте, я Александр',
                'body' => "Уже 15 лет моя жизнь связана с психологией — сначала я проходил этот путь как клиент, а теперь помогаю людям находить опору и контакт с собой.\n\nДля меня работа с человеком — это не столько про техники и подходы, сколько про доверие, контакт и живое человеческое присутствие.\n\nИз собственного опыта знаю, как непросто выбрать специалиста, с которым действительно чувствуешь понимание и безопасность. Поэтому можно предварительно созвониться — бесплатно, 15 минут.",
                'button_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
                'sort_order' => 20],

            ['section_code' => 'about', 'block_key' => 'slide_2', 'block_type' => 'about_slide', 'label' => 'user', 'title' => 'Немного обо мне',
                'body' => "Мне 42 года, я женат. Долгое время работал в научно-исследовательском институте, защитил кандидатскую диссертацию.\n\nПозже сменил профессию и ушёл в IT — вырос от программиста до тимлида, создал команду и прошёл через непростые изменения.\n\nЭти опыты многому меня научили: выдерживать кризисы, быть рядом с людьми и сохранять контакт, даже когда тяжело.",
                'button_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
                'sort_order' => 30],

            ['section_code' => 'about', 'block_key' => 'slide_3', 'block_type' => 'about_slide', 'label' => 'heart', 'title' => 'Что для меня важно',
                'body' => "Самое ценное в моей жизни — отношения с женой. Мы вместе больше 20 лет, и первые годы были очень трудными. Мы оба не сдавались, и со временем смогли построить тёплые, живые отношения — сегодня это моя главная опора и гордость.\n\nЕщё одна вещь, которой горжусь: за полтора года руководства командой из IT-разработчиков от меня не ушёл ни один человек, хотя условия в компании были непростыми. Для меня это про доверие и уважение — и в работе, и в жизни.",
                'button_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
                'sort_order' => 40],

            ['section_code' => 'about', 'block_key' => 'slide_4', 'block_type' => 'about_slide', 'label' => 'flame', 'title' => 'Мои кризисы',
                'body' => "Первый — во время сложных отношений с женой и болезни отца, когда я впервые пришёл к психологу. Второй — смерть матери. Третий — смена профессии в зрелом возрасте.\n\nИ, если честно, сейчас я снова в переходе — думаю о том, чтобы полностью перейти в психологию и оставить IT.\n\nМне близка тема кризисов и перемен — я знаю, как они проживаются изнутри.",
                'button_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
                'sort_order' => 50],

            ['section_code' => 'about', 'block_key' => 'slide_5', 'block_type' => 'about_slide', 'label' => 'graduation-cap', 'title' => 'Образование и опыт',
                'body' => "Более 12 лет личной терапии (с перерывами) и 10 лет участия в групповой терапии.\n\nАвторская школа Интегральной Гуманистической Психотерапии — Первый университет проф. В.В. Макарова. Московский гештальт-институт — заканчиваю вторую ступень.\n\nПодходы: гештальт, КПТ, трансактный анализ, процессуальная психология.",
                'button_url' => 'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/IMG_7891_resized-VcwCPl7QQgWdCieGIyVbOxHgaXxQc6.jpeg',
                'sort_order' => 60],

            // Services
            ['section_code' => 'services', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Услуги', 'title' => 'С чем я', 'subtitle' => 'работаю', 'body' => 'Подходы: Гештальт, КПТ, трансактный анализ, процессуальная психология', 'sort_order' => 10],
            ['section_code' => 'services', 'block_key' => 'issue_1', 'block_type' => 'card',
                'label' => 'heart-crack', 'badge' => 'rose',
                'title' => 'Отношения, в которых больно',
                'body' => 'Ссоры по кругу, стены непонимания, одиночество вдвоём — когда близость превратилась в боль, а не в опору.',
                'sort_order' => 20],
            ['section_code' => 'services', 'block_key' => 'issue_2', 'block_type' => 'card',
                'label' => 'zap', 'badge' => 'amber',
                'title' => 'Тревога, которая не отпускает',
                'body' => 'Напряжение стало фоном жизни. Тело не умеет расслабиться. Вы уже забыли, каково это — просто дышать.',
                'sort_order' => 30],
            ['section_code' => 'services', 'block_key' => 'issue_3', 'block_type' => 'card',
                'label' => 'compass', 'badge' => 'teal',
                'title' => 'Вы потеряли себя',
                'body' => 'Живёте чужими ожиданиями, угождаете всем кроме себя. Не знаете, чего хотите на самом деле — и это пугает.',
                'sort_order' => 40],
            ['section_code' => 'services', 'block_key' => 'issue_4', 'block_type' => 'card',
                'label' => 'mountain-snow', 'badge' => 'violet',
                'title' => 'Кризис. Всё рухнуло.',
                'body' => 'Потеря, развод, смерть близкого, смена профессии. Почву выбило из-под ног. Я сам через это прошёл — знаю, что выход есть.',
                'sort_order' => 50],
            ['section_code' => 'services', 'block_key' => 'issue_5', 'block_type' => 'card',
                'label' => 'battery-low', 'badge' => 'emerald',
                'title' => 'Выгорание. Внутри — пусто.',
                'body' => 'Вы всё ещё работаете, но на автопилоте. Нет сил, нет радости, нет смысла. Это не лень — это сигнал, который нельзя игнорировать.',
                'sort_order' => 60],
            ['section_code' => 'services', 'block_key' => 'issue_6', 'block_type' => 'card',
                'label' => 'users-round', 'badge' => 'indigo',
                'title' => 'Одиноко среди людей',
                'body' => 'Люди вокруг есть, а настоящей близости нет. Страх привязанности, зависимость от чужого одобрения, невозможность довериться.',
                'sort_order' => 70],
            ['section_code' => 'services', 'block_key' => 'format_1', 'block_type' => 'format', 'label' => 'video', 'title' => 'Онлайн', 'body' => 'Удобно из любой точки мира', 'sort_order' => 75],
            ['section_code' => 'services', 'block_key' => 'format_2', 'block_type' => 'format', 'label' => 'map-pin', 'title' => 'Очно', 'body' => 'Владивосток, Артём', 'sort_order' => 76],
            ['section_code' => 'services', 'block_key' => 'format_3', 'block_type' => 'format', 'label' => 'clock', 'title' => '55 минут', 'body' => 'Продолжительность встречи', 'sort_order' => 77],
            ['section_code' => 'services', 'block_key' => 'price_regular', 'block_type' => 'price', 'title' => 'Стандартная консультация', 'subtitle' => '1 встреча — 55 минут', 'body' => 'Для новых клиентов первая встреча оплачивается заранее', 'meta' => ['price' => 3500, 'currency' => 'RUB'], 'sort_order' => 80],
            ['section_code' => 'services', 'block_key' => 'price_promo', 'block_type' => 'price', 'badge' => 'Акция', 'title' => 'Регулярная онлайн-терапия', 'subtitle' => '1 раз в неделю, 2 места', 'body' => 'Цена фиксируется на год. Подойдёт тем, кто настроен на длительную работу.', 'meta' => ['price' => 2000, 'currency' => 'RUB', 'left_places' => 2], 'sort_order' => 90],

            // Pricing — консультации
            ['section_code' => 'pricing', 'block_key' => 'heading', 'block_type' => 'text',
                'badge' => 'Консультации', 'title' => 'Форматы', 'subtitle' => 'и стоимость', 'sort_order' => 10],

            ['section_code' => 'pricing', 'block_key' => 'consult_1', 'block_type' => 'consult',
                'label' => 'video',
                'title' => 'Онлайн-консультация',
                'subtitle' => 'Из любой точки мира',
                'badge' => '3 500 руб.',
                'body' => "Работаю через Zoom, Telegram или WhatsApp.\nПродолжительность встречи — 55 минут.\nДля новых клиентов первая встреча оплачивается заранее.",
                'button_text' => 'Записаться',
                'button_url' => '#contacts',
                'sort_order' => 20,
                'meta' => ['desktop_span' => 'half', 'subtitle_icon' => 'globe']],

            ['section_code' => 'pricing', 'block_key' => 'consult_2', 'block_type' => 'consult',
                'label' => 'map-pin',
                'title' => 'Очная консультация',
                'subtitle' => 'Владивосток, Артём',
                'badge' => '3 500 руб.',
                'body' => "Принимаю очно во Владивостоке и Артёме.\nПродолжительность встречи — 55 минут.\nАдрес и точное место — по договорённости.",
                'button_text' => 'Записаться',
                'button_url' => '#contacts',
                'sort_order' => 30,
                'meta' => ['desktop_span' => 'half', 'subtitle_icon' => 'map-pin']],

            ['section_code' => 'pricing', 'block_key' => 'promo_1', 'block_type' => 'promo',
                'badge' => 'Акция',
                'title' => 'Регулярная онлайн-терапия',
                'subtitle' => '2 000 руб./сессию',
                'body' => 'Цена фиксируется на год. Подойдёт тем, кто настроен на длительную работу и нуждается в более доступной стоимости.',
                'button_text' => '1 раз в неделю · осталось 2 места',
                'sort_order' => 40],

            // Education
            ['section_code' => 'education', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Образование', 'title' => 'Опыт и', 'subtitle' => 'образование', 'sort_order' => 10],
            ['section_code' => 'education', 'block_key' => 'edu_1', 'block_type' => 'card',
                'label' => 'graduation-cap', 'badge' => 'Завершено', 'button_text' => 'amber',
                'title' => 'Авторская школа Интегральной Гуманистической Психотерапии',
                'subtitle' => 'Первый университет проф. В.В. Макарова',
                'sort_order' => 20],
            ['section_code' => 'education', 'block_key' => 'edu_2', 'block_type' => 'card',
                'label' => 'book-open', 'badge' => 'В процессе', 'button_text' => 'teal',
                'title' => 'Московский гештальт-институт',
                'subtitle' => 'Вторая ступень обучения',
                'sort_order' => 30],
            ['section_code' => 'education', 'block_key' => 'exp_1', 'block_type' => 'stat', 'label' => 'clock', 'title' => '12+', 'subtitle' => 'лет личной терапии', 'body' => 'с перерывами', 'sort_order' => 40],
            ['section_code' => 'education', 'block_key' => 'exp_2', 'block_type' => 'stat', 'label' => 'users', 'title' => '10', 'subtitle' => 'лет групповой терапии', 'body' => 'регулярное участие', 'sort_order' => 50],
            ['section_code' => 'education', 'block_key' => 'approach_1', 'block_type' => 'chip', 'title' => 'Гештальт-терапия', 'sort_order' => 60],
            ['section_code' => 'education', 'block_key' => 'approach_2', 'block_type' => 'chip', 'title' => 'Когнитивно-поведенческая терапия (КПТ)', 'sort_order' => 70],
            ['section_code' => 'education', 'block_key' => 'approach_3', 'block_type' => 'chip', 'title' => 'Трансактный анализ', 'sort_order' => 80],
            ['section_code' => 'education', 'block_key' => 'approach_4', 'block_type' => 'chip', 'title' => 'Процессуальная психология', 'sort_order' => 90],

            // Reviews
            ['section_code' => 'reviews', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Отзывы', 'title' => 'Что говорят', 'subtitle' => 'клиенты', 'body' => 'Отзывы опубликованы с разрешения клиентов, имена изменены для сохранения конфиденциальности', 'sort_order' => 10],
            ['section_code' => 'reviews', 'block_key' => 'review_1', 'block_type' => 'review', 'title' => 'Анна', 'subtitle' => '6 месяцев терапии', 'body' => 'Александр создаёт атмосферу безопасности и принятия. С первой встречи почувствовала, что могу быть собой. Работаем уже полгода, и многое изменилось в моём восприятии себя.', 'sort_order' => 20],
            ['section_code' => 'reviews', 'block_key' => 'review_2', 'block_type' => 'review', 'title' => 'Михаил', 'subtitle' => '8 месяцев терапии', 'body' => 'Очень ценю спокойный и внимательный подход. Александр не даёт готовых советов, а помогает самому разобраться в себе. Это именно то, что мне было нужно.', 'sort_order' => 30],
            ['section_code' => 'reviews', 'block_key' => 'review_3', 'block_type' => 'review', 'title' => 'Елена', 'subtitle' => '1 год терапии', 'body' => 'Обратилась в сложный период — выгорание и потеря смысла. Сейчас чувствую опору в себе, научилась замечать свои потребности. Благодарна за этот путь.', 'sort_order' => 40],

            // Blog
            ['section_code' => 'blog', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Блог', 'title' => 'Статьи и', 'subtitle' => 'заметки', 'sort_order' => 10],
            ['section_code' => 'blog', 'block_key' => 'cta_all', 'block_type' => 'cta', 'button_text' => 'Все статьи', 'button_url' => '#', 'sort_order' => 20],
            ['section_code' => 'blog', 'block_key' => 'article_1', 'block_type' => 'article', 'badge' => 'Терапия', 'title' => 'Что такое гештальт-терапия и как она работает', 'body' => 'Простым языком о том, что происходит в кабинете гештальт-терапевта и почему это помогает.', 'meta' => ['date' => '15 января 2024', 'readTime' => '5 мин'], 'sort_order' => 30],
            ['section_code' => 'blog', 'block_key' => 'article_2', 'block_type' => 'article', 'badge' => 'Советы', 'title' => 'Как понять, что вам нужен психолог', 'body' => 'Признаки того, что пора обратиться за помощью, и как выбрать подходящего специалиста.', 'meta' => ['date' => '8 января 2024', 'readTime' => '4 мин'], 'sort_order' => 40],
            ['section_code' => 'blog', 'block_key' => 'article_3', 'block_type' => 'article', 'badge' => 'Кризисы', 'title' => 'Кризис среднего возраста: миф или реальность', 'body' => 'Разбираемся в том, что происходит с нами в 35-45 лет и как пройти этот период.', 'meta' => ['date' => '20 декабря 2023', 'readTime' => '6 мин'], 'sort_order' => 50],

            // FAQ
            ['section_code' => 'faq', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'FAQ', 'title' => 'Частые', 'subtitle' => 'вопросы', 'body' => 'Ответы на вопросы, которые чаще всего задают перед началом терапии', 'sort_order' => 10],
            ['section_code' => 'faq', 'block_key' => 'faq_1', 'block_type' => 'faq', 'title' => 'Как проходит первая консультация?', 'body' => 'На первой встрече мы знакомимся, вы рассказываете о том, что вас привело. Я задаю уточняющие вопросы, чтобы лучше понять вашу ситуацию. Вместе решаем, подходим ли мы друг другу и хотим ли продолжить работу. Никаких обязательств — это возможность присмотреться.', 'sort_order' => 20],
            ['section_code' => 'faq', 'block_key' => 'faq_2', 'block_type' => 'faq', 'title' => 'Можно ли созвониться перед первой сессией?', 'body' => 'Да, я предлагаю бесплатный 15-минутный созвон для знакомства. Это возможность задать вопросы, понять, комфортно ли вам со мной, и решить, хотите ли вы записаться на полноценную консультацию.', 'sort_order' => 30],
            ['section_code' => 'faq', 'block_key' => 'faq_3', 'block_type' => 'faq', 'title' => 'Как часто нужно встречаться?', 'body' => 'Оптимальная частота — 1 раз в неделю. Это позволяет поддерживать непрерывность процесса и работать глубоко. Но мы всегда обсуждаем индивидуально — иногда встречаемся реже, особенно на завершающем этапе.', 'sort_order' => 40],
            ['section_code' => 'faq', 'block_key' => 'faq_4', 'block_type' => 'faq', 'title' => 'Сколько длится терапия?', 'body' => 'Зависит от запроса и глубины работы. Некоторые вопросы можно проработать за 5-10 встреч. Для более глубоких изменений обычно нужно от полугода до нескольких лет. Мы регулярно обсуждаем, как идёт процесс.', 'sort_order' => 50],
            ['section_code' => 'faq', 'block_key' => 'faq_5', 'block_type' => 'faq', 'title' => 'Чем отличается онлайн-формат от очного?', 'body' => 'По эффективности форматы сопоставимы. Онлайн удобнее логистически — не нужно тратить время на дорогу. Очный формат некоторым даёт ощущение большего присутствия. Выбирайте то, что комфортнее для вас.', 'sort_order' => 60],
            ['section_code' => 'faq', 'block_key' => 'faq_6', 'block_type' => 'faq', 'title' => 'Что делать, если я не знаю, с чем обратиться?', 'body' => 'Это нормально. Часто люди приходят с ощущением «что-то не так», без чёткого запроса. Вместе разберёмся, что для вас важно. Иногда сам процесс формулирования — это уже терапевтическая работа.', 'sort_order' => 70],
            ['section_code' => 'faq', 'block_key' => 'faq_7', 'block_type' => 'faq', 'title' => 'Как происходит оплата?', 'body' => 'Оплата производится перед сессией переводом на карту. Для новых клиентов первая встреча оплачивается заранее. Реквизиты для оплаты высылаю после записи.', 'sort_order' => 80],
            ['section_code' => 'faq', 'block_key' => 'faq_8', 'block_type' => 'faq', 'title' => 'Можно ли отменить или перенести сессию?', 'body' => 'Да, при уведомлении не менее чем за 24 часа. При отмене менее чем за сутки сессия оплачивается полностью. Это стандартная практика, которая помогает обоим сторонам относиться к процессу серьёзно.', 'sort_order' => 90],

            // Contacts
            ['section_code' => 'contacts', 'block_key' => 'heading', 'block_type' => 'text', 'badge' => 'Контакты', 'title' => 'Запишитесь на', 'subtitle' => 'консультацию', 'body' => 'Для записи или вопросов пишите в любой удобный мессенджер. Отвечаю в течение дня.', 'sort_order' => 10],
            ['section_code' => 'contacts', 'block_key' => 'free_call', 'block_type' => 'card', 'title' => 'Бесплатный созвон', 'subtitle' => '15 минут для знакомства', 'body' => 'Можно предварительно созвониться — просто познакомиться и понять, подходим ли мы друг другу. Это бесплатно и ни к чему не обязывает.', 'sort_order' => 20],
            ['section_code' => 'contacts', 'block_key' => 'cta_telegram', 'block_type' => 'cta', 'label' => 'send', 'button_text' => 'Telegram', 'button_url' => 'https://t.me/AlexanderP_V', 'sort_order' => 30],
            ['section_code' => 'contacts', 'block_key' => 'cta_whatsapp', 'block_type' => 'cta', 'label' => 'message-circle', 'button_text' => 'WhatsApp', 'button_url' => 'https://wa.me/79242521756', 'sort_order' => 40],
            ['section_code' => 'contacts', 'block_key' => 'cta_max', 'block_type' => 'cta', 'label' => 'message-square', 'button_text' => 'Max', 'button_url' => 'https://max.ru/u/f9LHodD0cOIZh45J-Dg2owlXzPWe-IUg2R7DDGo-yx1QdDAdLYK1SUWEHxM', 'sort_order' => 45],
            ['section_code' => 'contacts', 'block_key' => 'telegram_channel', 'block_type' => 'card', 'label' => 'newspaper', 'title' => 'Читайте обо мне в Telegram', 'subtitle' => 'Статьи, заметки и мысли о терапии и отношениях', 'button_text' => 'Открыть канал', 'button_url' => 'https://t.me/plotnikov_aleksander', 'sort_order' => 47],
            ['section_code' => 'contacts', 'block_key' => 'phone', 'block_type' => 'item', 'label' => 'phone', 'title' => '+7 924 252-17-56', 'button_url' => 'tel:+79242521756', 'sort_order' => 48],
            ['section_code' => 'contacts', 'block_key' => 'nickname', 'block_type' => 'text', 'label' => 'Ник в Telegram', 'title' => '@AlexanderP_V', 'sort_order' => 50],
            ['section_code' => 'contacts', 'block_key' => 'location', 'block_type' => 'card', 'label' => 'map-pin', 'title' => 'Очный приём', 'subtitle' => 'Владивосток, Артём', 'sort_order' => 60],

            // Footer
            ['section_code' => 'footer', 'block_key' => 'brand', 'block_type' => 'brand', 'title' => 'Александр', 'subtitle' => 'психолог', 'body' => 'Гештальт-терапевт. Помогаю находить опору и контакт с собой через доверие и живое человеческое присутствие.', 'sort_order' => 10],
            ['section_code' => 'footer', 'block_key' => 'copyright', 'block_type' => 'text', 'body' => 'Сделано с любовью во Владивостоке', 'sort_order' => 20],
        ];

        foreach ($blocks as $block) {
            LandingBlock::query()->updateOrCreate(
                [
                    'section_code' => $block['section_code'],
                    'block_key' => $block['block_key'],
                ],
                [
                    'block_type' => $block['block_type'] ?? 'item',
                    'label' => $block['label'] ?? null,
                    'badge' => $block['badge'] ?? null,
                    'title' => $block['title'] ?? null,
                    'subtitle' => $block['subtitle'] ?? null,
                    'body' => $block['body'] ?? null,
                    'button_text' => $block['button_text'] ?? null,
                    'button_url' => $block['button_url'] ?? null,
                    'sort_order' => $block['sort_order'] ?? 100,
                    'is_visible' => $block['is_visible'] ?? true,
                    'meta' => $block['meta'] ?? null,
                ],
            );
        }
    }
}

