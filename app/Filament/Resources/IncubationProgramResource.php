<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncubationProgramResource\Pages;
use App\Models\IncubationProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class IncubationProgramResource extends Resource
{
    protected static ?string $model = IncubationProgram::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Inkubasi';
    protected static ?string $navigationGroup = 'Program';
    protected static ?int $navigationSort = 7;

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

                Forms\Components\TextInput::make('batch')->maxLength(255),
                Forms\Components\TextInput::make('year')->numeric(),
                Forms\Components\Toggle::make('is_active')->default(true),

                Forms\Components\RichEditor::make('description')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('English Translation')->schema([
                Forms\Components\TextInput::make('name_en')
                    ->label('Name (EN)')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('description_en')
                    ->label('Description (EN)')
                    ->columnSpanFull(),
            ])->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('batch')->searchable(),
                Tables\Columns\TextColumn::make('year')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListIncubationPrograms::route('/'),
            'create' => Pages\CreateIncubationProgram::route('/create'),
            'edit'   => Pages\EditIncubationProgram::route('/{record}/edit'),
        ];
    }
}
