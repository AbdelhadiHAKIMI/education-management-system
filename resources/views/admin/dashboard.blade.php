<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - مدير المؤسسة</title>
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
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">ثانوية الإخوة عمور</span>
            </div>
            
            <div class="flex items-center space-x-6 space-x-reverse">
                <div class="group relative">
                    <button class="flex items-center space-x-2 space-x-reverse bg-blue-700 px-3 py-1 rounded-lg">
                        <i class="fas fa-calendar-alt"></i>
                        <span>2023/2024</span>
                        <i class="text-xs fas fa-chevron-down"></i>
                    </button>
                    <div class="hidden group-hover:block right-0 z-10 absolute bg-white shadow-lg mt-2 rounded-md w-48">
                        <div class="py-1">
                            <div class="bg-gray-100 px-4 py-2 font-semibold text-dark">السنوات الدراسية</div>
                            <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">
                                <span class="font-medium">2023/2024</span>
                                <span class="bg-green-100 mr-2 px-2 py-1 rounded-full text-green-800 text-xs">نشطة</span>
                            </a>
                            <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">2022/2023</a>
                            <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-dark">2021/2022</a>
                            <div class="border-gray-200 border-t"></div>
                            <a href="#" class="block hover:bg-gray-100 px-4 py-2 text-primary">
                                <i class="mr-2 fas fa-plus"></i> سنة جديدة
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#" class="relative hover:text-blue-200">
                    <i class="fas fa-bell"></i>
                    <span class="-top-2 -right-2 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 text-white text-xs">5</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+المؤسسة&background=random" 
                         class="rounded-full w-8 h-8" 
                         alt="صورة المستخدم">
                    <span>مدير المؤسسة</span>
                    <i class="text-xs fas fa-chevron-down"></i>
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
                    <img src="https://ui-avatars.com/api/?name=مدير+المؤسسة&background=random" 
                         class="rounded-full w-10 h-10" 
                         alt="صورة المستخدم">
                    <div>
                        <p class="font-medium">عبد القادر بن عمر</p>
                        <p class="text-gray-500 text-xs">مدير المؤسسة</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <ul class="space-y-2 mt-4">
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse bg-blue-100 p-3 rounded-lg text-blue-800">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>لوحة التحكم</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fa-layer-group fas"></i>
                            <span>المستويات الدراسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-users"></i>
                            <span>الطلاب</span>
                            <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">324</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>الأساتذة</span>
                            <span class="bg-blue-500 px-2 py-1 rounded-full text-white text-xs">24</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/programs/index" class="flex items-center space-x-2 space-x-reverse hover:bg-gray-100 p-3 rounded-lg">
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
                    <a href="#" class="flex items-center space-x-2 space-x-reverse hover:bg-red-50 p-3 rounded-lg text-red-600">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </div>
                </ul>
                
               
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-1 p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-800 text-2xl">لوحة تحكم مدير المؤسسة</h1>
                    <p class="text-gray-600">مرحباً بعودتك، عبد القادر بن عمر</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <button class="flex items-center space-x-2 space-x-reverse bg-white hover:bg-gray-50 px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                        <i class="fas fa-file-export"></i>
                        <span>تصدير البيانات</span>
                    </button>
                    <button class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                        <a href="/admin/programs/create">
                            <i class="fas fa-plus"></i>
                            <span>برنامج جديد</span>
                        </a>
                    </button>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="gap-6 grid grid-cols-1 md:grid-cols-4 mb-8">
                <div class="bg-white shadow-md p-6 border-r-4 border-blue-500 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">الطلاب المسجلين</p>
                            <h3 class="font-bold text-2xl">{{ $studentsCount }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="text-blue-600 fas fa-users"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 8% عن الشهر الماضي
                    </p>
                </div>
                
                <div class="bg-white shadow-md p-6 border-green-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">البرامج النشطة</p>
                            <h3 class="font-bold text-2xl">{{ $programsCount }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="text-green-600 fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 2 برامج جديدة
                    </p>
                </div>
                
                <div class="bg-white shadow-md p-6 border-yellow-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">المدفوعات الشهرية</p>
                            <h3 class="font-bold text-2xl">{{ number_format($monthlyPayments, 0, '.', ',') }} د.ج</h3>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="text-yellow-600 fas fa-donate"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-red-500 text-sm">
                        <i class="fas fa-arrow-down"></i> 12% عن الشهر الماضي
                    </p>
                </div>
                
                <div class="bg-white shadow-md p-6 border-purple-500 border-r-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">نسبة الحضور</p>
                            <h3 class="font-bold text-2xl">{{ $attendanceRate }}%</h3>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="text-purple-600 fas fa-user-check"></i>
                        </div>
                    </div>
                    <p class="mt-2 text-green-500 text-sm">
                        <i class="fas fa-arrow-up"></i> 5% عن الأسبوع الماضي
                    </p>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white shadow-md p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-gray-800 text-xl">أحدث الأنشطة</h2>
                    <a href="#" id="show-all-activities" class="text-blue-600 hover:underline">عرض الكل</a>
                </div>
                <div class="space-y-4" id="activities-list">
                    @foreach($recentActivities as $idx => $activity)
                        <div class="flex items-start space-x-3 space-x-reverse activity-item" style="{{ $idx > 3 ? 'display:none;' : '' }}">
                            <div class="{{ $activity['icon_bg'] }} p-2 rounded-full">
                                <i class="{{ $activity['icon_color'] }} {{ $activity['icon'] }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ $activity['title'] }}</p>
                                <p class="text-gray-500 text-sm">{{ $activity['desc'] }}</p>
                                <p class="text-gray-400 text-xs">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const showAllBtn = document.getElementById('show-all-activities');
        const activityItems = document.querySelectorAll('.activity-item');
        let expanded = false;
        showAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            expanded = !expanded;
            activityItems.forEach((item, idx) => {
                if (expanded) {
                    item.style.display = '';
                } else {
                    item.style.display = idx > 3 ? 'none' : '';
                }
            });
            showAllBtn.textContent = expanded ? 'عرض أقل' : 'عرض الكل';
        });
    });
</script>
</body>
</html>