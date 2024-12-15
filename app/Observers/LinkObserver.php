<?php

namespace App\Observers;

use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LinkObserver
{
    /**
     * Handle the Link "created" event.
     */
    public function created(Link $link): void
    {
        // Link's QrCode Handling
        if ($link->logo) {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->mergeString(Storage::disk('public')->get($link->logo), .25)
                    ->generate(config('base_urls.base_link') . '/' . $link->url_slug);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Link::find($link->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        } else {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->generate(config('base_urls.base_link') . '/' . $link->url_slug);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Link::find($link->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        }
    }

    /**
     * Handle the Link "updated" event.
     */
    public function updated(Link $link): void
    {
        // logo handling
        if ($link->isDirty('logo')) {
            if ($link->getOriginal('logo')) {
                if (Storage::disk('public')->exists($link->getOriginal('logo'))) {
                    Storage::disk('public')->delete($link->getOriginal('logo'));
                }
            }
        }

        // Link's QrCode Handling
        if ($link->qr_code_image) {
            if (Storage::disk('public')->exists($link->qr_code_image)) {
                Storage::disk('public')->delete($link->qr_code_image);
            }
        }
        if ($link->logo) {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->mergeString(Storage::disk('public')->get($link->logo), .25)
                    ->generate(config('base_urls.base_link') . '/' . $link->url_slug);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Link::find($link->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        } else {
            $type = 'png';
            $uuid = (Str::uuid()->toString()) . '.' . $type;
            $qr = QrCode::size(500)
                    ->format($type)
                    ->generate(config('base_urls.base_link') . '/' . $link->url_slug);
            Storage::disk('public')
                ->put($uuid, $qr);
            $image = Link::find($link->id);
            $image->qr_code_image = $uuid;
            $image->saveQuietly();
        }
    }

    /**
     * Handle the Link "deleted" event.
     */
    public function deleted(Link $link): void
    {
        // logo handling
        if ($link->logo) {
            if (Storage::disk('public')->exists($link->logo)) {
                Storage::disk('public')->delete($link->logo);
            }
        }

        // Link's QrCode Handling
        if ($link->qr_code_image) {
            if (Storage::disk('public')->exists($link->qr_code_image)) {
                Storage::disk('public')->delete($link->qr_code_image);
            }
        }
    }

    /**
     * Handle the Link "restored" event.
     */
    public function restored(Link $link): void
    {
        //
    }

    /**
     * Handle the Link "force deleted" event.
     */
    public function forceDeleted(Link $link): void
    {
        //
    }
}
