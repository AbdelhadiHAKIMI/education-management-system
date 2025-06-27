<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ isset($staff) && $staff->exists ? 'تعديل بيانات المؤطر' : 'إضافة مؤطر جديد' }}
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
        }

        input[type="checkbox"] {
            accent-color: #3b82f6;
            /* This matches Tailwind's blue-600 */
        }
    </style>
</head>

<body class="bg-gray-50">
    @extends('layouts.app')

    @section('title', isset($staff) && $staff->exists ? 'تعديل بيانات المؤطر' : 'إضافة مؤطر جديد')

    @section('content')
    <div class="bg-white shadow-md mx-auto p-6 rounded-lg max-w-3xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-gray-800 text-2xl">
                {{ isset($staff) && $staff->exists ? 'تعديل بيانات المؤطر' : 'إضافة مؤطر جديد' }}
            </h1>
            <a href="{{ route('admin.staffs.index') }}" class="text-blue-600 hover:underline">العودة للقائمة</a>
        </div>

        <form method="POST"
            action="{{ isset($staff) && $staff->exists ? route('admin.staffs.update', $staff->id) : route('admin.staffs.store') }}">
            @csrf
            @if (isset($staff) && $staff->exists)
            @method('PUT')
            @endif

            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                <div>
                    <label for="full_name" class="block mb-2 text-gray-700">الاسم الكامل *</label>
                    <input type="text" id="full_name" name="full_name"
                        value="{{ old('full_name', $staff->full_name ?? '') }}"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full"
                        required>
                    @error('full_name')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="birth_date" class="block mb-2 text-gray-700">تاريخ الميلاد *</label>
                    <input type="date" id="birth_date" name="birth_date"
                        value="{{ old('birth_date', optional($staff->birth_date)->format('Y-m-d') ?? '') }}"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full"
                        required>
                    @error('birth_date')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block mb-2 text-gray-700">نوع الموظف *</label>
                    <select id="type" name="type"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full"
                        required>
                        <option value="">اختر النوع</option>
                        <option value="إداري" @selected(old('type', $staff->type ?? '') == 'إداري')>إداري</option>
                        <option value="مؤطر دراسي" @selected(old('type', $staff->type ?? '') == 'مؤطر دراسي')>مؤطر دراسي</option>
                        <option value="خدمات" @selected(old('type', $staff->type ?? '') == 'خدمات')>خدمات</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block mb-2 text-gray-700">رقم الهاتف</label>
                    <input type="tel" id="phone" name="phone"
                        value="{{ old('phone', $staff->phone ?? '') }}"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
                    @error('phone')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bac_year" class="block mb-2 text-gray-700">سنة البكالوريا</label>
                    <input type="number" id="bac_year" name="bac_year" min="1900"
                        max="{{ date('Y') + 1 }}" value="{{ old('bac_year', $staff->bac_year ?? '') }}"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
                    @error('bac_year')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="univ_specialty" class="block mb-2 text-gray-700">التخصص الجامعي</label>
                    <input type="text" id="univ_specialty" name="univ_specialty"
                        value="{{ old('univ_specialty', $staff->univ_specialty ?? '') }}"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
                    @error('univ_specialty')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                @php
                $showBranch = old('type', $staff->type ?? '') == 'مؤطر دراسي';
                $selectedBranch = old('branch_id', $staff->branch_id ?? '');
                $selectedSubjects = old('subjects', isset($staff) && $staff->exists && isset($staff->subjects) ? $staff->subjects->pluck('id')->map(fn($id) => (string)$id)->toArray() : []);
                @endphp

                <div id="branch_field" class="{{ $showBranch ? '' : 'hidden' }}">
                    <label for="branch_id" class="block mb-2 text-gray-700">الشعبة *</label>
                    <select id="branch_id" name="branch_id"
                        class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full" {{ $showBranch ? 'required' : '' }}>
                        <option value="">اختر الشعبة</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" @selected($selectedBranch==$branch->id)>
                            {{ $branch->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div id="subjects_field" class="{{ ($showBranch && $selectedBranch) ? '' : 'hidden' }} mt-4">
                    <label class="block mb-2 text-gray-700">المواد الدراسية</label>
                    <div class="space-y-2" id="subjects_container">
                        @php
                        $subjects = [];
                        if ($showBranch && $selectedBranch) {
                        $subjects = \App\Models\Subject::where('branch_id', $selectedBranch)->get();
                        }
                        @endphp
                        @foreach($subjects as $subject)
                        <div class="flex flex-row items-center gap-2">
                            <input type="checkbox"
                                id="subject_{{ $subject->id }}"
                                name="subjects[]"
                                value="{{ $subject->id }}"
                                class="border-gray-300 rounded w-4 h-4 text-blue-600"
                                {{ in_array((string)$subject->id, $selectedSubjects) ? 'checked' : '' }}>
                            <label for="subject_{{ $subject->id }}" class="ml-2 text-gray-700">
                                {{ $subject->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('subjects')
                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-4 border-gray-200 border-t">
                <a href="{{ route('admin.staffs.index') }}"
                    class="hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                    إلغاء
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    {{ isset($staff) && $staff->exists ? 'حفظ التغييرات' : 'إضافة المؤطر' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeField = document.getElementById('type');
            const branchField = document.getElementById('branch_field');
            const branchSelect = document.getElementById('branch_id');
            const subjectsField = document.getElementById('subjects_field');
            const subjectsContainer = document.getElementById('subjects_container');

            // Get selected subjects from checkboxes (no json)
            function getSelectedSubjects() {
                const checked = document.querySelectorAll('input[name="subjects[]"]:checked');
                let ids = [];
                checked.forEach(cb => ids.push(cb.value));
                return ids;
            }

            function toggleBranchField() {
                if (typeField.value === 'مؤطر دراسي') {
                    branchField.classList.remove('hidden');
                    branchSelect.required = true;
                    if (branchSelect.value) {
                        fetchSubjects(branchSelect.value);
                    } else {
                        subjectsField.classList.add('hidden');
                        subjectsContainer.innerHTML = '';
                    }
                } else {
                    branchField.classList.add('hidden');
                    branchSelect.required = false;
                    subjectsField.classList.add('hidden');
                    subjectsContainer.innerHTML = '';
                }
            }

            function fetchSubjects(branchId) {
                if (!branchId) {
                    subjectsField.classList.add('hidden');
                    subjectsContainer.innerHTML = '';
                    return;
                }
                fetch("{{ url('admin/branches') }}/" + branchId + "/subjects")
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        // Get currently selected subjects from the DOM
                        let selectedSubjects = getSelectedSubjects();
                        if (data.subjects && data.subjects.length > 0) {
                            data.subjects.forEach(subject => {
                                let checked = selectedSubjects.includes(subject.id.toString()) ? 'checked' : '';
                                html += `
                                <div class="flex flex-row items-center gap-2">
                                    <input type="checkbox" id="subject_${subject.id}" name="subjects[]" value="${subject.id}" class="border-gray-300 rounded w-4 h-4 text-blue-600" ${checked}>
                                    <label for="subject_${subject.id}" class="ml-2 text-gray-700">${subject.name}</label>
                                </div>
                                `;
                            });
                        }
                        subjectsContainer.innerHTML = html;
                        subjectsField.classList.remove('hidden');
                    });
            }

            typeField.addEventListener('change', function() {
                toggleBranchField();
            });

            branchSelect.addEventListener('change', function() {
                fetchSubjects(this.value);
            });

            // Initial state
            toggleBranchField();
            if (typeField.value === 'مؤطر دراسي' && branchSelect.value) {
                fetchSubjects(branchSelect.value);
            }
        });
    </script>
    @endsection
</body>

</html>