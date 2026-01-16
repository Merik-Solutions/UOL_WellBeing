<?php

namespace App\Repositories\interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Interface BaseRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface BaseInterface extends RepositoryInterface
{
    public function queryBuilder(): QueryBuilder|string;

    /**
     * @param array $where
     * @param string[] $columns
     * @param bool $pagination
     * @return mixed
     */

    public function findWhere(
        array $where,
        $pagination = false,
        $columns = ['*'],
    );

    /**
     * @param array $attributes
     * @param array $values
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function firstOrCreate(array $attributes = [], array $values = []);

    public static function getReflection(): \ReflectionClass;

    public static function getConstants(
        $keyContains = null,
        $returnCount = false,
    );

    public static function getConstantsFlipped(
        $keyContains = null,
        $returnCount = false,
    );

    /*
     * get all alias with  it's reference models
     */
    public function getAliasReference(): array;

    /**
     * get model alias
     * @param null $model
     * @return mixed|string
     */
    public function getMorphedAlias($model = null): string;
}
