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
    <nav class="bg-blue-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">برنامج الطالب المتفوق</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <a href="#" class="relative hover:text-blue-200">
                    <i class="fas fa-bell"></i>
                    <span
                        class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random"
                        class="rounded-full w-8 h-8" alt="صورة المستخدم">
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4 border-gray-200 border-b">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random"
                        class="rounded-full w-10 h-10" alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fa-layer-group fas"></i>
                            <span>المستويات الدراسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلبة</span>
                            <span
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $studentCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.staffs.index') }}"
                            class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المؤطرين</span>
                            <span
                                class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $staffCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-calendar-alt"></i>
                            <span>البرامج التعليمية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور والغياب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>المدفوعات المالية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chart-bar"></i>
                            <span>التقارير والإحصائيات</span>
                        </a>
                    </li>

                    <div class="mt-8 pt-4 border-gray-200 border-t">
                        <a href="{{ route('logout') }}"
                            class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="bg-white shadow-md mx-auto p-6 rounded-lg max-w-3xl">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="font-bold text-gray-800 text-2xl">
                        {{ isset($staff) && $staff->exists ? 'تعديل بيانات المؤطر' : 'إضافة مؤطر جديد' }}
                    </h1>
                    <a href="{{ route('admin.staffs.index') }}" class="text-blue-600 hover:underline">العودة
                        للقائمة</a>
                </div>

                <form method="POST"
                    action="{{ isset($staff) && $staff->exists ? route('admin.staffs.update', $staff->id) : route('admin.staffs.store') }}">
                    @csrf
                    @if ($staff->exists)
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

                        <div id="branch_field" class="hidden">
                            <label for="branch_id" class="block mb-2 text-gray-700">الشعبة *</label>
                            <select id="branch_id" name="branch_id"
                                class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-blue-500 w-full">
                                <option value="">اختر الشعبة</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" @selected(old('branch_id', $staff->branch_id ?? '') == $branch->id)>
                                    {{ $branch->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                            <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="subjects_field" class="hidden mt-4">
                            <label class="block mb-2 text-gray-700">المواد الدراسية</label>
                            <div class="space-y-2" id="subjects_container">
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
                            {{ $staff->exists ? 'حفظ التغييرات' : 'إضافة المؤطر' }}
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const branchField = document.getElementById('branch_field');
            const branchSelect = document.getElementById('branch_id');
            const subjectsField = document.getElementById('subjects_field');
            const subjectsContainer = document.getElementById('subjects_container');

            // Function to fetch and display subjects
            async function loadSubjects(branchId, selectedSubjects = []) {
                subjectsContainer.innerHTML = ''; // Clear previous subjects

                if (branchId) {
                    try {
                        const response = await fetch(`/admin/branches/${branchId}/subjects`); // Corrected URL
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const subjects = await response.json();

                        if (subjects.length > 0) {
                            subjects.forEach(subject => {
                                const checkboxDiv = document.createElement('div');
                                checkboxDiv.className = 'flex flex-row items-center gap-2';
                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.id = `subject_${subject.id}`;
                                checkbox.name = 'subjects[]';
                                checkbox.value = subject.id;
                                checkbox.className = 'h-4 w-4 text-blue-600 border-gray-300 rounded';

                                if (selectedSubjects.includes(subject.id.toString())) {
                                    checkbox.checked = true;
                                }

                                const label = document.createElement('label');
                                label.htmlFor = `subject_${subject.id}`;
                                label.className = 'ml-2 text-gray-700';
                                label.textContent = subject.name;

                                checkboxDiv.appendChild(checkbox);
                                checkboxDiv.appendChild(label);
                                subjectsContainer.appendChild(checkboxDiv);
                            });
                            subjectsField.classList.remove('hidden'); // Show subjects field
                        } else {
                            subjectsField.classList.add('hidden'); // Hide if no subjects
                        }
                    } catch (error) {
                        console.error('Error fetching subjects:', error);
                        subjectsContainer.innerHTML = '<p class="text-red-600">حدث خطأ أثناء تحميل المواد.</p>';
                        subjectsField.classList.add('hidden');
                    }
                } else {
                    subjectsField.classList.add('hidden'); // Hide if no branch selected
                }
            }

            function toggleFields(initialLoad = false) {
                if (!typeSelect || !branchField || !branchSelect || !subjectsField || !subjectsContainer) return;

                if (typeSelect.value === 'مؤطر دراسي') {
                    branchField.classList.remove('hidden'); // Show branch field
                    branchSelect.required = true;

                    if (branchSelect.value) {
                        // Only use Blade variables if inside .blade.php and $staff is defined
                        let preselectedSubjects = [];
                        @if(isset($staff) && $staff->exists && isset($staff-> subjects))
                        preselectedSubjects = initialLoad ? @json($staff-> subjects-> pluck('id') - > map(function($id) {
                            return (string) $id;
                        }) - > toArray()) : [];
                        @endif
                        loadSubjects(branchSelect.value, preselectedSubjects);
                    } else {
                        subjectsField.classList.add('hidden'); // Hide subjects if no branch selected yet
                    }
                } else {
                    branchField.classList.add('hidden'); // Hide branch field
                    branchSelect.required = false;
                    branchSelect.value = '';
                    subjectsField.classList.add('hidden'); // Hide subjects field
                    subjectsContainer.innerHTML = ''; // Clear subjects
                }
            }

            // Event Listeners
            typeSelect.addEventListener('change', () => {
                // When type changes, re-evaluate and clear branch/subjects if needed
                toggleFields(false);
                // If the new type is academic, and a branch was previously selected (via old() or staff->branch_id),
                // then trigger branch selection to load subjects for that branch.
                if (typeSelect.value === 'مؤطر دراسي' && branchSelect.value) {
                    // Simulate a change event on branchSelect to re-load subjects
                    // This ensures subjects load if the initial branch was set by old() or edit mode.
                    const event = new Event('change');
                    branchSelect.dispatchEvent(event);
                }
            });

            branchSelect.addEventListener('change', function() {
                if (typeSelect.value === 'مؤطر دراسي') {
                    loadSubjects(this.value, []);
                }
            });

            // Initial call to set state based on existing data or old input
            // This is where we need to be careful not to clear pre-selected branch.
            // Let's call it after a small delay to ensure DOM is fully ready.
            setTimeout(() => toggleFields(true), 0); // Use setTimeout for robustness on initial load
        });
    </script>
</body>

</html>