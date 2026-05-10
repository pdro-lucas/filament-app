<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                Step::make("Product Details")
                    ->description("Add basic product info")
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make("name")->rules(["required", "min:3"]),
                                TextInput::make("sku")->rules(["required", "min:3"]),
                            ])
                            ->columns(2),
                        MarkdownEditor::make("description")->rules(["required"]),
                    ]),
                Step::make("Price & Stock")
                    ->description("Set product price and stock")
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make("price")->rules(["required"]),
                                TextInput::make("stock")->rules(["required"]),
                            ])
                            ->columns(2),
                    ]),
                Step::make("Media & Status")
                    ->description("Upload image and set status")
                    ->schema([
                        FileUpload::make("image")->disk("public")->directory("products"),
                        Checkbox::make("is_acive"),
                        Checkbox::make("is_featured"),
                    ]),
            ])
                ->submitAction(Action::make("save")->label("Save Product")->button()->color("primary")->submit("save"))
                ->columnSpanFull(),
        ]);
    }
}
