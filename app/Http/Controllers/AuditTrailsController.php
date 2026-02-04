<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AuditTrailsController extends Controller
{
public function index(Request $request)
    {
        $query = \DB::table('QA_KKVaudit_trails as a')
            ->leftJoin('QA_KKVUser as u', 'u.id', '=', 'a.user_id')
            ->select(
                'a.id',
                'a.table_name',
                'a.record_id',
                'a.action',
                'a.old_values',
                'a.new_values',
                'a.created_at',
                'u.username as user_name'
            );

        // 🔹 Filter action (CREATED / UPDATED / DELETED)
        if ($request->has('action') && !empty($request->action)) {
            $query->where('a.action', $request->action);
        }


        // 🔹 Filter bulan (format: 2025-11)
        if ($request->has('month') && !empty($request->month)) {
            $query->whereYear('a.created_at', '=', substr($request->month, 0, 4))
            ->whereMonth('a.created_at', '=', substr($request->month, 5, 2));

        }

        // 🔹 Search di old_values / new_values (text match)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('a.old_values', 'like', "%$search%")
                ->orWhere('a.new_values', 'like', "%$search%");
            });
        }
        // 🔹 Pagination
        $auditTrails = $query->orderByDesc('a.created_at')->paginate(10);

        // Decode JSON old/new values agar mudah diakses di view
        $auditTrails->getCollection()->transform(function ($item) {
            $item->old_values = json_decode($item->old_values, true);
            $item->new_values = json_decode($item->new_values, true);
            return $item;
        });
        // dd($auditTrails);
        return view('audittrails.index', compact('auditTrails'));
    }

}