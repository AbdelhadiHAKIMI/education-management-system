@extends('layouts.app')

@section('title', 'لوحة إحصائيات النتائج')

@section('content')
<div class="mx-auto py-6 container">
    <h1 class="mb-6 font-bold text-blue-700 text-2xl text-center">لوحة إحصائيات النتائج الشاملة</h1>

    <!-- Comprehensive Numbers -->
    <div class="gap-4 grid grid-cols-1 md:grid-cols-4 mb-6">
        <div class="bg-white shadow p-4 rounded text-center">
            <div class="text-gray-500">عدد المشاركين</div>
            <div class="font-bold text-2xl">{{ $totalParticipants }}</div>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <div class="text-gray-500">عدد الناجحين</div>
            <div class="font-bold text-green-600 text-2xl">{{ $passedCount }}</div>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <div class="text-gray-500">عدد الراسبين</div>
            <div class="font-bold text-red-600 text-2xl">{{ $failedCount }}</div>
        </div>
        <div class="bg-white shadow p-4 rounded text-center">
            <div class="text-gray-500">المعدل العام</div>
            <div class="font-bold text-2xl">{{ number_format($overallAverage, 2) }}</div>
        </div>
    </div>

    <!-- Grade Distributions -->
    <div class="mb-8">
        <h2 class="mb-2 font-semibold text-blue-700 text-lg">توزيعات المعدلات حسب الشعبة</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
            @foreach($gradeDistributions as $stream => $ranges)
            <div class="bg-white shadow p-4 rounded">
                <h3 class="mb-2 font-bold text-indigo-700">{{ $stream }}</h3>
                <ul>
                    @foreach($ranges as $range => $count)
                    <li class="flex justify-between py-1 border-b">
                        <span>{{ $range }}</span>
                        <span class="font-bold">{{ $count }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Categories by Stream -->
    <div class="mb-8">
        <h2 class="mb-2 font-semibold text-blue-700 text-lg">مقارنة الأداء حسب الشعبة</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
            @foreach($streamStats as $stream => $stats)
            <div class="bg-white shadow p-4 rounded">
                <h3 class="mb-2 font-bold text-indigo-700">{{ $stream }}</h3>
                <ul>
                    <li>عدد المشاركين: <span class="font-bold">{{ $stats['participants'] }}</span></li>
                    <li>عدد الناجحين: <span class="font-bold text-green-600">{{ $stats['passed'] }}</span></li>
                    <li>عدد الراسبين: <span class="font-bold text-red-600">{{ $stats['failed'] }}</span></li>
                    <li>المعدل العام: <span class="font-bold">{{ number_format($stats['average'], 2) }}</span></li>
                </ul>
                <div class="mt-2">
                    <strong>متوسط المواد:</strong>
                    <ul>
                        @foreach($stats['subject_averages'] as $subject => $avg)
                        <li>{{ $subject }}: <span class="font-bold">{{ number_format($avg, 2) }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Highest Scores -->
    <div class="mb-8">
        <h2 class="mb-2 font-semibold text-blue-700 text-lg">أعلى علامة في كل مادة لكل شعبة</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
            @foreach($highestScores as $stream => $subjects)
            <div class="bg-white shadow p-4 rounded">
                <h3 class="mb-2 font-bold text-indigo-700">{{ $stream }}</h3>
                <ul>
                    @foreach($subjects as $subject => $info)
                    <li class="flex justify-between py-1 border-b">
                        <span>{{ $subject }}</span>
                        <span class="font-bold text-green-700">{{ $info['grade'] }}</span>
                        <span class="text-gray-500">({{ $info['student'] }})</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Positive/Negative Impact -->
    <div class="mb-8">
        <h2 class="mb-2 font-semibold text-blue-700 text-lg">التأثير الإيجابي/السلبي للمواد غير الأساسية</h2>
        <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
            @foreach($streams as $stream => $en)
            <div class="bg-white shadow p-4 rounded">
                <h3 class="mb-2 font-bold text-indigo-700">{{ $stream }}</h3>
                <ul>
                    <li>التأثير الإيجابي: <span class="font-bold text-green-600">{{ $positiveImpact[$stream] ?? 0 }}</span></li>
                    <li>التأثير السلبي: <span class="font-bold text-red-600">{{ $negativeImpact[$stream] ?? 0 }}</span></li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Responsive Table Wrapper -->
    <div class="mb-8">
        <h2 class="mb-2 font-semibold text-blue-700 text-lg">قائمة الطلاب ونتائجهم</h2>
        <div class="w-full overflow-x-auto">
            <table class="bg-white shadow rounded min-w-full text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2">الاسم الكامل</th>
                        <th class="px-3 py-2">الشعبة</th>
                        <th class="px-3 py-2">الجلسة</th>
                        <th class="px-3 py-2">المعدل</th>
                        <th class="px-3 py-2">الحالة</th>
                        <th class="px-3 py-2">الدرجات حسب المادة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    @php
                    $examResult = $student->examResults->first();
                    $session = $examResult ? $examResult->examSession->name : '-';
                    $overall = $examResult ? $examResult->overall_score : null;
                    $status = $examResult ? $examResult->success_status : null;
                    @endphp
                    <tr class="border-b">
                        <td class="px-3 py-2 font-bold">{{ $student->full_name }}</td>
                        <td class="px-3 py-2">{{ $student->branch->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $session }}</td>
                        <td class="px-3 py-2 font-bold {{ $overall >= 10 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $overall !== null ? number_format($overall, 2) : '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $status === 'passed' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $status === 'passed' ? 'ناجح' : ($status === 'failed' ? 'راسب' : '-') }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            <div class="flex flex-wrap gap-1">
                                @foreach($student->subjectGrades as $grade)
                                @php
                                // Handle subject name for both object and array/JSON
                                $subjectName = '-';
                                if ($grade->subject && isset($grade->subject->name)) {
                                $subjectName = $grade->subject->name;
                                } elseif (is_string($grade->subject_id) && str_starts_with($grade->subject_id, '{')) {
                                // If subject_id is a JSON string, decode and get name
                                $subjectObj = json_decode($grade->subject_id);
                                $subjectName = isset($subjectObj->name) ? $subjectObj->name : '-';
                                } elseif (isset($grade->subject_name)) {
                                $subjectName = $grade->subject_name;
                                }
                                $isPassed = $grade->grade >= 10;
                                @endphp
                                <span class="px-2 py-1 rounded text-xs {{ $isPassed ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $subjectName }}: {{ number_format($grade->grade, 2) }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</div>
@endsection