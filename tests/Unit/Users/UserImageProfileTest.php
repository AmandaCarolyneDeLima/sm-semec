<?php

namespace Tests\Unit\Users;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Models\User;
use File;

class UserImageProfileTest extends TestCase
{
    /** @var \App\Models\User */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function tearDown(): void
    {
        $this->user->delete();
    }

    public function testCreateNoImage(): void
    {
        $this->assertNull($this->user->image);
        $this->assertEquals($this->defaultImage(), $this->user->image_path);
    }

    public function testUpdateUserWithNewImageWhenImageIsNull(): void
    {
        $this->user->image = UploadedFile::fake()->image('avatar.png');
        $this->user->save();

        $this->assertEquals($this->imageName(), $this->user->image);
        $this->assertEquals($this->imagePath(), $this->user->image_path);
        $this->assertFileExists($this->fullImagePath());
    }

    public function testUpdateNoImage(): void
    {
        $this->user->save();

        $this->assertNull($this->user->image);
        $this->assertEquals($this->defaultImage(), $this->user->image_path);
    }

    public function testUpdateUserNoImageWhenImageIsPresent(): void
    {
        $this->user->image = UploadedFile::fake()->image('avatar.png');
        $this->user->save();

        $imageName = $this->imageName();
        $imagePath = $this->imagePath();
        $imageFullPath = $this->fullImagePath();

        $this->user->name = 'new-name';
        $this->user->save();

        $this->assertEquals('new-name', $this->user->name);
        $this->assertEquals($imageName, $this->user->image);
        $this->assertEquals($imagePath, $this->user->image_path);
        $this->assertFileExists($imageFullPath);
    }

    public function testUpdateUserWithNewImageWhenImageIsPresent(): void
    {
        $this->user->image = UploadedFile::fake()->image('avatar.png');
        $this->user->save();
        $previousFullImagePath = $this->fullImagePath();

        $this->user->name = 'new-name';
        $this->user->image = UploadedFile::fake()->image('avatar.png');
        $this->user->save();
        $this->user->refresh();

        $this->assertEquals($this->imageName(), $this->user->image);
        $this->assertEquals($this->imagePath(), $this->user->image_path);
        $this->assertFileExists($this->fullImagePath());
        $this->assertFileDoesNotExist($previousFullImagePath);
    }

    public function testWhenDeleteUserShouldDeleteTheImage(): void
    {
        $this->user->image = UploadedFile::fake()->image('avatar.png');
        $this->user->save();

        $previousFullImagePath = $this->fullImagePath();
        $this->user->delete();
        $this->assertFileDoesNotExist($previousFullImagePath);
    }

    private function imageName(): string
    {
        return Str::slug($this->user->id . '-' . $this->user->name, '-') . '.png';
    }

    private function imagePath(): string
    {
        return '/uploads/users/' . $this->user->id . '/' . $this->imageName();
    }

    private function fullImagePath(): string
    {
        return public_path($this->imagePath());
    }

    private function defaultImage(): string
    {
        return '/assets/images/default/users/default-user.png';
    }
}
