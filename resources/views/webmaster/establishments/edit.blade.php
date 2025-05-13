<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل مؤسسة - نظام الإدارة التعليمية</title>
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
                    <h1 class="font-bold text-gray-800 text-2xl">تعديل مؤسسة</h1>
                    <p class="text-gray-600">عدل المعلومات الخاصة بالمؤسسة</p>
                </div>
                <a href="{{ route('webmaster.dashboard') }}" class="flex items-center space-x-2 space-x-reverse bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-gray-800">
                    <i class="fa-arrow-right fas"></i>
                    <span>رجوع</span>
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('webmaster.establishments.update', $establishment->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                <label for="name" class="block mb-2 text-gray-700">اسم المؤسسة <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('name', $establishment->name ?? '') }}" required>
                            </div>

                            <div>
                                <label for="is_active" class="block mb-2 text-gray-700">الحالة <span class="text-red-500">*</span></label>
                                <select id="is_active" name="is_active" class="px-4 py-2 border border-gray-300 rounded-lg w-full" required>
                                    <option value="1" {{ (old('is_active', $establishment->is_active ?? '') == 1) ? 'selected' : '' }}>نشطة</option>
                                    <option value="0" {{ (old('is_active', $establishment->is_active ?? '') == 0) ? 'selected' : '' }}>غير نشطة</option>
                                </select>
                            </div>

                            <div>
                                <label for="location" class="block mb-2 text-gray-700">العنوان</label>
                                <input type="text" id="location" name="location" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('location', $establishment->location ?? '') }}">
                            </div>

                            <div>
                                <label for="wilaya" class="block mb-2 text-gray-700">الولاية</label>
                                <input type="text" id="wilaya" name="wilaya" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('wilaya', $establishment->wilaya ?? '') }}">
                            </div>

                            <div>
                                <label for="phone" class="block mb-2 text-gray-700">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('phone', $establishment->phone ?? '') }}">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-gray-700">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('email', $establishment->email ?? '') }}">
                            </div>

                            <div>
                                <label for="registration_code" class="block mb-2 text-gray-700">رمز التسجيل</label>
                                <input type="text" id="registration_code" name="registration_code" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('registration_code', $establishment->registration_code ?? '') }}">
                            </div>

                            <div>
                                <label for="logo" class="block mb-2 text-gray-700">شعار المؤسسة</label>
                                <input type="file" id="logo" name="logo" class="px-4 py-2 border border-gray-300 rounded-lg w-full">
                                @if(!empty($establishment->logo))
                                <img src="{{ asset('storage/' . $establishment->logo) }}" alt="شعار المؤسسة" class="mt-2 border rounded-full w-16 h-16">
                                @endif
                            </div>

                            <!-- Manager Info -->
                            <div class="md:col-span-2">
                                <h3 class="mb-4 pb-2 border-gray-200 border-b font-semibold text-gray-800 text-lg">معلومات مدير المؤسسة</h3>
                            </div>

                            <div>
                                <label for="manager_name" class="block mb-2 text-gray-700">اسم المدير</label>
                                <input type="text" id="manager_name" name="manager_name" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('manager_name', $establishment->manager->name ?? '') }}">
                            </div>

                            <div>
                                <label for="manager_email" class="block mb-2 text-gray-700">البريد الإلكتروني للمدير</label>
                                <input type="email" id="manager_email" name="manager_email" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('manager_email', $establishment->manager->email ?? '') }}">
                            </div>

                            <div>
                                <label for="manager_phone" class="block mb-2 text-gray-700">رقم هاتف المدير</label>
                                <input type="tel" id="manager_phone" name="manager_phone" class="px-4 py-2 border border-gray-300 rounded-lg w-full" value="{{ old('manager_phone', $establishment->manager->phone ?? '') }}">
                            </div>

                            <div class="flex justify-end space-x-3 space-x-reverse md:col-span-2 mt-8 pt-6 border-gray-200 border-t">
                                <button type="reset" class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg text-gray-800">
                                    إلغاء
                                </button>
                                <button type="submit" class="flex items-center space-x-2 space-x-reverse bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg text-white">
                                    <i class="fas fa-save"></i>
                                    <span>تحديث المؤسسة</span>
                                </button>
                                {{-- Delete Establishment Button --}}
                                <form action="{{ route('webmaster.establishments.destroy', $establishment->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف المؤسسة؟ سيتم حذف جميع بيانات المؤسسة بشكل نهائي.');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 ml-2 px-6 py-2 rounded-lg text-white">
                                        <i class="fas fa-trash"></i>
                                        حذف المؤسسة
                                    </button>
                                </form>
                                {{-- Delete Admin Button --}}
                                @if($establishment->manager)
                                <form action="{{ route('webmaster.establishments.removeAdmin', $establishment->manager->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف المدير؟');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 ml-2 px-6 py-2 rounded-lg text-white">
                                        <i class="fas fa-user-slash"></i>
                                        حذف المدير
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>