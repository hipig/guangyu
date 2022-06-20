<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class FixedDetailImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixed:detail-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fixed detail images';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $storage = Storage::disk('upload');
        $images = $storage->files('images');

        foreach ($images as $image) {
            $ext = pathinfo($image, PATHINFO_EXTENSION);
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                continue;
            }

            $path = Str::replaceLast('.'.$ext, '', $image);

            if (Str::endsWith($path, '-m')) {
                continue;
            }

            $path = $path.'-m.'.$ext;

            $imageData = Image::make($storage->path($image))
                ->resize(480, null, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                })
                ->encode();

            if (!$storage->exists($path)) {
                $storage->put($path, $imageData);
            }
        }

    }
}
