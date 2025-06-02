<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مؤسسة جديدة - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation (Same as WebMaster Dashboard) -->

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as WebMaster Dashboard) -->

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إضافة مؤسسة جديدة</h1>
                    <p class="text-gray-600">املأ النموذج لإضافة مؤسسة تعليمية جديدة للنظام</p>
                </div>
                <a href="{{ route('webmaster.dashboard') }}" class="flex items-center space-x-2 space-x-reverse bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-gray-800">
                    <i class="fa-arrow-right fas"></i>
                    <span>رجوع</span>
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('webmaster.establishments.store') }}" enctype="multipart/form-data">
                        @csrf
                        {{-- Show validation errors --}}
                        @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        {{-- Show session error --}}
                        @if (session('error'))
                        <div class="mb-4 text-red-600">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                            <!-- Establishment Info -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات المؤسسة</h3>
                            </div>

                            <div>
                                <label for="name_ar" class="block mb-2 text-gray-700">اسم المؤسسة (العربية) <span class="text-red-500">*</span></label>
                                <input type="text" id="name_ar" name="name_ar" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="اسم المؤسسة باللغة العربية" required>
                            </div>

                            <div>
                                <label for="status" class="block mb-2 text-gray-700">الحالة <span class="text-red-500">*</span></label>
                                <select id="status" name="is_active" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                                    <option value="true">نشطة</option>
                                    <option value="false">غير نشطة</option>
                                </select>
                            </div>

                            <div>
                                <label for="address" class="block mb-2 text-gray-700">العنوان <span class="text-red-500">*</span></label>
                                <input type="text" id="location" name="location" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="عنوان المؤسسة" required>
                            </div>

                            <div>
                                <label for="wilaya" class="block mb-2 text-gray-700">الولاية <span class="text-red-500">*</span></label>
                                <input type="text" id="wilaya" name="wilaya" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="الولاية" required>
                            </div>

                            <div>
                                <label for="phone" class="block mb-2 text-gray-700">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="مثال: 0550123456">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-gray-700">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="example@domain.com">
                            </div>

                            <!-- Logo Upload -->
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-gray-700">شعار المؤسسة</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="relative bg-gray-100 border border-gray-300 rounded-full w-20 h-20 overflow-hidden">
                                            <img id="logo-preview" src="" alt="Logo preview" class="hidden absolute inset-0 w-full h-full object-cover">
                                            <svg id="logo-placeholder" class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <label for="logo-upload" class="inline-flex items-center bg-white hover:bg-gray-50 shadow-sm px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-gray-700 text-sm cursor-pointer">
                                            <i class="ml-2 fas fa-upload"></i>
                                            <span>اختر ملف</span>
                                        </label>
                                        <input id="logo-upload" type="file" name="logo" class="hidden" accept="image/*">
                                        <p class="mt-1 text-gray-500 text-xs">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Info -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات مدير المؤسسة</h3>
                            </div>

                            <div>
                                <label for="admin_name" class="block mb-2 text-gray-700">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" name="admin_name" id="admin_name" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="اسم مدير المؤسسة" required>
                            </div>

                            <div>
                                <label for="admin_email" class="block mb-2 text-gray-700">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" name="admin_email" id="admin_email" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="example@domain.com" required>
                            </div>

                            <div>
                                <label for="admin_password" class="block mb-2 text-gray-700">كلمة المرور <span class="text-red-500">*</span></label>
                                <input type="password" name="admin_password" id="admin_password" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="كلمة مرور المدير" required>
                            </div>

                            <!-- Education Stages & Levels Selection -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">المراحل التعليمية والمستويات</h3>
                                <div id="education-stages-section">
                                    <!-- Stages checkboxes will be rendered here -->
                                </div>
                                <div id="levels-section" class="mt-4">
                                    <!-- Levels checkboxes will be rendered here -->
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 space-x-reverse md:col-span-2 mt-8 pt-6 border-gray-200 border-t">
                                <button type="reset" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-gray-800">
                                    إلغاء
                                </button>
                                <button type="submit" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                                    <i class="fas fa-save"></i>
                                    <span>حفظ المؤسسة</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Logo preview functionality
        document.getElementById('logo-upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logo-preview');
                    const placeholder = document.getElementById('logo-placeholder');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        const secondaryBranches = [
            "شعبة العلوم التجريبية",
            "شعبة الرياضيات",
            "شعبة التقني رياضي",
            "شعبة تسيير واقتصاد",
            "شعبة آداب وفلسفة",
            "شعبة لغات أجنبية"
        ];

        const educationStages = [{
                name: "تحضيرية ",
                key: "pre_school",
                levels: [{
                        year: 1,
                        label: "السنة 1: الحضانة (Crèche)"
                    },
                    {
                        year: 2,
                        label: "السنة 2: التعليم التحضيري (Pré-scolaire)"
                    }
                ]
            },
            {
                name: "  إبتدائية",
                key: "primary",
                levels: [{
                        year: 3,
                        label: "السنة 3: السنة الأولى ابتدائي"
                    },
                    {
                        year: 4,
                        label: "السنة 4: السنة الثانية ابتدائي"
                    },
                    {
                        year: 5,
                        label: "السنة 5: السنة الثالثة ابتدائي"
                    },
                    {
                        year: 6,
                        label: "السنة 6: السنة الرابعة ابتدائي"
                    },
                    {
                        year: 7,
                        label: "السنة 7: السنة الخامسة ابتدائي"
                    }
                ]
            },
            {
                name: "  متوسطة",
                key: "middle",
                levels: [{
                        year: 8,
                        label: "السنة 8: السنة الأولى متوسط"
                    },
                    {
                        year: 9,
                        label: "السنة 9: السنة الثانية متوسط"
                    },
                    {
                        year: 10,
                        label: "السنة 10: السنة الثالثة متوسط"
                    },
                    {
                        year: 11,
                        label: "السنة 11: السنة الرابعة متوسط (BEM)"
                    }
                ]
            },
            {
                name: "  ثانوية",
                key: "secondary",
                levels: [{
                        year: 12,
                        label: "السنة 12: السنة الأولى ثانوي (جذع مشترك)"
                    },
                    {
                        year: 13,
                        label: "السنة 13: السنة الثانية ثانوي – اختيار الشعبة",
                        branches: secondaryBranches
                    },
                    {
                        year: 14,
                        label: "السنة 14: السنة الثالثة ثانوي (BAC)",
                        branches: secondaryBranches // <-- add branches here too
                    }
                ]
            }
        ];

        function renderStages() {
            const container = document.getElementById('education-stages-section');
            container.innerHTML = '';
            educationStages.forEach((stage, idx) => {
                const id = `stage_${idx}`;
                container.innerHTML += `
                    <label class="inline-flex items-center mr-4 mb-2">
                        <input type="checkbox" class="stage-checkbox" value="${stage.key}" data-idx="${idx}">
                        <span class="ml-2">${stage.name}</span>
                    </label>
                `;
            });
        }

        function renderLevels(selectedStages) {
            const levelsContainer = document.getElementById('levels-section');
            levelsContainer.innerHTML = '';
            selectedStages.forEach(idx => {
                const stage = educationStages[idx];
                levelsContainer.innerHTML += `<div class="mb-2 font-semibold">${stage.name}</div>`;
                stage.levels.forEach(level => {
                    const levelId = `level_${stage.key}_${level.year}`;
                    levelsContainer.innerHTML += `
                        <label class="inline-flex items-center mr-4 mb-2">
                            <input type="checkbox" class="level-checkbox" name="levels[]" value="${level.year}" data-stage="${stage.key}" data-year="${level.year}">
                            <span class="ml-2">${level.label}</span>
                        </label>
                    `;
                    // If branches exist for this level
                    if (level.branches) {
                        levelsContainer.innerHTML += `<div class="mb-2 ml-6 branches-section" id="branches-for-${level.year}" style="display:none;">
                            <div class="mb-1 font-normal text-sm">اختر الشعبة:</div>
                            ${level.branches.map((branch, bidx) => `
                                <label class="inline-flex items-center mr-2 mb-1">
                                    <input type="checkbox" class="branch-checkbox" name="branches[${level.year}][]" value="${branch}">
                                    <span class="ml-1">${branch}</span>
                                </label>
                            `).join('')}
                        </div>`;
                    }
                });
            });

            // Add event listeners for levels with branches
            document.querySelectorAll('.level-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const year = this.getAttribute('data-year');
                    const branchDiv = document.getElementById('branches-for-' + year);
                    if (branchDiv) {
                        branchDiv.style.display = this.checked ? 'block' : 'none';
                        // Uncheck all branches if level is unchecked
                        if (!this.checked) {
                            branchDiv.querySelectorAll('input[type=checkbox]').forEach(bcb => bcb.checked = false);
                        }
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderStages();

            // Handle stage selection
            document.getElementById('education-stages-section').addEventListener('change', function() {
                const selectedStages = Array.from(document.querySelectorAll('.stage-checkbox'))
                    .map((cb, idx) => cb.checked ? parseInt(cb.getAttribute('data-idx')) : null)
                    .filter(idx => idx !== null);
                renderLevels(selectedStages);
            });
        });
    </script>
</body>

</html>