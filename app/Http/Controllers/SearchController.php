<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RCAuth;

use App\Models\User;

class SearchController extends Controller
{

    public function typeahead(Request $request) 
    {
        $request->validate(['search' => 'required']);
        $search_terms = explode(' ', $request->search);

        $potential_users = User::where(function ($query) use ($search_terms) {
            foreach ($search_terms as $term) {
                $query->where(function ($search_query) use ($term) {
                    $search_query->where('FirstName', 'LIKE', sprintf('%%%s%%', $term))
                    ->orWhere('LastName', 'LIKE', sprintf('%%%s%%', $term))
                    ->orWhere('MiddleName', 'LIKE', sprintf('%%%s%%', $term))
                    ->orWhere('nick_name', 'LIKE', sprintf('%%%s%%', $term))
                    ->orWhere('NickName', 'LIKE', sprintf('%%%s%%', $term))
                    ->orWhere('RCID', 'LIKE', sprintf('%%%s%%', $term));
                });
            }
        })->get()->map(function ($user) {
            $response_entry = collect();
            $response_entry['id'] = $user->RCID;
            $response_entry['display_data'] = view()->make('typeahead.typeahead', ['person' => $user])->render();
            $response_entry['input_data'] = $user->PreferredName;

            return $response_entry;
        });

        return ['data' => $potential_users];
    }
}
