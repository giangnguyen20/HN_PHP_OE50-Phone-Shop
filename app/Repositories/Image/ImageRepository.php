<?php
namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Repositories\Image\ImageRepositoryInterface;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return Image::class;
    }

    public function insertImage($attributes = [])
    {
        return $this->model->insert($attributes);
    }
}
