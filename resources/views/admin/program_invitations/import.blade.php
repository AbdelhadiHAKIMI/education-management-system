<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استيراد دعوات البرامج</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-right">
    <div class="mx-auto p-4 container">
        <h1 class="mb-4 font-bold text-2xl">استيراد دعوات البرامج</h1>
        <div class="flex md:flex-row flex-col md:items-center md:space-x-2 md:space-x-reverse mb-4">
            <form action="{{ route('admin.program_invitations.prototype') }}" method="GET" class="flex items-center space-x-2 space-x-reverse">
                <label for="level_id_proto" class="block mb-1 font-medium">اختر المستوى الدراسي للنموذج</label>
                <select name="level_id" id="level_id_proto" class="px-2 py-1 border rounded" required>
                    <option value="">-- اختر المستوى --</option>
                    @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-white">
                    تحميل نموذج ملف الاستيراد (XLSX)
                </button>
            </form>
        </div>
        @if(session('success'))
        <div class="bg-green-100 mb-4 p-3 rounded text-green-800">{!! session('success') !!}</div>
        @endif
        @php
        if (!isset($programs)) {
        $programs = \App\Models\Program::all(['id', 'name']);
        }
        if (!isset($levels)) {
        $levels = \App\Models\Level::all(['id', 'name']);
        }
        @endphp

        <!-- Level selection and download students button -->
        <div class="mb-4">
            <form action="{{ route('admin.program_invitations.download_students') }}" method="GET" class="flex items-center space-x-2 space-x-reverse">
                <label for="level_id" class="block mb-1 font-medium">اختر المستوى الدراسي</label>
                <select name="level_id" id="level_id" class="px-2 py-1 border rounded" required>
                    <option value="">-- اختر المستوى --</option>
                    @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">تحميل قائمة الطلاب</button>
            </form>
        </div>

        <form action="{{ route('admin.program_invitations.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white shadow p-4 rounded">
            @csrf
            <div>
                <label for="program_id" class="block mb-1 font-medium">اختر البرنامج</label>
                <select name="program_id" id="program_id" class="px-2 py-1 border rounded w-full" required>
                    <option value="">-- اختر --</option>
                    @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="file" class="block mb-1 font-medium">ملف Excel أو CSV</label>
                <input type="file" name="file" id="file" class="px-2 py-1 border rounded w-full" required>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">استيراد</button>
        </form>
    </div>
</body>

</html>