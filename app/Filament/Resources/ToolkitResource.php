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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
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
                Forms\Components\TextInput::make('tools_count')->numeric()->default(0)->label('Tools Count'),
                Forms\Components\TextInput::make('activities_count')->numeric()->default(0)->label('Activities Count'),
                Forms\Components\TextInput::make('duration_label')->maxLength(50)->placeholder('e.g. 2–3 Hours'),
                Forms\Components\Toggle::make('is_active')->default(true)->columnSpanFull(),

                Forms\Components\Textarea::make('description')->rows(3)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Thumbnail')->schema(
                ImageField::make('thumbnail', 'Thumbnail', 'toolkits')
            ),

            Forms\Components\Section::make('Video')->schema([
                Forms\Components\TextInput::make('video_url')
                    ->label('Video URL')
                    ->helperText('Paste a YouTube or Vimeo URL. Leave empty if no video.')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('PDF Download')->schema([
                Forms\Components\Placeholder::make('pdf_current')
                    ->label('Current PDF')
                    ->content(fn ($record) => $record?->pdf_path
                        ? new HtmlString(
                            '<a href="'.Storage::disk('public')->url($record->pdf_path).'" target="_blank" rel="noopener" '
                            .'style="color:#4f46e5;text-decoration:underline">'.basename($record->pdf_path).'</a>'
                        )
                        : new HtmlString('<span style="color:#888">No PDF uploaded yet</span>'))
                    ->visibleOn('edit')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('pdf_path')
                    ->label('Upload PDF')
                    ->helperText('Leave empty to keep the current file. Accepted: .pdf')
                    ->disk('public')
                    ->directory('toolkits/pdf')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480)
                    ->columnSpanFull()
                    ->dehydrated(fn ($state) => filled($state))
                    ->afterStateHydrated(fn (Forms\Components\FileUpload $component) =>
                        $component->state(null)),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->getStateUsing(fn ($record) => \App\Filament\Support\ImageField::resolveUrl($record->thumbnail)),
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
