<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImageRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if file is uploaded
        if (!is_file($value) && !is_object($value)) {
            $fail('The ' . $attribute . ' must be a valid uploaded file.');
            return;
        }

        // Validate mime type
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

        // getMimeType() method exists on UploadedFile
        $mimeType = $value->getMimeType();

        if (!in_array($mimeType, $allowedMimeTypes)) {
            $fail('The ' . $attribute . ' must be a file of type: jpg, png, webp.');
            return;
        }

        // Validate file size max 2MB (2048 KB)
        $maxSize = 2048 * 1024; // bytes
        if ($value->getSize() > $maxSize) {
            $fail('The ' . $attribute . ' may not be greater than 2 MB.');
            return;
        }
    }
}
