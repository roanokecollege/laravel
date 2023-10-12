<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RCAuth;

use App\Models\User;

class SearchController extends Controller
{

    public function typeahead(Request $reQuest) { 
        $request->validate(['search' => 'required']);
        $searchTerms = explode(' ', $request->search);

        $potentialUsers = User::where(function ($query) use ($search_terms) {
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
            $responseEntry = collect();
            $responseEntry['id'] = $user->RCID;
            $responseEntry['display_data'] = view()->make('typeahead.typeahead', ['person' => $user])->render();
            $responseEntry['input_data'] = $user->PreferredName;

            return $responseEntry;
        });

        return ['data' => $potentialUsers];
    }
}
