<?php

namespace App\Filament\Resources\Supplier;

use App\Filament\Resources\Supplier\SupplierDocumentResource\Pages;
use App\Models\SupplierDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\FileUpload;

class SupplierDocumentResource extends Resource
{
    protected static ?string $model = SupplierDocument::class;

    protected static ?string $slug = 'verification-documents';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Verification Documents';

    protected static ?string $navigationGroup = 'Account';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Document Information')
                    ->schema([
                        Forms\Components\Select::make('document_type')
                            ->label('نوع الوثيقة')
                            ->options([
                                'commercial_register' => 'سجل تجاري',
                                'tax_card' => 'بطاقة ضريبية',
                                'id_card' => 'مستند هوية الممثل القانوني',
                            ])
                            ->required()
                            ->native(false)
                            ->helperText('اختر نوع الوثيقة التي تريد رفعها'),
                        FileUpload::make('document_file')
                            ->label('الوثيقة')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(5120) // 5MB
                            ->required()
                            ->disk('public')
                            ->directory('supplier-documents')
                            ->visibility('private')
                            ->helperText('يمكن رفع ملف PDF أو صورة (JPG, PNG). الحد الأقصى: 5MB')
                            ->downloadable()
                            ->openable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_type')
                    ->label('نوع الوثيقة')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'commercial_register' => 'سجل تجاري',
                        'tax_card' => 'بطاقة ضريبية',
                        'id_card' => 'مستند هوية',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_file')
                    ->label('الوثيقة')
                    ->formatStateUsing(fn ($record) => $record && $record->getFirstMediaUrl('document') ? 'تم الرفع' : 'غير موجود')
                    ->icon(fn ($record) => $record && $record->getFirstMediaUrl('document') ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn ($record) => $record && $record->getFirstMediaUrl('document') ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد المراجعة',
                        'approved' => 'موافق عليه',
                        'rejected' => 'مرفوض',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('rejection_reason')
                    ->label('سبب الرفض')
                    ->limit(50)
                    ->toggleable()
                    ->visible(fn ($record) => $record && $record->status === 'rejected'),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('تاريخ الموافقة')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الرفع')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'approved' => 'موافق عليه',
                        'rejected' => 'مرفوض',
                    ])
                    ->native(false),
                Tables\Filters\SelectFilter::make('document_type')
                    ->label('نوع الوثيقة')
                    ->options([
                        'commercial_register' => 'سجل تجاري',
                        'tax_card' => 'بطاقة ضريبية',
                        'id_card' => 'مستند هوية',
                    ])
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => $record && ($record->status === 'pending' || $record->status === 'rejected')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => $record && ($record->status === 'pending' || $record->status === 'rejected')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $supplierId = $user && $user->supplier ? $user->supplier->id : 0;
        return parent::getEloquentQuery()
            ->where('supplier_id', $supplierId);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplierDocuments::route('/'),
            'create' => Pages\CreateSupplierDocument::route('/create'),
            'view' => Pages\ViewSupplierDocument::route('/{record}'),
            'edit' => Pages\EditSupplierDocument::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->isSupplier();
    }
}
