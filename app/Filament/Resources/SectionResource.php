<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                    $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('title_es')
                ->label('Title (ES)')
                ->required(),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('description_en')->label('Description (EN)'),
            Forms\Components\Textarea::make('description_es')->label('Description (ES)'),
            Forms\Components\Select::make('section_layout')
                ->options([
                    'hero' => 'Hero',
                    'grid' => 'Grid',
                    'list' => 'List',
                    'sidebar' => 'Sidebar',
                ])
                ->required()
                ->default('list'),
            Forms\Components\TagsInput::make('categories')
                ->label('Category slugs')
                ->placeholder('Add category slug'),
            Forms\Components\TextInput::make('order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('title_en'),
                Tables\Columns\TextColumn::make('section_layout')->badge(),
                Tables\Columns\TextColumn::make('order')->sortable(),
            ])
            ->defaultSort('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
