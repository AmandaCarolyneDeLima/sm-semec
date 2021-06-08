<?php

namespace Tests\Unit\Pdfs;

use Tests\TestCase;
use App\Models\Pdf;
use App\Models\Edict;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadPdf extends TestCase
{
    /** @var \App\Models\Pdf */
    protected $pdf;

    public function setUp(): void
    {
        parent::setUp();
        $this->pdf = Pdf::factory()->make([
        'pdf' => UploadedFile::fake()->create('document.pdf', 'application/pdf')]);
    }

    public function tearDown(): void
    {
        $this->pdf->delete();
    }

    public function testPathToFile(): void
    {
         $this->pdf->pdf = UploadedFile::fake()->create('document.pdf');
         $this->pdf->save();

         $this->assertEquals($this->pdf->pathToFile(), $this->fullPdfPath());
    }

    public function testAddFileAfterCreatingEdict(): void
    {
        $this->pdf->pdf = UploadedFile::fake()->create('document.pdf');
        $this->pdf->save();

        $this->assertEquals($this->pdfName(), $this->pdf->pdf);
        $this->assertFileExists($this->fullPdfPath());
    }

    public function testWhenDeleteEdictShouldDeleteThePdf(): void
    {
        $this->pdf->pdf = UploadedFile::fake()->create('document.pdf');
        $this->pdf->save();

        $previousFullImagePath = $this->fullPdfPath();
        $this->pdf->edict->delete();
        $this->assertFileDoesNotExist($previousFullImagePath);
    }

    private function pdfName(): string
    {
        return Str::slug($this->pdf->edict_id . '-' . $this->pdf->name . '-' . now()->toShortDateTime(), '-') .  '.pdf';
    }

    private function pdfPath(): string
    {
        return '/uploads/edicts/' . $this->pdf->edict_id . '/' . $this->pdfName();
    }

    private function fullPdfPath(): string
    {
        return public_path($this->pdfPath());
    }
}
