<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قوائم الأقسام</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-right">
    <div class="mx-auto p-4 container">
        <div class="flex justify-between items-center mb-4">
            <h1 class="font-bold text-2xl">قوائم الأقسام</h1>
            <a href="{{ route('admin.students.classrooms.generate') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
                تحميل ملف Word
            </a>
        </div>

        <!-- Customization Form -->
        <form method="GET" class="flex flex-wrap items-center gap-2 mb-6">
            <label>عدد الطلاب في كل قسم:
                <input type="number" name="group_size" value="{{ request('group_size', 15) }}" min="1" class="px-2 py-1 border rounded w-20">
            </label>
            <label>نوع التدريب:
                <select name="internship_type" class="px-2 py-1 border rounded">
                    <option value="preparatory" {{ request('internship_type', 'preparatory') == 'preparatory' ? 'selected' : '' }}>تدريب تمهيدي</option>
                    <option value="other" {{ request('internship_type') == 'other' ? 'selected' : '' }}>تدريب آخر</option>
                </select>
            </label>
            <label>
                <input type="checkbox" name="manual" value="1" {{ request('manual') ? 'checked' : '' }}>
                تقسيم يدوي (حسب section_increment)
            </label>
            <label>
                <input type="checkbox" name="order_by_initial_classroom" value="1" {{ request('order_by_initial_classroom') ? 'checked' : '' }}>
                تقسيم حسب القسم الأولي
            </label>
            @if(isset($branches) && $branches->count())
            <div class="flex flex-wrap gap-2 w-full">
                @foreach($branches as $branch)
                <label>
                    عدد الأقسام لشعبة {{ $branch->name }}:
                    <input type="number" name="classes_per_branch[{{ $branch->id }}]" value="{{ request('classes_per_branch.' . $branch->id) }}" min="1" class="px-2 py-1 border rounded w-20">
                </label>
                @endforeach
            </div>
            @endif
            <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">تطبيق</button>
        </form>

        <!-- Recommendations -->
        @if(isset($recommendations))
        <div class="bg-yellow-100 mb-4 p-3 rounded text-yellow-800">
            <strong>توصيات:</strong>
            <ul class="pr-6 list-disc">
                @foreach($recommendations as $rec)
                <li>{{ $rec }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @forelse($classrooms as $classroom)
        <div class="bg-white shadow mb-8 p-4 rounded">
            <h2 class="mb-2 font-semibold text-lg">
                القسم: {{ $classroom['classroom_number'] }}
            </h2>
            <table class="border min-w-full text-right">
                <thead>
                    <tr>
                        <th class="px-2 py-1 border">الترتيب</th>
                        <th class="px-2 py-1 border">الاسم</th>
                        <th class="px-2 py-1 border">الفرع</th>
                        <th class="px-2 py-1 border">القسم الأولي</th>
                        <th class="px-2 py-1 border">المعدل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classroom['students'] as $student)
                    <tr>
                        <td class="px-2 py-1 border">{{ $student->order_number }}</td>
                        <td class="px-2 py-1 border">{{ $student->full_name ?? $student->name }}</td>
                        <td class="px-2 py-1 border">{{ $classroom['branch'] }}</td>
                        <td class="px-2 py-1 border">{{ $classroom['initial_classroom'] }}</td>
                        <td class="px-2 py-1 border">{{ $student->overall_score }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @empty
        <div class="text-gray-500">لا يوجد طلاب مقبولين حالياً.</div>
        @endforelse
    </div>
</body>

</html>