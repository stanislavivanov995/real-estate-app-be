<?php

namespace App\Observers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Support\Facades\File;


class EstateObserver
{
    /**
     * Handle the Estate "created" event.
     */
    public function created(Estate $estate): void
    {
        //
    }

    /**
     * Handle the Estate "updated" event.
     */
    public function updated(Estate $estate): void
    {
        //
    }

    /**
     * Handle the Estate "deleted" event.
     */
    public function deleted(Estate $estate): void
    {
        $files = $estate->images;

        if ($files) {
            foreach ($files as $file) {
                Image::find($file->id)->delete();
            }
        }
    }

    /**
     * Handle the Estate "restored" event.
     */
    public function restored(Estate $estate): void
    {
        //
    }

    /**
     * Handle the Estate "force deleted" event.
     */
    public function forceDeleted(Estate $estate): void
    {
        //
    }
}
