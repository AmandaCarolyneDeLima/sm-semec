<?php

namespace App\Observers;

use App\Models\Edict;
use App\Models\Pdf;
use File;

class EdictObserver
{
    /**
    * Handle the edict "deleted" event.
    *
    * @param  \App\Models\Edict  $edict
    * @return void
    */
    public function deleted(Edict $edict)
    {
        $this->deletePdfFile($edict);
    }

    /**
    * Delete a pdf from file.
    *
    * @param  \App\Models\Edict  $edict
    * @return void
    */
    private function deletePdfFile($edict)
    {
        $pdfDirectory = public_path('uploads/edicts/' . $edict->id);
        File::deleteDirectory($pdfDirectory);
    }
}
