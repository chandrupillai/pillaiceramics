<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGodownRequest;
use App\Http\Requests\Admin\UpdateGodownRequest;
use App\Repositories\GodownRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GodownController extends Controller
{
    protected $godownRepository;
    protected $locationRepository;

    public function __construct(
        GodownRepository $godownRepository,
        LocationRepository $locationRepository
    ) {
        $this->godownRepository = $godownRepository;
        $this->locationRepository = $locationRepository;
    }

    public function index()
    {
        $locations = $this->locationRepository->getActiveLocations();
        return view('admin.godowns.index', compact('locations'));
    }

    public function fetch(Request $request): JsonResponse
    {
        $godowns = $this->godownRepository->getFilteredGodowns($request);

        return response()->json([
            'status' => true,
            'data'   => $godowns
        ]);
    }

    public function store(StoreGodownRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $godown = $this->godownRepository->create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Godown created successfully.',
            'data'    => $godown->load('location:id,name')
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $godown = $this->godownRepository->findById($id);

        return response()->json([
            'status' => true,
            'data'   => $godown
        ]);
    }

    public function update(UpdateGodownRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $godown = $this->godownRepository->update($id, $validated);

        return response()->json([
            'status'  => true,
            'message' => 'Godown updated successfully.',
            'data'    => $godown->load('location:id,name')
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->godownRepository->delete($id);

        return response()->json([
            'status'  => true,
            'message' => 'Godown deleted successfully.'
        ]);
    }
}