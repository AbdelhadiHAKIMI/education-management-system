<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مؤطر - برنامج الطالب المتفوق</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body {
            font-family: 'Tajawal', sans-serif;
        }
        input[type="checkbox"] { /* Add styles for checkboxes if you use them */
            accent-color: #3b82f6; /* This matches Tailwind's blue-600 */
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
                    <span class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" class="rounded-full w-8 h-8" alt="صورة المستخدم">
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4 border-gray-200 border-b">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" class="rounded-full w-10 h-10" alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        {{-- Commented out the link to levels.index --}}
                        {{-- <a href="{{ route('admin.levels.index') }}" --}}
                        <a href="#" {{-- Change href to # or remove if not needed --}}
                           class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fa-layer-group fas"></i>
                            <span>المستويات الدراسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلبة</span>
                            <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $studentCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.staffs.index') }}" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المؤطرين</span>
                            <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">{{ $staffCount }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-calendar-alt"></i>
                            <span>البرامج التعليمية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-user-check"></i>
                            <span>الحضور والغياب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>المدفوعات المالية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chart-bar"></i>
                            <span>التقارير والإحصائيات</span>
                        </a>
                    </li>

                    <div class="mt-8 pt-4 border-gray-200 border-t">
                        <a href="{{ route('logout') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </div>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="bg-white shadow-md p-6 rounded-lg max-w-3xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">تعديل بيانات المؤطر</h1>
                    <a href="{{ route('admin.staffs.index') }}" class="text-blue-600 hover:underline">العودة للقائمة</a>
                </div>

                <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="full_name" class="block text-gray-700 mb-2">الاسم الكامل *</label>
                            <input type="text" id="full_name" name="full_name" 
                                   value="{{ old('full_name', $staff->full_name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_date" class="block text-gray-700 mb-2">تاريخ الميلاد *</label>
                            <input type="date" id="birth_date" name="birth_date" 
                                   value="{{ old('birth_date', $staff->birth_date ? $staff->birth_date->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-gray-700 mb-2">رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="{{ old('phone', $staff->phone) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bac_year" class="block text-gray-700 mb-2">سنة البكالوريا</label>
                            <input type="number" id="bac_year" name="bac_year" min="1900" max="{{ date('Y') + 1 }}"
                                   value="{{ old('bac_year', $staff->bac_year) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('bac_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="univ_specialty" class="block text-gray-700 mb-2">التخصص الجامعي</label>
                            <input type="text" id="univ_specialty" name="univ_specialty" 
                                   value="{{ old('univ_specialty', $staff->univ_specialty) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('univ_specialty')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                         <div>
                            <label for="type" class="block text-gray-700 mb-2">نوع الموظف *</label>
                            <select id="type" name="type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    required onchange="toggleAcademicFields()">
                                <option value="">اختر نوع الموظف</option>
                                <option value="إداري" @selected(old('type', $staff->type) == 'إداري')>إداري</option>
                                <option value="مؤطر دراسي" @selected(old('type', $staff->type) == 'مؤطر دراسي')>مؤطر دراسي</option>
                                <option value="خدمات" @selected(old('type', $staff->type) == 'خدمات')>خدمات</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="academic_fields" class="{{ old('type', $staff->type) == 'مؤطر دراسي' ? '' : 'hidden' }} md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="branch_id" class="block text-gray-700 mb-2">الشعبة *</label>
                                <select id="branch_id" name="branch_id" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">اختر الشعبة</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" 
                                            @selected(old('branch_id', $staff->branch_id) == $branch->id)>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subjects" class="block text-gray-700 mb-2">المواد الدراسية</label>
                                <div class="space-y-2" id="subjects_container">
                                    {{-- Subjects checkboxes will be loaded here by JavaScript --}}
                                </div>
                                @error('subjects')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('subjects.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end space-x-3 space-x-reverse">
                        <a href="{{ route('admin.staffs.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            إلغاء
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const academicFields = document.getElementById('academic_fields');
            const branchSelect = document.getElementById('branch_id');
            const subjectsContainer = document.getElementById('subjects_container');
            const subjectsField = academicFields.querySelector('#subjects_field'); // Ensure subjectsField refers to the div

            // Function to fetch and display subjects
            async function loadSubjects(branchId, selectedSubjects = []) {
                subjectsContainer.innerHTML = ''; // Clear previous subjects

                if (branchId) {
                    try {
                        const response = await fetch(`/admin/branches/${branchId}/subjects`);
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
                            // No need to explicitly show/hide subjectsField div here,
                            // as it's controlled by toggleAcademicFields().
                            // But we should ensure the container is visible if subjects are loaded
                            subjectsContainer.closest('div').classList.remove('hidden');

                        } else {
                            subjectsContainer.closest('div').classList.add('hidden'); // Hide if no subjects
                        }
                    } catch (error) {
                        console.error('Error fetching subjects:', error);
                        subjectsContainer.innerHTML = '<p class="text-red-600">حدث خطأ أثناء تحميل المواد.</p>';
                        subjectsContainer.closest('div').classList.add('hidden');
                    }
                } else {
                    subjectsContainer.closest('div').classList.add('hidden'); // Hide if no branch selected
                }
            }

            function toggleAcademicFields(initialLoad = false) {
                // Safely get elements to prevent null reference errors
                const staffType = typeSelect.value;
                const branchField = document.getElementById('branch_field'); // Re-get for safety
                const branchSelectedValue = branchSelect.value;

                if (staffType === 'مؤطر دراسي') {
                    branchField.classList.remove('hidden');
                    branchSelect.setAttribute('required', 'required');

                    if (branchSelectedValue) {
                        const preselectedSubjects = initialLoad && {{ $staff->exists ? 'true' : 'false' }} ?
                            @json($staff->subjects->pluck('id')->map(fn($id) => (string) $id)->toArray()) :
                            (old('subjects') ? @json(old('subjects')) : []); // Handle old input for subjects
                        loadSubjects(branchSelectedValue, preselectedSubjects);
                    } else {
                        subjectsContainer.closest('div').classList.add('hidden');
                        subjectsContainer.innerHTML = '';
                    }
                } else {
                    branchField.classList.add('hidden');
                    branchSelect.removeAttribute('required');
                    branchSelect.value = ''; // Clear selected branch
                    subjectsContainer.closest('div').classList.add('hidden'); // Hide subjects field
                    subjectsContainer.innerHTML = ''; // Clear subjects
                }
            }

            // Event Listeners
            typeSelect.addEventListener('change', () => {
                toggleAcademicFields(false); // Not initial load
            });

            branchSelect.addEventListener('change', function() {
                if (typeSelect.value === 'مؤطر دراسي') {
                    // When branch changes, clear old subjects and load new ones
                    loadSubjects(this.value, []);
                }
            });

            // Initial call to set state based on existing data or old input
            // Use setTimeout to ensure all DOM elements are rendered before running logic
            setTimeout(() => toggleAcademicFields(true), 0);
        });
    </script>
</body>
</html>