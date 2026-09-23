<?php

namespace App\Repositories;

use App\Models\Godown;
use Illuminate\Http\Request;

class GodownRepository
{
    public function getFilteredGodowns(Request $request)
    {
        $query = Godown::with('location:id,name,city');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('incharge_person', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status'));
        }

        return $query->latest()->paginate(10);
    }

    public function findById($id)
    {
        return Godown::with('location:id,name,city')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Godown::create($data);
    }

    public function update($id, array $data)
    {
        $godown = Godown::findOrFail($id);
        $godown->update($data);
        return $godown;
    }

    public function delete($id)
    {
        $godown = Godown::findOrFail($id);
        return $godown->delete();
    }
}