<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Models\Article;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction as TableDeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction as TableEditAction;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static UnitEnum|string|null $navigationGroup = 'Блог';
    protected static ?string $navigationLabel = 'Статьи';
    protected static ?string $modelLabel = 'Статья';
    protected static ?string $pluralModelLabel = 'Статьи';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Основное')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, string $state, callable $set): void {
                            if ($operation === 'create') {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }
                        })
                        ->columnSpanFull(),

                    TextInput::make('slug')
                        ->label('URL-slug')
                        ->required()
                        ->unique(Article::class, 'slug', ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Часть адреса: /blog/slug')
                        ->prefix('/blog/'),

                    TextInput::make('category')
                        ->label('Категория')
                        ->placeholder('Терапия')
                        ->maxLength(100),

                    TextInput::make('read_time')
                        ->label('Время чтения')
                        ->placeholder('5 мин')
                        ->maxLength(50),

                    Textarea::make('excerpt')
                        ->label('Краткое описание')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Показывается на главной и в списке статей')
                        ->columnSpanFull(),
                ]),

            Section::make('Обложка')
                ->schema([
                    FileUpload::make('cover_image')
                        ->label('Фото обложки')
                        ->image()
                        ->directory('articles')
                        ->imagePreviewHeight('200')
                        ->helperText('Рекомендуемый размер: 1200×630 px'),
                ]),

            Section::make('Содержимое статьи')
                ->schema([
                    RichEditor::make('content')
                        ->label('Текст статьи')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('articles/attachments')
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->columnSpanFull(),
                ]),

            Section::make('Публикация')
                ->columns(2)
                ->schema([
                    Toggle::make('is_published')
                        ->label('Опубликовать')
                        ->default(false)
                        ->live()
                        ->afterStateUpdated(function (bool $state, callable $set): void {
                            if ($state) {
                                $set('published_at', now()->toDateTimeString());
                            }
                        }),

                    DateTimePicker::make('published_at')
                        ->label('Дата публикации')
                        ->nullable()
                        ->seconds(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->limit(60),

                TextColumn::make('category')
                    ->label('Категория')
                    ->badge()
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Опубликована')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([])
            ->actions([
                TableEditAction::make(),
                TableDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'edit'   => EditArticle::route('/{record}/edit'),
        ];
    }
}
