<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستويات</title>
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
    <!-- Navigation -->
    <nav class="bg-blue-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            @php
            $user = Auth::user();
            // Get the establishment where the user is admin
            $establishment = \App\Models\Establishment::where('id', $user->establishment_id)
            ->when($user->role === 'admin', function ($query) use ($user) {
            return $query;
            })
            ->first();
            $establishmentName = $establishment ? $establishment->name : 'اسم المؤسسة غير متوفر';
            $establishmentLogo = $establishment && $establishment->logo ? asset('storage/' . $establishment->logo) : null;

            // Academic years logic
            use App\Models\AcademicYear;
            $academicYears = [];
            $activeAcademicYear = null;
            if ($establishment) {
            $academicYears = AcademicYear::where('establishment_id', $establishment->id)
            ->orderByDesc('end_date')
            ->get();
            $activeAcademicYear = AcademicYear::where('establishment_id', $establishment->id)
            ->where('status', true)
            ->first();
            }
            @endphp
            <div class="flex items-center space-x-4 space-x-reverse">
                <!-- <i class="text-2xl fas fa-graduation-cap"></i> -->
                @if($establishmentLogo)
                <img src="{{ $establishmentLogo }}" alt="شعار المؤسسة" class="ml-2 border rounded-full w-10 h-10">
                @endif
                <span class="font-semibold text-xl">مؤسسة {{ $establishmentName }}</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المدرسة" class="rounded-full w-8 h-8" alt="صورة المستخدم">
                    <span>مدير المدرسة</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4 border-gray-200 border-b">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المدرسة" class="rounded-full w-10 h-10" alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">{{ Auth::user()->name ?? 'اسم المستخدم' }}</p>
                        <p class="text-gray-500 text-xs">مدير المدرسة</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fa-layer-group fas"></i>
                            <span>المستويات الدراسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلاب</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>المعلمين</span>
                        </a>
                    </li>
                    <li class="mt-8 pt-4 border-gray-200 border-t">
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-1 p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">إدارة المستويات الدراسية</h1>
                <button onclick="openAddLevelModal()" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    <i class="fas fa-plus"></i>
                    <span>إضافة مستوى</span>
                </button>
            </div>

            <!-- Levels Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="divide-y divide-gray-200 min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-right uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-right uppercase tracking-wider">اسم المستوى</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-right uppercase tracking-wider">السنة الدراسية</th>
                                <th class="px-6 py-3 font-medium text-gray-500 text-xs text-right uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($levels as $index => $level)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-500 text-sm whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 text-sm whitespace-nowrap">{{ $level->name }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm whitespace-nowrap">{{ $level->academicYear->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-medium text-sm whitespace-nowrap">
                                    <form action="{{ route('admin.levels.destroy', $level->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذا المستوى؟')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <button onclick="editLevel('{{ $level->id }}')" class="mr-3 text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add/Edit Level Modal -->
            <div id="addLevelModal" class="hidden fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
                <div class="bg-white shadow-xl rounded-lg w-full max-w-md">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-lg" id="modalTitle">إضافة مستوى جديد</h3>
                            <button onclick="closeAddLevelModal()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="levelForm" method="POST" action="{{ route('admin.levels.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" name="level_id" id="levelId">
                            <div class="mb-4">
                                <label class="block mb-2 text-gray-700">اسم المستوى</label>
                                <input type="text" name="name" id="levelNameInput" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-gray-700">السنة الدراسية</label>
                                <select name="academic_year_id" id="academicYearSelect" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                                    <option value="">اختر السنة الدراسية</option>
                                    @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3 space-x-reverse">
                                <button type="button" onclick="closeAddLevelModal()" class="hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg">إلغاء</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="hidden fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
                <div class="bg-white shadow-xl rounded-lg w-full max-w-md">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex flex-shrink-0 justify-center items-center bg-red-100 mx-3 rounded-full w-12 h-12">
                                <i class="text-red-600 fas fa-exclamation"></i>
                            </div>
                            <div>
                                <h3 class="mb-2 font-bold text-lg">تأكيد الحذف</h3>
                                <p class="text-gray-600">هل أنت متأكد من رغبتك في حذف هذا المستوى؟ سيتم حذف جميع البيانات المرتبطة به.</p>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 space-x-reverse mt-6">
                            <button onclick="closeDeleteModal()" class="hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg">إلغاء</button>
                            <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white">حذف</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Modal functions
        function openAddLevelModal() {
            document.getElementById('addLevelModal').classList.remove('hidden');
            document.getElementById('modalTitle').innerText = 'إضافة مستوى جديد';
            document.getElementById('levelForm').action = "{{ route('admin.levels.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('levelNameInput').value = '';
            document.getElementById('academicYearSelect').value = '';
            document.getElementById('levelId').value = '';
        }

        function closeAddLevelModal() {
            document.getElementById('addLevelModal').classList.add('hidden');
        }

        function editLevel(id) {
            fetch("{{ url('admin/levels') }}/" + id)
                .then(response => response.json())
                .then(data => {
                    openAddLevelModal();
                    document.getElementById('modalTitle').innerText = 'تعديل المستوى';
                    document.getElementById('levelForm').action = "{{ url('admin/levels') }}/" + id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('levelNameInput').value = data.name;
                    document.getElementById('academicYearSelect').value = data.academic_year_id;
                    document.getElementById('levelId').value = id;
                });
        }

        // Modal close on outside click
        window.onclick = function(event) {
            if (event.target == document.getElementById('addLevelModal')) {
                closeAddLevelModal();
            }
            if (event.target == document.getElementById('deleteModal')) {
                closeDeleteModal();
            }
        }
    </script>
</body>

</html>