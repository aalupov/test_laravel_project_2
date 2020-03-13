<?php
namespace App\Repositories;

use App\Partner as Model;

/**
 * Class PartnerRepository
 *
 * @package App\Repositories
 */
class PartnerRepository extends CoreRepository
{

    /**
     * const array
     */
    private const COLUMNS = [
        'id',
        'email',
        'name'
    ];

    /**
     *
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get Model to edit
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * Get the partners
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getPartners()
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->get();

        return $result;
    }

    /**
     * Get the partner by partner id
     *
     * @param int $id
     *
     * @return App/Partner
     */
    public function getPartnerById($id)
    {
        $result = $this->startConditions()
            ->select(self::COLUMNS)
            ->find($id);

        return $result;
    }
}