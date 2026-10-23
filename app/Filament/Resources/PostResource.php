<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Support\ImageField;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Berita';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('author_name')
                    ->required()
                    ->maxLength(255)
                    ->default('Digital Agtech Indonesia Team'),

                Forms\Components\DateTimePicker::make('published_at'),

                Forms\Components\TextInput::make('excerpt')
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('English Translation')->schema([
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->maxLength(255),

                Forms\Components\TextInput::make('excerpt_en')
                    ->label('Excerpt (EN)')
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('body_en')
                    ->label('Body (EN)')
                    ->columnSpanFull(),
            ])->columns(2)->collapsed(),

            Forms\Components\Section::make('Thumbnail')->schema(
                ImageField::make('thumbnail', 'Thumbnail', 'news')
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->getStateUsing(fn ($record) => \App\Filament\Support\ImageField::resolveUrl($record->thumbnail))
                    ->extraImgAttributes(['style' => 'object-fit:cover']),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('author_name')->searchable(),
                Tables\Columns\TextColumn::make('published_at')->date('d M Y')->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('published')
                    ->query(fn ($query) => $query->whereNotNull('published_at')),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
