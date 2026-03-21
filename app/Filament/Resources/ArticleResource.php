<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('English Content')->schema([
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                        $set('slug', Str::slug($state))),
                Forms\Components\Textarea::make('summary_en')
                    ->label('Summary (EN)')
                    ->rows(3),
                Forms\Components\RichEditor::make('body_en')
                    ->label('Body (EN)')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Spanish Content')->schema([
                Forms\Components\TextInput::make('title_es')
                    ->label('Title (ES)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('summary_es')
                    ->label('Summary (ES)')
                    ->rows(3),
                Forms\Components\RichEditor::make('body_es')
                    ->label('Body (ES)')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Details')->schema([
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title_en')
                    ->required(),
                Forms\Components\Select::make('section_id')
                    ->label('Section')
                    ->relationship('section', 'title_en')
                    ->placeholder('Use category default')
                    ->nullable(),
                Forms\Components\TextInput::make('author')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('image')
                    ->label('Image URL')
                    ->url()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('featured'),
                Forms\Components\TextInput::make('priority')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.title_en')->label('Category')->sortable(),
                Tables\Columns\TextColumn::make('author')->searchable(),
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\TextColumn::make('priority')->sortable(),
            ])
            ->defaultSort('priority', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'title_en'),
            ])
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
