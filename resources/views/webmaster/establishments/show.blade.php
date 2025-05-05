<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المؤسسة - نظام الإدارة التعليمية</title>
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
                    <h1 class="font-bold text-gray-800 text-2xl">ثانوية الإخوة عمور</h1>
                    <p class="text-gray-600">تفاصيل المؤسسة التعليمية</p>
                </div>
                <a href="index.html" class="flex items-center space-x-2 space-x-reverse bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-gray-800">
                    <i class="fa-arrow-right fas"></i>
                    <span>رجوع</span>
                </a>
            </div>
            
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات المؤسسة</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-500">الاسم بالعربية</p>
                                    <p class="font-medium">ثانوية الإخوة عمور</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">الاسم بالفرنسية</p>
                                    <p class="font-medium">Lycée des Frères Ammour</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">نوع المؤسسة</p>
                                    <p class="font-medium">ثانوية</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">العنوان</p>
                                    <p class="font-medium">شارع العربي بن مهيدي، البليدة</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات الاتصال</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-gray-500">الولاية</p>
                                    <p class="font-medium">البليدة</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">رقم الهاتف</p>
                                    <p class="font-medium">025123456</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">البريد الإلكتروني</p>
                                    <p class="font-medium">contact@lycee-ammour.edu.dz</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">الحالة</p>
                                    <p class="font-medium"><span class="bg-green-100 px-2 py-1 rounded-full text-green-800 text-sm">نشطة</span></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">مدير المؤسسة</h3>
                            <div class="flex items-center space-x-4 space-x-reverse bg-gray-50 p-4 rounded-lg">
                                <img src="https://ui-avatars.com/api/?name=عبد+القادر+بن+عمر&background=random" 
                                     class="rounded-full w-16 h-16" 
                                     alt="صورة المدير">
                                <div>
                                    <p class="font-bold">عبد القادر بن عمر</p>
                                    <p class="text-gray-600">مدير المؤسسة</p>
                                    <p class="mt-1 text-gray-500 text-sm"><i class="mr-1 fas fa-phone"></i> 0550123456</p>
                                    <p class="text-gray-500 text-sm"><i class="mr-1 fas fa-envelope"></i> directeur@lycee-ammour.edu.dz</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">إحصائيات</h3>
                            <div class="gap-4 grid grid-cols-2 md:grid-cols-4">
                                <div class="bg-blue-50 p-4 rounded-lg text-center">
                                    <p class="font-bold text-blue-600 text-2xl">324</p>
                                    <p class="text-gray-600">طالب</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg text-center">
                                    <p class="font-bold text-green-600 text-2xl">24</p>
                                    <p class="text-gray-600">أستاذ</p>
                                </div>
                                <div class="bg-yellow-50 p-4 rounded-lg text-center">
                                    <p class="font-bold text-yellow-600 text-2xl">6</p>
                                    <p class="text-gray-600">برنامج نشط</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg text-center">
                                    <p class="font-bold text-purple-600 text-2xl">89%</p>
                                    <p class="text-gray-600">نسبة الحضور</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-6 border-gray-200 border-t">
                        <a href="index.html" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-gray-800">
                            رجوع
                        </a>
                        <a href="create.html" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            <i class="fas fa-edit"></i>
                            <span>تعديل</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>