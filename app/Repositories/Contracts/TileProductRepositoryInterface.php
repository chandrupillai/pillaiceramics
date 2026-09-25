<?php

namespace App\Repositories\Contracts;

interface TileProductRepositoryInterface
{
    /**
     * Get all products with their godowns and location stock details.
     */
    public function getAllWithStockLocations();

    /**
     * Get a single product by ID with its godowns and location stock details.
     *
     * @param int $productId
     */
    public function getProductStockLocations(int $productId);

    /**
     * Get all tile products.
     */
    public function getAll();

    /**
     * Find a tile product by its primary key ID.
     *
     * @param int $id
     */
    public function findById(int $id);

    /**
     * Create a new tile product record.
     *
     * @param array $data
     */
    public function create(array $data);

    /**
     * Update an existing tile product record.
     *
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data);

    /**
     * Delete a tile product record by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}