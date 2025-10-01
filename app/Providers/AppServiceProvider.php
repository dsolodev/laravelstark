<?php

declare(strict_types = 1);

namespace App\Providers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentTimezone;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

final class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
        FilamentTimezone::set(config('app.timezone'));
        LogViewer::auth(
            fn(Request $request): bool => $request->user() && $request->user()->email = 'me@dsolo.dev'
        );
        FilamentIcon::register([
            'actions::action-group'        => 'fal-ellipsis-vertical',
            'actions::edit-action'         => 'fal-pen-to-square',
            'actions::edit-action.grouped' => 'fal-pen-to-square',
        ]);
        Notifications::verticalAlignment(VerticalAlignment::End);
        TextInput::configureUsing(fn(TextInput $component): TextInput => $component->columnSpanFull());
        Select::configureUsing(fn(Select $component): Select => $component->columnSpanFull());
    }

    public function register(): void
    {
        parent::register();

        FilamentView::registerRenderHook(
            'panels::body.end',
            fn(): string => Blade::render("@vite('resources/js/app.js')")
        );
    }
}
