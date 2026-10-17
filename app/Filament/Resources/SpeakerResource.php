<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpeakerResource\Pages;
use App\Filament\Support\ImageField;
use App\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SpeakerResource extends Resource
{
    protected static ?string $model = Speaker::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. CEO, Agri-Fintech Startup'),

                Forms\Components\TextInput::make('expertise')
                    ->maxLength(255)
                    ->placeholder('e.g. AgriTech, Sustainable Farming'),

                Forms\Components\Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('linkedin_url')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make('instagram_url')
                    ->url()
                    ->maxLength(255),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Toggle::make('is_featured')
                        ->default(false),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                ]),
            ])->columns(2),

            Forms\Components\Section::make('Photo')->schema(
                ImageField::make('photo', 'Photo', 'speakers')
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->getStateUsing(fn ($record) => \App\Filament\Support\ImageField::resolveUrl($record->photo))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('expertise')->searchable()->limit(40),
                Tables\Columns\IconColumn::make('is_featured')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSpeakers::route('/'),
            'create' => Pages\CreateSpeaker::route('/create'),
            'edit'   => Pages\EditSpeaker::route('/{record}/edit'),
        ];
    }
}
