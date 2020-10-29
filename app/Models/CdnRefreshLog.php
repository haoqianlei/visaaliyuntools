<?php

namespace App\Models;

use App\Services\AliyunService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class CdnRefreshLog extends Model
{
    use HasFactory;

    public function paginate()
    {
        $perPage = Request::get('per_page', 20);
        $data = new AliyunService();
        list($status, $result) = $data->cdnRefreshLog();
        if ($status) {
            $data = json_decode($result, true);
//            dd($data);
            $movies = static::hydrate($data['Tasks']['CDNTask']);
            $paginator = new LengthAwarePaginator($movies, $data['TotalCount'], $perPage);
            $paginator->setPath(url()->current());
            return $paginator;
        }
        abort(500);
    }

    public static function with($relations)
    {
        return new static;
    }
}
