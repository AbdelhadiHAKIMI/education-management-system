<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام الإدارة التعليمية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body {
            font-family: 'Tajawal', sans-serif;
        }
        .login-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1588072432836-e10032774350?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1472&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex justify-center items-center p-4 min-h-screen login-bg">
    <div class="bg-white shadow-2xl rounded-xl w-full max-w-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 px-8 py-6 text-center">
            <div class="flex justify-center items-center space-x-3 space-x-reverse">
                <i class="text-white text-3xl fas fa-graduation-cap"></i>
                <h1 class="font-bold text-white text-2xl">نظام الإدارة التعليمية</h1>
            </div>
            <p class="mt-2 text-blue-200">تسجيل الدخول إلى لوحة التحكم</p>
        </div>
        
        <!-- Form -->
        <form class="space-y-6 p-8">
            <div>
                <label for="email" class="block mb-2 text-gray-700">البريد الإلكتروني أو اسم المستخدم</label>
                <div class="relative">
                    <div class="right-0 absolute inset-y-0 flex items-center pr-3 text-gray-500 pointer-events-none">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" id="email" class="py-3 pr-10 pl-4 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="ادخل بريدك الإلكتروني">
                </div>
            </div>
            
            <div>
                <label for="password" class="block mb-2 text-gray-700">كلمة المرور</label>
                <div class="relative">
                    <div class="right-0 absolute inset-y-0 flex items-center pr-3 text-gray-500 pointer-events-none">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" id="password" class="py-3 pr-10 pl-4 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full" placeholder="ادخل كلمة المرور">
                </div>
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="border-gray-300 rounded focus:ring-blue-500 w-4 h-4 text-blue-600">
                    <label for="remember" class="block mr-2 text-gray-700 text-sm">تذكرني</label>
                </div>
                <a href="#" class="text-blue-600 text-sm hover:underline">نسيت كلمة المرور؟</a>
            </div>
            
            <button type="submit" class="flex justify-center items-center space-x-2 space-x-reverse bg-blue-700 hover:bg-blue-800 px-4 py-3 rounded-lg w-full font-medium text-white transition duration-200">
                <i class="fas fa-sign-in-alt"></i>
                <span>تسجيل الدخول</span>
            </button>
            
            <div class="text-gray-600 text-sm text-center">
                ليس لديك حساب؟ <a href="#" class="text-blue-600 hover:underline">اتصل بمدير النظام</a>
            </div>
        </form>
    </div>
</body>
</html>