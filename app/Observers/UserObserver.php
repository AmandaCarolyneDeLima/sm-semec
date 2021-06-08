<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;
use File;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $this->saveImageFile($user);
    }

    /**
     * Handle the user "updating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        if ($user->isDirty('image')) {
            $this->deleteImageFile(User::find($user->id));
            $this->saveImageFile($user);
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $this->deleteImageFile($user);
    }

    /**
     * Delete a image from file.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    private function deleteImageFile($user)
    {
        $imageDirectory = public_path('uploads/users/' . $user->id);
        $imagePath = $imageDirectory  . '/' . $user->image;

        File::delete($imagePath);
        $files = glob($imageDirectory . '/*');
        if (is_array($files) && count($files) === 0) {
            File::deleteDirectory($imageDirectory);
        }
    }

    /**
     * Save file in disk.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    private function saveImageFile($user)
    {
        if ($user->image != null) {
            $imageName = Str::slug($user->id . '-' . $user->name, '-') . '.' . $user->image->extension();
            $storePath = public_path('uploads/users/' . $user->id);

            $user->image->move($storePath, $imageName);
            $user->image = $imageName;
        }
    }
}
