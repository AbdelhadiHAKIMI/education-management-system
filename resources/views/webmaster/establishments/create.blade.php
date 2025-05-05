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
                <a href="#" class="flex items-center space-x-2 space-x-reverse bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-gray-800">
                    <i class="fa-arrow-right fas"></i>
                    <span>رجوع</span>
                </a>
            </div>
            
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form>
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                            <!-- Establishment Info -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات المؤسسة</h3>
                            </div>
                            
                            <div>
                                <label for="name_ar" class="block mb-2 text-gray-700">اسم المؤسسة (العربية) <span class="text-red-500">*</span></label>
                                <input type="text" id="name_ar" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="اسم المؤسسة باللغة العربية" required>
                            </div>
                            
                            <div>
                                <label for="name_fr" class="block mb-2 text-gray-700">Nom de l'établissement (Français)</label>
                                <input type="text" id="name_fr" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="Nom de l'établissement en français">
                            </div>
                            
                            <div>
                                <label for="type" class="block mb-2 text-gray-700">نوع المؤسسة <span class="text-red-500">*</span></label>
                                <select id="type" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                                    <option value="">اختر نوع المؤسسة</option>
                                    <option value="high_school">ثانوية</option>
                                    <option value="middle_school">متوسطة</option>
                                    <option value="primary_school">ابتدائية</option>
                                    <option value="training_center">مركز تكوين</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="status" class="block mb-2 text-gray-700">الحالة <span class="text-red-500">*</span></label>
                                <select id="status" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                                    <option value="active">نشطة</option>
                                    <option value="inactive">غير نشطة</option>
                                    <option value="pending">في انتظار التفعيل</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="address" class="block mb-2 text-gray-700">العنوان <span class="text-red-500">*</span></label>
                                <input type="text" id="address" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="عنوان المؤسسة" required>
                            </div>
                            
                            <div>
                                <label for="wilaya" class="block mb-2 text-gray-700">الولاية <span class="text-red-500">*</span></label>
                                <select id="wilaya" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" required>
                                    <option value="">اختر الولاية</option>
                                    <option value="16">الجزائر</option>
                                    <option value="31">وهران</option>
                                    <option value="19">سطيف</option>
                                    <option value="9">البليدة</option>
                                    <!-- Add all Algerian wilayas -->
                                </select>
                            </div>
                            
                            <div>
                                <label for="phone" class="block mb-2 text-gray-700">رقم الهاتف</label>
                                <input type="tel" id="phone" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="مثال: 0550123456">
                            </div>
                            
                            <div>
                                <label for="email" class="block mb-2 text-gray-700">البريد الإلكتروني</label>
                                <input type="email" id="email" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="example@domain.com">
                            </div>
                            
                            <!-- Admin Info -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات مدير المؤسسة</h3>
                            </div>
                            
                            <div>
                                <label for="admin_name" class="block mb-2 text-gray-700">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" id="admin_name" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="اسم مدير المؤسسة" required>
                            </div>
                            
                            <div>
                                <label for="admin_phone" class="block mb-2 text-gray-700">رقم الهاتف <span class="text-red-500">*</span></label>
                                <input type="tel" id="admin_phone" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="مثال: 0550123456" required>
                            </div>
                            
                            <div>
                                <label for="admin_email" class="block mb-2 text-gray-700">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" id="admin_email" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="example@domain.com" required>
                            </div>
                            
                            <div>
                                <label for="admin_password" class="block mb-2 text-gray-700">كلمة المرور <span class="text-red-500">*</span></label>
                                <input type="password" id="admin_password" class="px-4 py-2 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="كلمة مرور المدير" required>
                            </div>
                            
                            <!-- Logo Upload -->
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-gray-700">شعار المؤسسة</label>
                                <div class="flex items-center mt-1">
                                    <span class="inline-block bg-gray-100 rounded-full w-12 h-12 overflow-hidden">
                                        <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                    <button type="button" class="bg-white hover:bg-gray-50 shadow-sm mr-3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-gray-700 text-sm leading-4">
                                        تغيير
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 space-x-reverse mt-8 pt-6 border-gray-200 border-t">
                            <button type="button" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-gray-800">
                                إلغاء
                            </button>
                            <button type="submit" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                                <i class="fas fa-save"></i>
                                <span>حفظ المؤسسة</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>