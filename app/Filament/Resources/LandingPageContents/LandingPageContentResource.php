<?php

namespace App\Filament\Resources\LandingPageContents;

use App\Filament\Resources\LandingPageContents\Pages\ManageLandingPageContents;
use App\Models\LandingPageContent;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class LandingPageContentResource extends Resource
{
    protected static ?string $model = LandingPageContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Редактирование контента';
    protected static ?string $navigationLabel = 'SEO и настройки';
    protected static ?string $modelLabel = 'SEO и настройки';
    protected static ?string $pluralModelLabel = 'SEO и настройки';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('content_tabs')
                    ->tabs([
                        Tab::make('Контент')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('hero_badge')
                                    ->label('Бейдж в хиро-секции')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('hero_title')
                                    ->label('Главный заголовок')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('hero_description')
                                    ->label('Описание в хиро-секции')
                                    ->required()
                                    ->rows(4),
                                TextInput::make('h1_text')
                                    ->label('H1 (если хотите переопределить)')
                                    ->helperText('Если пусто — будет использован hero_title')
                                    ->maxLength(255),
                                TextInput::make('contact_handle')
                                    ->label('Никнейм')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('telegram_url')
                                    ->label('Ссылка Telegram')
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('whatsapp_url')
                                    ->label('Ссылка WhatsApp')
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('location_text')
                                    ->label('Локация')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('seo_title')
                                    ->label('SEO title (до 60 символов)')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Появляется в выдаче и в табе браузера. Оптимально 50–60 символов.'),
                                Textarea::make('seo_description')
                                    ->label('SEO description (до 160 символов)')
                                    ->required()
                                    ->rows(3)
                                    ->helperText('Краткое описание для поисковиков. Оптимально 140–160 символов.'),
                                TextInput::make('seo_keywords')
                                    ->label('SEO keywords (через запятую)')
                                    ->maxLength(500),
                                TextInput::make('canonical_url')
                                    ->label('Canonical URL')
                                    ->url()
                                    ->placeholder('https://plotnikov-al-psy.online')
                                    ->helperText('Если пусто — берётся текущий URL'),
                                Select::make('robots')
                                    ->label('Robots')
                                    ->options([
                                        'index,follow' => 'index, follow (по умолчанию)',
                                        'index,nofollow' => 'index, nofollow',
                                        'noindex,follow' => 'noindex, follow',
                                        'noindex,nofollow' => 'noindex, nofollow',
                                    ])
                                    ->default('index,follow')
                                    ->required(),
                                FileUpload::make('og_image_path')
                                    ->label('OG image (для соцсетей, 1200×630)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->maxSize(4096)
                                    ->helperText('Если изображение есть — будет использовано в og:image и twitter:image. Иначе используется фото из hero.'),
                                TextInput::make('og_image_url')
                                    ->label('Внешний URL OG image (приоритет ниже загруженного файла)')
                                    ->url()
                                    ->maxLength(500),
                                FileUpload::make('favicon_path')
                                    ->label('Favicon (32×32 .png/.ico)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/svg+xml', 'image/vnd.microsoft.icon']),
                                FileUpload::make('apple_touch_icon_path')
                                    ->label('Apple touch icon (180×180 .png)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('seo')
                                    ->acceptedFileTypes(['image/png']),
                            ]),

                        Tab::make('Person (Schema.org)')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('person_name')
                                        ->label('Короткое имя')
                                        ->placeholder('Александр')
                                        ->maxLength(255),
                                    TextInput::make('person_full_name')
                                        ->label('Полное имя')
                                        ->placeholder('Александр П Психолог')
                                        ->maxLength(255),
                                ]),
                                TextInput::make('person_job_title')
                                    ->label('Должность / профессия')
                                    ->placeholder('Психолог, гештальт-терапевт')
                                    ->maxLength(255),
                                Textarea::make('person_bio')
                                    ->label('Краткое био')
                                    ->rows(3),
                                TextInput::make('person_image_url')
                                    ->label('URL фото для Person')
                                    ->url()
                                    ->maxLength(500),
                                Grid::make(2)->schema([
                                    TextInput::make('person_phone')
                                        ->label('Телефон')
                                        ->tel(),
                                    TextInput::make('person_email')
                                        ->label('Email')
                                        ->email(),
                                ]),
                            ]),

                        Tab::make('Адрес и часы')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('address_locality')
                                        ->label('Город')
                                        ->placeholder('Владивосток'),
                                    TextInput::make('address_region')
                                        ->label('Регион')
                                        ->placeholder('Приморский край'),
                                ]),
                                Grid::make(2)->schema([
                                    TextInput::make('address_country')
                                        ->label('Код страны (ISO)')
                                        ->default('RU')
                                        ->maxLength(2),
                                    TextInput::make('address_postal')
                                        ->label('Индекс')
                                        ->maxLength(20),
                                ]),
                                TextInput::make('address_street')
                                    ->label('Улица, дом')
                                    ->maxLength(255),
                                Grid::make(2)->schema([
                                    TextInput::make('geo_lat')
                                        ->label('Широта')
                                        ->numeric()
                                        ->step('0.0000001'),
                                    TextInput::make('geo_lng')
                                        ->label('Долгота')
                                        ->numeric()
                                        ->step('0.0000001'),
                                ]),
                                TextInput::make('opening_hours')
                                    ->label('Часы работы')
                                    ->placeholder('Mo-Fr 09:00-21:00')
                                    ->helperText('Формат Schema.org: Mo-Fr 09:00-21:00')
                                    ->maxLength(255),
                                TextInput::make('price_range')
                                    ->label('Ценовой диапазон')
                                    ->default('₽₽')
                                    ->placeholder('₽₽')
                                    ->maxLength(10),
                            ]),

                        Tab::make('Цены / Услуги')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('price_regular')
                                        ->label('Стандартная цена (₽)')
                                        ->numeric()
                                        ->placeholder('3500'),
                                    TextInput::make('price_promo')
                                        ->label('Промо-цена (₽)')
                                        ->numeric()
                                        ->placeholder('2000'),
                                    TextInput::make('price_currency')
                                        ->label('Валюта')
                                        ->default('RUB')
                                        ->maxLength(3),
                                ]),
                                Grid::make(2)->schema([
                                    TextInput::make('aggregate_rating_value')
                                        ->label('Средний рейтинг (1–5)')
                                        ->numeric()
                                        ->step('0.01')
                                        ->minValue(1)
                                        ->maxValue(5),
                                    TextInput::make('aggregate_rating_count')
                                        ->label('Количество отзывов')
                                        ->numeric()
                                        ->minValue(0),
                                ]),
                            ]),

                        Tab::make('Аналитика')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                TextInput::make('yandex_metrika_id')
                                    ->label('Яндекс.Метрика — Counter ID')
                                    ->placeholder('12345678')
                                    ->maxLength(50),
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics 4 — Measurement ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->maxLength(50),
                                TextInput::make('google_tag_manager_id')
                                    ->label('Google Tag Manager — Container ID')
                                    ->placeholder('GTM-XXXXXXX')
                                    ->maxLength(50),
                                TextInput::make('yandex_verification')
                                    ->label('Yandex Webmaster — verification meta')
                                    ->maxLength(255),
                                TextInput::make('google_site_verification')
                                    ->label('Google Search Console — verification meta')
                                    ->maxLength(255),
                                TextInput::make('bing_site_verification')
                                    ->label('Bing — verification meta')
                                    ->maxLength(255),
                            ]),

                        Tab::make('Соцсети')
                            ->icon('heroicon-o-share')
                            ->schema([
                                TextInput::make('vk_url')
                                    ->label('ВКонтакте URL')
                                    ->url(),
                                TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->url(),
                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url(),
                            ]),
                        Tab::make('Видимость секций')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Select::make('default_theme')
                                    ->label('Тема по умолчанию')
                                    ->options([
                                        'warm' => 'Тёплая (warm)',
                                        'dark' => 'Тёмная (dark)',
                                    ])
                                    ->default('warm')
                                    ->required()
                                    ->helperText('Используется для новых посетителей. Если у пользователя уже сохранена тема в браузере (localStorage), она имеет приоритет.'),
                                Toggle::make('show_header')->label('Показывать Header')->default(true),
                                Toggle::make('show_hero')->label('Показывать Hero')->default(true),
                                Toggle::make('show_about')->label('Показывать About')->default(true),
                                Toggle::make('show_services')->label('Показывать Services')->default(true),
                                Toggle::make('show_education')->label('Показывать Education')->default(true),
                                Toggle::make('show_reviews')->label('Показывать Reviews')->default(true),
                                Toggle::make('show_blog')->label('Показывать Blog')->default(true),
                                Toggle::make('show_faq')->label('Показывать FAQ')->default(true),
                                Toggle::make('show_contacts')->label('Показывать Contacts')->default(true),
                                Toggle::make('show_footer')->label('Показывать Footer')->default(true),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hero_title')
                    ->label('Заголовок')
                    ->searchable(),
                TextColumn::make('contact_handle')
                    ->label('Никнейм'),
                TextColumn::make('seo_title')
                    ->label('SEO title')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->visible(fn () => LandingPageContent::count() > 1),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLandingPageContents::route('/'),
        ];
    }
}
