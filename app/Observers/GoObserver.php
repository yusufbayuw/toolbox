<?php

namespace App\Observers;

use App\Models\Go;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GoObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Go "created" event.
     */
    public function created(Go $go): void
    {
        // Go's QrCode Handling
        if ($go->logo) {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->mergeString(Storage::disk('public')->get($go->logo), .25)
                    ->generate(config('base_urls.base_go') . '/' . $go->short_link);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Go::find($go->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        } else {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->generate(config('base_urls.base_go') . '/' . $go->short_link);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Go::find($go->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        }
    }

    /**
     * Handle the Go "updated" event.
     */
    public function updated(Go $go): void
    {
        // logo handling
        if ($go->isDirty('logo')) {
            if ($go->getOriginal('logo')) {
                if (Storage::disk('public')->exists($go->getOriginal('logo'))) {
                    Storage::disk('public')->delete($go->getOriginal('logo'));
                }
            }
        }

        // Go's QrCode Handling
        if ($go->qr_code_image) {
            if (Storage::disk('public')->exists($go->qr_code_image)) {
                Storage::disk('public')->delete($go->qr_code_image);
            }
        }
        if ($go->logo) {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->mergeString(Storage::disk('public')->get($go->logo), .25)
                    ->generate(config('base_urls.base_go') . '/' . $go->short_link);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Go::find($go->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        } else {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->generate(config('base_urls.base_go') . '/' . $go->short_link);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Go::find($go->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        }
    }

    /**
     * Handle the Go "deleted" event.
     */
    public function deleted(Go $go): void
    {
        // logo handling
        if ($go->logo) {
            if (Storage::disk('public')->exists($go->logo)) {
                Storage::disk('public')->delete($go->logo);
            }
        }

        // Go's QrCode Handling
        if ($go->qr_code_image) {
            if (Storage::disk('public')->exists($go->qr_code_image)) {
                Storage::disk('public')->delete($go->qr_code_image);
            }
        }
    }

    /**
     * Handle the Go "restored" event.
     */
    public function restored(Go $go): void
    {
        //
    }

    /**
     * Handle the Go "force deleted" event.
     */
    public function forceDeleted(Go $go): void
    {
        //
    }
}
