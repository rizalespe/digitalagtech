<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Support\ImageField;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Event Info')->schema([
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

                Forms\Components\Select::make('type')
                    ->required()
                    ->options(collect(EventType::cases())->mapWithKeys(
                        fn ($e) => [$e->value => $e->label()]
                    )),

                Forms\Components\TextInput::make('summary')
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Schedule & Location')->schema([
                Forms\Components\DateTimePicker::make('starts_at')->required(),
                Forms\Components\DateTimePicker::make('ends_at'),
                Forms\Components\TextInput::make('location')->maxLength(255),
                Forms\Components\TextInput::make('city')->maxLength(255),
                Forms\Components\Toggle::make('is_online')->default(false),
                Forms\Components\TextInput::make('meeting_url')->url()->maxLength(255),
                Forms\Components\TagsInput::make('workshop_cities')
                    ->placeholder('Tambah kota')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Registration & Visibility')->schema([
                Forms\Components\TextInput::make('quota')->numeric(),
                Forms\Components\Toggle::make('is_featured')->default(false),
                Forms\Components\Toggle::make('registration_open')->default(true),
                Forms\Components\DateTimePicker::make('published_at'),
            ])->columns(2),

            Forms\Components\Section::make('Media')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Fieldset::make('Thumbnail')->schema(
                        ImageField::make('thumbnail', 'Thumbnail', 'events')
                    ),
                    Forms\Components\Fieldset::make('Flyer')->schema(
                        ImageField::make('flyer', 'Flyer', 'events')
                    ),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->getStateUsing(fn ($record) => \App\Filament\Support\ImageField::resolveUrl($record->thumbnail)),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(40),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors(['primary' => 'webinar', 'success' => 'workshop']),
                Tables\Columns\TextColumn::make('starts_at')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('city')->searchable(),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\IconColumn::make('registration_open')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->date('d M Y')->sortable(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(
                    collect(EventType::cases())->mapWithKeys(fn ($e) => [$e->value => $e->label()])
                ),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
                Tables\Filters\TernaryFilter::make('registration_open')->label('Registration open'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
