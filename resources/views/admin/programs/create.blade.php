<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1D4ED8',
                        secondary: '#10B981',
                        accent: '#F59E0B',
                        dark: '#1F2937',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-tajawal">
    <!-- Navigation -->
    <nav class="bg-primary shadow-lg text-white">
        <div class="flex justify-between items-center mx-auto px-4 py-3 container">
            <div class="flex items-center space-x-4 space-x-reverse">
                <i class="text-2xl fas fa-graduation-cap"></i>
                <span class="font-semibold text-xl">نظام الإدارة التعليمية - الجزائر</span>
            </div>
            
            <div class="flex items-center space-x-6 space-x-reverse">
                <!-- Academic Year Selector -->
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
                    <span class="-top-1 -right-1 absolute flex justify-center items-center bg-red-500 rounded-full w-4 h-4 text-white text-xs">3</span>
                </a>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <img src="https://ui-avatars.com/api/?name=مدير+النظام&background=random" 
                         class="rounded-full w-8 h-8" 
                         alt="صورة المستخدم">
                    <span>مدير النظام</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar (Same as before) -->
        
        <!-- Content Area -->
        <main class="flex-1 p-8">
            <h1 class="mb-6 font-bold text-dark text-2xl">لوحة التحكم</h1>
            
            <!-- Academic Year Status Card -->
            <div class="bg-white shadow-md mb-8 p-6 border-accent border-r-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-semibold text-dark text-xl">السنة الدراسية الحالية</h2>
                        <p class="mt-1 text-gray-600">2023/2024 - الفصل الثاني</p>
                        <div class="flex items-center space-x-4 space-x-reverse mt-3">
                            <div>
                                <span class="text-gray-500 text-sm">تاريخ البدء</span>
                                <p class="font-medium">05 سبتمبر 2023</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-sm">تاريخ الانتهاء</span>
                                <p class="font-medium">30 مايو 2024</p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-sm">الحالة</span>
                                <p class="font-medium text-green-600">جارية</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <button class="flex items-center bg-primary hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                            <i class="mr-2 fas fa-archive"></i> أرشفة السنة
                        </button>
                        <button id="startNewYearBtn" class="flex items-center bg-secondary hover:bg-green-700 px-4 py-2 rounded-lg text-white">
                            <i class="mr-2 fas fa-calendar-plus"></i> بدء سنة جديدة
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- New Academic Year Wizard (Hidden by default) -->
            <div id="newYearWizard" class="hidden bg-white shadow-md mb-8 p-6 rounded-lg">
                <h2 class="mb-6 pb-2 border-b font-semibold text-dark text-xl">معالج بدء سنة دراسية جديدة</h2>
                
                <!-- Steps Indicator -->
                <div class="relative flex justify-between mb-8">
                    <div class="flex flex-1 items-center">
                        <div class="flex justify-center items-center bg-primary rounded-full w-8 h-8 text-white">1</div>
                        <div class="flex-1 bg-primary mx-2 h-1"></div>
                    </div>
                    <div class="flex flex-1 items-center">
                        <div class="flex justify-center items-center bg-gray-200 rounded-full w-8 h-8 text-gray-600">2</div>
                        <div class="flex-1 bg-gray-200 mx-2 h-1"></div>
                    </div>
                    <div class="flex flex-1 items-center">
                        <div class="flex justify-center items-center bg-gray-200 rounded-full w-8 h-8 text-gray-600">3</div>
                        <div class="flex-1 bg-gray-200 mx-2 h-1"></div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex justify-center items-center bg-gray-200 rounded-full w-8 h-8 text-gray-600">4</div>
                    </div>
                </div>
                
                <!-- Step 1: Basic Information -->
                <div id="step1" class="step-content">
                    <h3 class="mb-4 font-semibold text-dark text-lg">معلومات السنة الدراسية</h3>
                    
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                        <div>
                            <label class="block mb-1 text-gray-700">اسم السنة الدراسية *</label>
                            <input type="text" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full" 
                                   placeholder="مثال: 2024/2025" required>
                        </div>
                        
                        <div>
                            <label class="block mb-1 text-gray-700">نوع السنة *</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full" required>
                                <option value="">اختر النوع</option>
                                <option>سنة دراسية كاملة</option>
                                <option>فصل دراسي</option>
                                <option>دورة تكوينية</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block mb-1 text-gray-700">تاريخ البدء *</label>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full" required>
                        </div>
                        
                        <div>
                            <label class="block mb-1 text-gray-700">تاريخ الانتهاء *</label>
                            <input type="date" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full" required>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block mb-1 text-gray-700">وصف السنة الدراسية</label>
                        <textarea class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full" 
                                  rows="3" placeholder="أدخل وصفاً مختصراً"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4 space-x-reverse mt-8">
                        <button type="button" class="hover:bg-gray-100 px-6 py-2 border border-gray-300 rounded-lg text-gray-700">
                            إلغاء
                        </button>
                        <button type="button" onclick="nextStep(2)" class="bg-primary hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            التالي <i class="fa-arrow-left ml-2 fas"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Program Structure -->
                <div id="step2" class="hidden step-content">
                    <h3 class="mb-4 font-semibold text-dark text-lg">هيكلة البرامج التعليمية</h3>
                    
                    <div class="bg-gray-50 mb-6 p-4 rounded-lg">
                        <h4 class="mb-3 font-medium text-dark">اختر طريقة إنشاء البرامج:</h4>
                        <div class="flex space-x-4 space-x-reverse">
                            <label class="flex items-center space-x-2 space-x-reverse">
                                <input type="radio" name="programOption" value="copy" checked class="text-primary">
                                <span>نسخ من سنة سابقة</span>
                            </label>
                            <label class="flex items-center space-x-2 space-x-reverse">
                                <input type="radio" name="programOption" value="new" class="text-primary">
                                <span>إنشاء برامج جديدة</span>
                            </label>
                        </div>
                    </div>
                    
                    <div id="copyProgramsSection">
                        <div class="mb-4">
                            <label class="block mb-1 text-gray-700">اختر السنة الدراسية لنسخ البرامج منها</label>
                            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full md:w-1/2">
                                <option value="">2022/2023</option>
                                <option>2021/2022</option>
                                <option>2020/2021</option>
                            </select>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 font-medium text-dark text-right">اختيار</th>
                                        <th class="px-4 py-2 font-medium text-dark text-right">اسم البرنامج</th>
                                        <th class="px-4 py-2 font-medium text-dark text-right">المستوى</th>
                                        <th class="px-4 py-2 font-medium text-dark text-right">المدة</th>
                                        <th class="px-4 py-2 font-medium text-dark text-right">التكلفة</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-2 text-center">
                                            <input type="checkbox" checked class="rounded text-primary">
                                        </td>
                                        <td class="px-4 py-2">رياضيات - ثانوي</td>
                                        <td class="px-4 py-2">الأولى إلى الثالثة ثانوي</td>
                                        <td class="px-4 py-2">9 أشهر</td>
                                        <td class="px-4 py-2">45,000 د.ج</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-center">
                                            <input type="checkbox" checked class="rounded text-primary">
                                        </td>
                                        <td class="px-4 py-2">علوم تجريبية - ثانوي</td>
                                        <td class="px-4 py-2">الأولى إلى الثالثة ثانوي</td>
                                        <td class="px-4 py-2">9 أشهر</td>
                                        <td class="px-4 py-2">45,000 د.ج</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2 text-center">
                                            <input type="checkbox" class="rounded text-primary">
                                        </td>
                                        <td class="px-4 py-2">برنامج الدعم المدرسي</td>
                                        <td class="px-4 py-2">المتوسط</td>
                                        <td class="px-4 py-2">6 أشهر</td>
                                        <td class="px-4 py-2">30,000 د.ج</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="flex items-center mt-4">
                            <input type="checkbox" id="copyTeachers" class="mr-2 rounded text-primary">
                            <label for="copyTeachers">نسخ الأساتذة المرتبطين بهذه البرامج</label>
                        </div>
                    </div>
                    
                    <div id="newProgramsSection" class="hidden">
                        <div class="mb-4">
                            <button class="bg-primary px-4 py-2 rounded-lg text-white">
                                <i class="mr-2 fas fa-plus"></i> إضافة برنامج جديد
                            </button>
                        </div>
                        <p class="text-gray-600">سيتم إضافة واجهة إنشاء البرامج الجديدة هنا</p>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(1)" class="hover:bg-gray-100 px-6 py-2 border border-gray-300 rounded-lg text-gray-700">
                            <i class="fa-arrow-right mr-2 fas"></i> السابق
                        </button>
                        <button type="button" onclick="nextStep(3)" class="bg-primary hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            التالي <i class="fa-arrow-left ml-2 fas"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Assign Teachers -->
                <div id="step3" class="hidden step-content">
                    <h3 class="mb-4 font-semibold text-dark text-lg">تعيين الأساتذة</h3>
                    
                    <div class="bg-blue-50 mb-6 p-4 border border-blue-200 rounded-lg">
                        <div class="flex items-start space-x-3 space-x-reverse">
                            <i class="mt-1 text-blue-500 fas fa-info-circle"></i>
                            <div>
                                <p class="font-medium text-dark">سيتم تعيين الأساتذة للبرامج التي اخترتها</p>
                                <p class="mt-1 text-gray-600 text-sm">يمكنك تعديل التعيينات لاحقاً من لوحة إدارة الأساتذة</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                        <!-- Program 1 -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 font-medium text-dark">رياضيات - ثانوي</h4>
                            
                            <div class="mb-3">
                                <label class="block mb-1 text-gray-700">الأستاذ الرئيسي</label>
                                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full">
                                    <option value="">اختر أستاذاً</option>
                                    <option>أ. محمد بن عمر</option>
                                    <option>أ. خالد قاسم</option>
                                    <option>أ. سميرة بوعلي</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block mb-1 text-gray-700">أساتذة إضافيون</label>
                                <select multiple class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full h-auto">
                                    <option>أ. محمد بن عمر</option>
                                    <option>أ. خالد قاسم</option>
                                    <option>أ. سميرة بوعلي</option>
                                    <option>أ. فاطمة الزهراء</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Program 2 -->
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="mb-3 font-medium text-dark">علوم تجريبية - ثانوي</h4>
                            
                            <div class="mb-3">
                                <label class="block mb-1 text-gray-700">الأستاذ الرئيسي</label>
                                <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full">
                                    <option value="">اختر أستاذاً</option>
                                    <option>أ. محمد بن عمر</option>
                                    <option>أ. خالد قاسم</option>
                                    <option>أ. سميرة بوعلي</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block mb-1 text-gray-700">أساتذة إضافيون</label>
                                <select multiple class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary w-full h-auto">
                                    <option>أ. محمد بن عمر</option>
                                    <option>أ. خالد قاسم</option>
                                    <option>أ. سميرة بوعلي</option>
                                    <option>أ. فاطمة الزهراء</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(2)" class="hover:bg-gray-100 px-6 py-2 border border-gray-300 rounded-lg text-gray-700">
                            <i class="fa-arrow-right mr-2 fas"></i> السابق
                        </button>
                        <button type="button" onclick="nextStep(4)" class="bg-primary hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            التالي <i class="fa-arrow-left ml-2 fas"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Import Students -->
                <div id="step4" class="hidden step-content">
                    <h3 class="mb-4 font-semibold text-dark text-lg">استيراد الطلاب</h3>
                    
                    <div class="bg-gray-50 mb-6 p-6 border-2 border-gray-300 border-dashed rounded-lg text-center">
                        <div class="mx-auto w-3/4">
                            <i class="mb-4 text-green-600 text-4xl fas fa-file-excel"></i>
                            <h4 class="mb-2 font-medium text-dark">اسحب وأفلت ملف Excel هنا</h4>
                            <p class="mb-4 text-gray-600">أو</p>
                            <label class="bg-primary hover:bg-blue-700 px-6 py-3 rounded-lg text-white cursor-pointer">
                                <i class="mr-2 fas fa-upload"></i> اختر ملف
                                <input type="file" class="hidden" accept=".xlsx,.xls,.csv">
                            </label>
                            <p class="mt-4 text-gray-500 text-sm">يدعم الملفات بصيغة XLSX, XLS أو CSV</p>
                        </div>
                    </div>
                    
                    <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 font-medium text-dark text-right">الاسم العائلي</th>
                                    <th class="px-4 py-2 font-medium text-dark text-right">الاسم الشخصي</th>
                                    <th class="px-4 py-2 font-medium text-dark text-right">تاريخ الميلاد</th>
                                    <th class="px-4 py-2 font-medium text-dark text-right">المستوى</th>
                                    <th class="px-4 py-2 font-medium text-dark text-right">الحالة</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-2">بن علي</td>
                                    <td class="px-4 py-2">محمد</td>
                                    <td class="px-4 py-2">15/08/2007</td>
                                    <td class="px-4 py-2">الثانية ثانوي</td>
                                    <td class="px-4 py-2 text-green-600">
                                        <i class="fas fa-check-circle"></i> جاهز
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">قاسم</td>
                                    <td class="px-4 py-2">آمنة</td>
                                    <td class="px-4 py-2">22/05/2006</td>
                                    <td class="px-4 py-2">الثالثة ثانوي</td>
                                    <td class="px-4 py-2 text-green-600">
                                        <i class="fas fa-check-circle"></i> جاهز
                                    </td>
                                </tr>
                                <tr class="bg-red-50">
                                    <td class="px-4 py-2">صالح</td>
                                    <td class="px-4 py-2">يوسف</td>
                                    <td class="px-4 py-2">غير صحيح</td>
                                    <td class="px-4 py-2">-</td>
                                    <td class="px-4 py-2 text-red-600">
                                        <i class="fas fa-exclamation-circle"></i> خطأ
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="flex justify-between items-center bg-yellow-50 mb-6 p-4 border border-yellow-200 rounded-lg">
                        <div class="flex items-start space-x-3 space-x-reverse">
                            <i class="mt-1 text-yellow-500 fas fa-exclamation-triangle"></i>
                            <div>
                                <p class="font-medium text-dark">1 سجل به مشكلة</p>
                                <p class="mt-1 text-gray-600 text-sm">يجب تصحيح الأخطاء قبل المتابعة</p>
                            </div>
                        </div>
                        <button class="text-primary hover:underline">عرض التفاصيل</button>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(3)" class="hover:bg-gray-100 px-6 py-2 border border-gray-300 rounded-lg text-gray-700">
                            <i class="fa-arrow-right mr-2 fas"></i> السابق
                        </button>
                        <button type="button" class="bg-primary hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                            <i class="mr-2 fas fa-save"></i> حفظ وبدء السنة
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Rest of the dashboard content (stats cards, etc.) -->
            
        </main>
    </div>

    <script>
        // Toggle new year wizard
        document.getElementById('startNewYearBtn').addEventListener('click', function() {
            document.getElementById('newYearWizard').classList.toggle('hidden');
        });
        
        // Handle program options
        document.querySelectorAll('input[name="programOption"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if(this.value === 'copy') {
                    document.getElementById('copyProgramsSection').classList.remove('hidden');
                    document.getElementById('newProgramsSection').classList.add('hidden');
                } else {
                    document.getElementById('copyProgramsSection').classList.add('hidden');
                    document.getElementById('newProgramsSection').classList.remove('hidden');
                }
            });
        });
        
        // Wizard navigation
        function nextStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');
            updateStepIndicator(step);
        }
        
        function prevStep(step) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('step' + step).classList.remove('hidden');
            updateStepIndicator(step);
        }
        
        function updateStepIndicator(currentStep) {
            // Reset all steps
            document.querySelectorAll('.flex-1 .w-8').forEach((el, index) => {
                if(index < currentStep - 1) {
                    el.classList.remove('bg-gray-200', 'text-gray-600');
                    el.classList.add('bg-primary', 'text-white');
                    el.nextElementSibling.classList.remove('bg-gray-200');
                    el.nextElementSibling.classList.add('bg-primary');
                } else if(index === currentStep - 1) {
                    el.classList.remove('bg-gray-200', 'text-gray-600');
                    el.classList.add('bg-primary', 'text-white');
                } else {
                    el.classList.remove('bg-primary', 'text-white');
                    el.classList.add('bg-gray-200', 'text-gray-600');
                    if(el.nextElementSibling) {
                        el.nextElementSibling.classList.remove('bg-primary');
                        el.nextElementSibling.classList.add('bg-gray-200');
                    }
                }
            });
        }
    </script>
</body>
</html>