<?php

namespace Tests\Unit\Servants;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Models\Servant;
use File;

class ServantImageProfileTest extends TestCase
{
    /** @var \App\Models\Servant */
    protected $servant;

    public function setUp(): void
    {
        parent::setUp();
        $this->servant = Servant::factory()->create();
    }

    public function down(): void
    {
        $this->servant->delete();
    }

    public function testCreateNoImage(): void
    {
        $this->assertNull($this->servant->image);
        $this->assertEquals($this->defaultImage(), $this->servant->image_path);
    }

    public function testUpdateUserWithNewImageWhenImageIsNull(): void
    {
        $this->servant->image = UploadedFile::fake()->image('avatar.png');
        $this->servant->save();

        $this->assertEquals($this->imageName(), $this->servant->image);
        $this->assertEquals($this->imagePath(), $this->servant->image_path);
        $this->assertFileExists($this->fullImagePath());
    }

    public function testUpdateNoImage(): void
    {
        $this->servant->save();

        $this->assertNull($this->servant->image);
        $this->assertEquals($this->defaultImage(), $this->servant->image_path);
    }

    public function testUpdateUserNoImageWhenImageIsPresent(): void
    {
        $this->servant->image = UploadedFile::fake()->image('avatar.png');
        $this->servant->save();

        $imageName = $this->imageName();
        $imagePath = $this->imagePath();
        $imageFullPath = $this->fullImagePath();

        $this->servant->name = 'new-name';
        $this->servant->save();

        $this->assertEquals('new-name', $this->servant->name);
        $this->assertEquals($imageName, $this->servant->image);
        $this->assertEquals($imagePath, $this->servant->image_path);
        $this->assertFileExists($imageFullPath);
    }

    public function testUpdateUserWithNewImageWhenImageIsPresent(): void
    {
        $this->servant->image = UploadedFile::fake()->image('avatar.png');
        $this->servant->save();
        $previousFullImagePath = $this->fullImagePath();

        $this->servant->name = 'new-name';
        $this->servant->image = UploadedFile::fake()->image('avatar.png');
        $this->servant->save();
        $this->servant->refresh();

        $this->assertEquals($this->imageName(), $this->servant->image);
        $this->assertEquals($this->imagePath(), $this->servant->image_path);
        $this->assertFileExists($this->fullImagePath());
        $this->assertFileDoesNotExist($previousFullImagePath);
    }

    public function testWhenDeleteUserShouldDeleteTheImage(): void
    {
        $this->servant->image = UploadedFile::fake()->image('avatar.png');
        $this->servant->save();

        $previousFullImagePath = $this->fullImagePath();
        $this->servant->delete();
        $this->assertFileDoesNotExist($previousFullImagePath);
    }

    private function imageName(): string
    {
        return Str::slug($this->servant->id . '-' . $this->servant->name, '-') . '.png';
    }

    private function imagePath(): string
    {
        return '/uploads/servants/' . $this->servant->id . '/' . $this->imageName();
    }

    private function fullImagePath(): string
    {
        return public_path($this->imagePath());
    }

    private function defaultImage(): string
    {
        return '/assets/images/default/default-user.png';
    }
}
