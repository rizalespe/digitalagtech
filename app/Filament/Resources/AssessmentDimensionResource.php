<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssessmentDimensionResource\Pages;
use App\Models\AssessmentDimension;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AssessmentDimensionResource extends Resource
{
    protected static ?string $model = AssessmentDimension::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Assessment';
    protected static ?string $navigationGroup = 'Program';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dimension')->schema([
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

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),

            Forms\Components\Section::make('English Translation')->schema([
                Forms\Components\TextInput::make('name_en')
                    ->label('Name (EN)')
                    ->maxLength(255),

                Forms\Components\Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2)->collapsed(),

            Forms\Components\Section::make('Questions')->schema([
                Forms\Components\Repeater::make('questions')
                    ->relationship()
                    ->schema([
                        Forms\Components\Textarea::make('question')
                            ->required()
                            ->rows(2)
                            ->label('Question (ID)')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('question_en')
                            ->rows(2)
                            ->label('Question (EN)')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')->default(true),
                        Forms\Components\TextInput::make('sort_order')->numeric()->default(0),

                        Forms\Components\Repeater::make('options')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Label (ID)'),

                                Forms\Components\TextInput::make('label_en')
                                    ->maxLength(255)
                                    ->label('Label (EN)'),

                                Forms\Components\Textarea::make('text')
                                    ->rows(2)
                                    ->label('Description (ID)')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('text_en')
                                    ->rows(2)
                                    ->label('Description (EN)')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('score')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                            ])
                            ->columns(2)
                            ->label('Options')
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add Option'),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Add Question')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('questions_count')
                    ->counts('questions')
                    ->label('Questions'),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAssessmentDimensions::route('/'),
            'create' => Pages\CreateAssessmentDimension::route('/create'),
            'edit'   => Pages\EditAssessmentDimension::route('/{record}/edit'),
        ];
    }
}
