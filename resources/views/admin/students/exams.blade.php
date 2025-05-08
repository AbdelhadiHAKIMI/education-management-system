<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الاختبارات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        .exam-card { transition: all 0.3s ease; }
        .exam-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-800 shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+الاختبارات&background=random" class="rounded-full w-8 h-8">
                    <span>مدير الاختبارات</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <aside class="top-0 sticky bg-white shadow-md w-64 h-screen">
            <div class="p-4">
                <ul class="space-y-2 mt-6">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-clipboard-check"></i>
                            <span>الاختبارات</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chart-bar"></i>
                            <span>التقارير</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-file-import"></i>
                            <span>استيراد النتائج</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-bold text-gray-800 text-2xl">إدارة الاختبارات</h1>
                <div class="flex space-x-3 space-x-reverse">
                    <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <i class="mr-2 fas fa-file-import"></i> استيراد CSV
                    </button>
                    <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white">
                        <i class="mr-2 fas fa-plus"></i> اختبار جديد
                    </button>
                </div>
            </div>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3 mb-8">
                <!-- Exam Card 1 -->
                <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden exam-card">
                    <div class="bg-blue-600 p-4 text-white">
                        <h3 class="font-bold text-lg">اختبار منتصف الفصل - الرياضيات</h3>
                        <p class="mt-1 text-blue-100 text-sm">15 نوفمبر 2023</p>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-gray-500 text-sm">عدد الطلاب</p>
                                <p class="font-medium">45</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">المعدل</p>
                                <p class="font-medium">14.5/20</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 space-x-reverse pt-3 border-gray-200 border-t">
                            <a href="#" class="flex-1 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded text-blue-600 text-sm text-center">
                                <i class="mr-1 fas fa-chart-bar"></i> النتائج
                            </a>
                            <a href="#" class="flex-1 bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded text-gray-600 text-sm text-center">
                                <i class="mr-1 fas fa-edit"></i> تعديل
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Exam Card 2 -->
                <div class="bg-white shadow-md border border-gray-200 rounded-lg overflow-hidden exam-card">
                    <div class="bg-green-600 p-4 text-white">
                        <h3 class="font-bold text-lg">اختبار اللغة الإنجليزية</h3>
                        <p class="mt-1 text-green-100 text-sm">5 نوفمبر 2023</p>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-gray-500 text-sm">عدد الطلاب</p>
                                <p class="font-medium">32</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">المعدل</p>
                                <p class="font-medium">12.8/20</p>
                            </div>
                        </div>
                        <div class="flex space-x-2 space-x-reverse pt-3 border-gray-200 border-t">
                            <a href="#" class="flex-1 bg-green-50 hover:bg-green-100 px-3 py-2 rounded text-green-600 text-sm text-center">
                                <i class="mr-1 fas fa-chart-bar"></i> النتائج
                            </a>
                            <a href="#" class="flex-1 bg-gray-50 hover:bg-gray-100 px-3 py-2 rounded text-gray-600 text-sm text-center">
                                <i class="mr-1 fas fa-print"></i> طباعة
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md mb-8 p-6 rounded-lg">
                <h2 class="mb-4 font-semibold text-gray-800 text-xl">إحصائيات الاختبارات</h2>
                <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                    <div>
                        <canvas id="subjectPerformanceChart" height="250"></canvas>
                    </div>
                    <div>
                        <canvas id="successRateChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 border-gray-200 border-b">
                    <h2 class="font-semibold text-gray-800 text-xl">نتائج آخر اختبار</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-right">الترتيب</th>
                                <th class="px-4 py-3 text-right">اسم الطالب</th>
                                <th class="px-4 py-3 text-right">المعدل</th>
                                <th class="px-4 py-3 text-right">الرياضيات</th>
                                <th class="px-4 py-3 text-right">الفيزياء</th>
                                <th class="px-4 py-3 text-right">اللغة العربية</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">1</td>
                                <td class="px-4 py-3">محمد أحمد عبد الله</td>
                                <td class="px-4 py-3 font-bold text-green-600">17.5</td>
                                <td class="px-4 py-3">18</td>
                                <td class="px-4 py-3">16</td>
                                <td class="px-4 py-3">18.5</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">2</td>
                                <td class="px-4 py-3">آمنة خالد قاسم</td>
                                <td class="px-4 py-3 font-bold text-green-600">16.2</td>
                                <td class="px-4 py-3">17</td>
                                <td class="px-4 py-3">15.5</td>
                                <td class="px-4 py-3">16</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Subject Performance Chart
        const subjectCtx = document.getElementById('subjectPerformanceChart').getContext('2d');
        new Chart(subjectCtx, {
            type: 'bar',
            data: {
                labels: ['الرياضيات', 'الفيزياء', 'اللغة العربية', 'اللغة الإنجليزية', 'التاريخ'],
                datasets: [{
                    label: 'متوسط الدرجات',
                    data: [14.5, 12.8, 15.2, 13.7, 11.9],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'أداء المواد الدراسية',
                        font: {
                            size: 16,
                            family: 'Tajawal'
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                }
            }
        });

        // Success Rate Chart
        const successCtx = document.getElementById('successRateChart').getContext('2d');
        new Chart(successCtx, {
            type: 'pie',
            data: {
                labels: ['ناجح بامتياز', 'ناجح', 'راسب'],
                datasets: [{
                    data: [25, 60, 15],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(239, 68, 68, 0.7)'
                    ],
                    borderColor: [
                        'rgba(16, 185, 129, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(239, 68, 68, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'نسبة النجاح',
                        font: {
                            size: 16,
                            family: 'Tajawal'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>