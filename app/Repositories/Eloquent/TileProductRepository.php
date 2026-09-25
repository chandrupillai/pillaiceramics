<?php

namespace App\Repositories\Eloquent;

use App\Models\TileProduct;
namespace App\Repositories\Eloquent;

use App\Models\TileProduct;
use App\Repositories\Contracts\TileProductRepositoryInterface;

class TileProductRepository implements TileProductRepositoryInterface
{
    protected TileProduct $model;

    public function __construct(TileProduct $model)
    {
        $this->model = $model;
    }

    /**
     * Get all products with their godowns and location stock details.
     */
    public function getAllWithStockLocations()
    {
        return $this->model->with(['godowns' => function ($query) {
            $query->select('godowns.id', 'godowns.name', 'godowns.location_id')
                  ->with('location:id,name');
        }])->latest()->get();
    }

    /**
     * Get a single product by ID with its godowns and location stock details.
     *
     * @param int $productId
     */
    public function getProductStockLocations(int $productId)
    {
        return $this->model->with(['godowns' => function ($query) {
            $query->select('godowns.id', 'godowns.name', 'godowns.location_id')
                  ->with('location:id,name');
        }])->find($productId);
    }

    /**
     * Get all tile products.
     */
    public function getAll()
    {
        return $this->model->latest()->get();
    }

    /**
     * Find a tile product by its primary key ID.
     *
     * @param int $id
     */
    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new tile product record.
     *
     * @param array $data
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing tile product record.
     *
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $product = $this->findById($id);
        $product->update($data);
        return $product;
    }

    /**
     * Delete a tile product record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $product = $this->findById($id);
        return $product->delete();
    }
}