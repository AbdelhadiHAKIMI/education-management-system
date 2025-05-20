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
    <x-admin.navigation />
    <div class="flex">
        <x-admin.sidebar />
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