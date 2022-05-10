<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanelAroseController extends Controller
{
    public function stats() {
        if (!Auth()->user()->isadmin) {
            return redirect('/home');
        } else {
            $queryRegisteredUsers = DB::select("
                SELECT DATE(created_at) AS created, COUNT(id) as c
                FROM users
                WHERE email NOT LIKE '%mk.app'
                GROUP BY(created)
                ORDER BY created ASC
            ");
            $queryAddedStudents = DB::select("
                SELECT DATE(created_at) AS created, COUNT(id) as c
                FROM students
                GROUP BY(created)
                ORDER BY created ASC
            ");
            $queryAddedRubrics = DB::select("
                SELECT DATE(created_at) AS created, COUNT(id) as c
                FROM rubrics
                GROUP BY(created)
                ORDER BY created ASC
            ");
            $queryResources = DB::select("
                SELECT DATE(updated_at) AS created, COUNT(id) as c
                FROM resources
                GROUP BY(created)
                ORDER BY created ASC
            ");
            $queryUsers = DB::select("
                SELECT DATE(u.updated_at) AS created, u.id, u.name, u.email
                FROM users u
                ORDER BY id ASC
            ");
            $queryUsersAndStudents = DB::select("
                SELECT DATE(u.updated_at) AS created, u.id, u.name, u.email, count(s.id) as students
                FROM users u, students s
                WHERE u.id = s.user_id
                GROUP BY s.user_id
                ORDER BY id ASC
            ");
            $resourcesUser = DB::select("
                SELECT r.filename, DATE(r.created_at) as created, u.name, u.email, u.id
                FROM resources r, users u
                WHERE uploaded_by <> 1
                  AND u.id = uploaded_by
            ");
            return view('arose.stats', [
                'registeredUsers' => $queryRegisteredUsers,
                'addedStudents' => $queryAddedStudents,
                'addedRubrics' => $queryAddedRubrics,
                'resources' => $queryResources,
                'resourcesuser' => $resourcesUser,
                'users' => $queryUsers,
                'usersstudents' => $queryUsersAndStudents,
            ]);
        }
    }
}
