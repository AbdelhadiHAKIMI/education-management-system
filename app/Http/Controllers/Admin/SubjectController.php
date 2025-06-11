<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Branch;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        // Handle bulk add from preset list
        if ($request->has('subjects')) {
            // Define core subjects for each branch
            $coreSubjectsByBranch = [
                'آداب وفلسفة' => [
                    'ل.عربية وآدابها',
                    'فلسفة',
                    'تاريخ وجغرافيا',
                    'لغة فرنسية',
                    'لغة إنجليزية'
                ],
                'رياضيات' => [
                    'رياضيات',
                    'علوم فيزيائية',
                ],
                'علوم تجريبية' => [
                    'ع.الطبيعة والحياة',
                    'علوم فيزيائية',
                    'رياضيات',
                ],
            ];

            foreach ($request->input('subjects') as $branchName => $branchSubjects) {
                foreach ($branchSubjects as $subject) {
                    if (!empty($subject['add']) && !empty($subject['name']) && !empty($subject['coefficient']) && !empty($subject['branch_id'])) {
                        // Determine is_core_subject for this branch/subject
                        $isCore = false;
                        if (isset($coreSubjectsByBranch[$branchName])) {
                            $isCore = in_array($subject['name'], $coreSubjectsByBranch[$branchName]);
                        }
                        \App\Models\Subject::create([
                            'name' => $subject['name'],
                            'coefficient' => $subject['coefficient'],
                            'branch_id' => $subject['branch_id'],
                            'is_core_subject' => $isCore,
                        ]);
                    }
                }
            }
            return redirect()->back()->with('success', 'تمت إضافة المواد المحددة بنجاح.');
        }

        // Handle single subject add (if needed)
        $request->validate([
            'name' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1|max:10',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Determine is_core_subject for single add
        $branch = \App\Models\Branch::find($request->branch_id);
        $coreSubjectsByBranch = [
            'آداب وفلسفة' => [
                'ل.عربية وآدابها',
                'فلسفة',
                'تاريخ وجغرافيا',
                'لغة فرنسية',
                'لغة إنجليزية'
            ],
            'رياضيات' => [
                'رياضيات',
                'علوم فيزيائية',
                'ل.عربية وآدابها'
            ],
            'علوم تجريبية' => [
                'ع.الطبيعة والحياة',
                'علوم فيزيائية',
                'رياضيات',
                'ل.عربية وآدابها'
            ],
        ];
        $isCore = false;
        if ($branch && isset($coreSubjectsByBranch[$branch->name])) {
            $isCore = in_array($request->name, $coreSubjectsByBranch[$branch->name]);
        }

        \App\Models\Subject::create([
            'name' => $request->name,
            'coefficient' => $request->coefficient,
            'branch_id' => $request->branch_id,
            'is_core_subject' => $isCore,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة المادة بنجاح.');
    }
}
