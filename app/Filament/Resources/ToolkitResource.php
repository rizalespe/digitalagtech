<?php

namespace App\Filament\Resources;

use App\Enums\ToolkitStage;
use App\Filament\Resources\ToolkitResource\Pages;
use App\Filament\Support\ImageField;
use App\Models\Toolkit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ToolkitResource extends Resource
{
    protected static ?string $model = Toolkit::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Toolkit';
    protected static ?string $navigationGroup = 'Program';
    protected static ?int $navigationSort = 8;

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

                Forms\Components\Select::make('stage')
                    ->required()
                    ->options(collect(ToolkitStage::cases())->mapWithKeys(
                        fn ($s) => [$s->value => $s->label()]
                    )),

                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),

                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Cover')->schema(
                ImageField::make('cover', 'Cover', 'toolkits')
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->getStateUsing(fn ($record) => \App\Filament\Support\ImageField::resolveUrl($record->cover)),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(50),
                Tables\Columns\BadgeColumn::make('stage')
                    ->colors(['warning' => 'discover', 'primary' => 'build', 'success' => 'scale']),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('stage')->options(
                    collect(ToolkitStage::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])
                ),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListToolkits::route('/'),
            'create' => Pages\CreateToolkit::route('/create'),
            'edit'   => Pages\EditToolkit::route('/{record}/edit'),
        ];
    }
}
