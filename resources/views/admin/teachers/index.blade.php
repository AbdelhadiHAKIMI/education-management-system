<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الأساتذة - ثانوية الإخوة عمور</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .teacher-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation (Same as your dashboard) -->
    <nav class="bg-blue-800 shadow-lg text-white">
        <!-- ... Your existing nav code ... -->
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as your dashboard) -->
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <!-- ... Your existing sidebar code ... -->
        </aside>

        <!-- Teachers Page Content -->
        <main class="flex-1 p-8">
            <!-- Header with Actions -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">إدارة الأساتذة</h1>
                    <p class="text-gray-600">قائمة بجميع أساتذة المؤسسة</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <!-- CSV Upload Button -->
                    <button onclick="openCSVModal()" class="flex items-center space-x-2 space-x-reverse bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                        <i class="fas fa-file-import"></i>
                        <span>رفع ملف CSV</span>
                    </button>
                    <!-- Add New Teacher Button -->
                    <button onclick="openAddModal()" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <i class="fas fa-plus"></i>
                        <span>أضف أستاذاً</span>
                    </button>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white shadow-md mb-6 p-4 rounded-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="relative flex-1">
                        <input type="text" placeholder="ابحث عن أستاذ..." 
                               class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <select class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                            <option>فرز حسب الأقدم</option>
                            <option>فرز حسب الأحدث</option>
                            <option>فرز حسب الاسم</option>
                        </select>
                        <select class="border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                            <option>عرض الكل</option>
                            <option>الأساتذة النشطين</option>
                            <option>الأساتذة المتوقفين</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Teachers Table -->
            <div class="bg-white shadow-md overflow-hidden rounded-lg">
                <table class="min-w-full teacher-table">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-right">#</th>
                            <th class="px-6 py-3 text-right">الصورة</th>
                            <th class="px-6 py-3 text-right">الاسم الكامل</th>
                            <th class="px-6 py-3 text-right">البريد الإلكتروني</th>
                            <th class="px-6 py-3 text-right">الهاتف</th>
                            <th class="px-6 py-3 text-right">التخصص</th>
                            <th class="px-6 py-3 text-right">الحالة</th>
                            <th class="px-6 py-3 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Sample Data Row 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-500">1</td>
                            <td class="px-6 py-4">
                                <img src="https://ui-avatars.com/api/?name=أحمد+علي&background=random" 
                                     class="rounded-full w-10 h-10" 
                                     alt="صورة الأستاذ">
                            </td>
                            <td class="px-6 py-4 font-medium">أحمد علي محمد</td>
                            <td class="px-6 py-4 text-gray-500">ahmed.ali@example.com</td>
                            <td class="px-6 py-4 text-gray-500">0551234567</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">الرياضيات</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs">نشط</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2 space-x-reverse">
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- More rows... -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                    <div class="text-gray-500 text-sm">
                        عرض <span class="font-medium">1</span> إلى <span class="font-medium">10</span> من <span class="font-medium">24</span> نتائج
                    </div>
                    <div class="flex space-x-2 space-x-reverse">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            السابق
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-50">
                            التالي
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Teacher Modal -->
    <div id="addTeacherModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b border-gray-200 p-4">
                <h3 class="font-bold text-lg">إضافة أستاذ جديد</h3>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="p-6 space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">الاسم الكامل</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">رقم الهاتف</label>
                    <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">التخصص</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option>الرياضيات</option>
                        <option>الفيزياء</option>
                        <option>اللغة العربية</option>
                        <option>اللغة الفرنسية</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">الحالة</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option>نشط</option>
                        <option>غير نشط</option>
                    </select>
                </div>
                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3 space-x-reverse">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        إلغاء
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- CSV Upload Modal -->
    <div id="csvModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center border-b border-gray-200 p-4">
                <h3 class="font-bold text-lg">رفع ملف الأساتذة</h3>
                <button onclick="closeCSVModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="fas fa-file-csv text-4xl text-blue-500 mb-3"></i>
                    <p class="text-gray-500 mb-4">اسحب وأسقط ملف CSV هنا أو انقر للاختيار</p>
                    <input type="file" accept=".csv" class="hidden" id="csvFileInput">
                    <button onclick="document.getElementById('csvFileInput').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        اختر ملف
                    </button>
                </div>
                <div class="text-center">
                    <a href="#" onclick="downloadCSVTemplate()" class="text-blue-600 hover:underline">
                        <i class="fas fa-download mr-1"></i> تحميل نموذج CSV
                    </a>
                </div>
                <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3 space-x-reverse">
                    <button onclick="closeCSVModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        إلغاء
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        رفع الملف
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openAddModal() {
            document.getElementById('addTeacherModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addTeacherModal').classList.add('hidden');
        }
        function openCSVModal() {
            document.getElementById('csvModal').classList.remove('hidden');
        }
        function closeCSVModal() {
            document.getElementById('csvModal').classList.add('hidden');
        }
        function downloadCSVTemplate() {
            // In a real app, this would download a CSV template file
            alert("جارٍ تحميل نموذج CSV...");
            // Example columns: الاسم الكامل,البريد الإلكتروني,الهاتف,التخصص,الحالة
        }
    </script>
</body>
</html>